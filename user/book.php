<?php
include 'connection.php';

session_start();

if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;  // Ensure $id is properly set
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $table = mysqli_real_escape_string($conn, $_POST['table']);
    $amount = mysqli_real_escape_string($conn, $_POST['price']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);
    $time_slot = mysqli_real_escape_string($conn, $_POST['time_slot']);
    $partial_amount = isset($_POST['partial']) ? mysqli_real_escape_string($conn, $_POST['partial']) : NULL;

    // Determine final amount
    $final_amount = $partial_amount ? $partial_amount : $amount;

    // Check if the table is already booked for the given date and time slot
    $sql_check = "SELECT COUNT(*) as count FROM reservation WHERE table_id = ? AND date = ? AND timeslot = ?";
    $stmt_check = $conn->prepare($sql_check);
    if (!$stmt_check) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt_check->bind_param("iss", $id, $date, $time_slot);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();
    $row_check = $result_check->fetch_assoc();
    if ($row_check['count'] > 0) {
        echo '<script>alert("The table is already booked for the selected date and time slot.😥");  window.location.href = "reservation.php"</script>';
    }
    $stmt_check->close();

    $stmt = $conn->prepare("INSERT INTO reservation(table_id, name, email, amount, `table`, date, timeslot) VALUES (?, ?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    
    // Bind parameters
    $stmt->bind_param("sssssss", $id, $name, $email, $final_amount, $table, $date, $time_slot);
        
    // Execute query and check for errors
    if ($stmt->execute()) {
        echo '<script>alert("Reservation details have been recorded successfully."); window.location.href = "setpay.php?id=' . $id . '";</script>';
    } else {
        die("Error: " . $stmt->error);
    }
    $stmt->close();
}

// Fetch table data from the database
$sql_table = "SELECT t_name, amount FROM `table` WHERE tid = ?";
$stmt = $conn->prepare($sql_table);
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param("i", $id);
$stmt->execute();
$result_table = $stmt->get_result();

if (!$result_table) {
    die("Database query failed: " . $conn->error);
}

$row_table = $result_table->fetch_assoc();
if (!$row_table) {
    die("No table data found for the given ID.");
}

$t_name = $row_table['t_name'];
$amount = $row_table['amount'];

// Fetch user data from the database
$email = $_SESSION['email'];
$sql_user = "SELECT name, email FROM user WHERE email=?";
$stmt = $conn->prepare($sql_user);
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param("s", $email);
$stmt->execute();
$result_user = $stmt->get_result();

if (!$result_user) {
    die("Database query failed: " . $conn->error);
}

$row_user = $result_user->fetch_assoc();
if (!$row_user) {
    die("No user data found for the given email.");
}

$user_name = $row_user['name'];
$user_email = $row_user['email'];

$stmt->close();
$conn->close();

// Generate current date
$current_date = date('Y-m-d');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Table</title>
    <link rel="stylesheet" href="userstyle.css">
    <link href="../assets/img/favicon.ico" rel="icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <style>
        .partial-pay-input {
            display: none;
        }
    </style>
</head>
<body>
    <?php include "Nav.php"; ?>

    <div class="container mt-5 text-light">
        <div class="form mt-5 p-5 bg-dark rounded">
            <form method="post" action="book.php?id=<?php echo $id; ?>" enctype="multipart/form-data">
                <h3 class="text-center mb-4">Book Table</h3>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group fw-bold">
                            <label for="name" class="form-label text-white">Name</label>
                            <input type="text" id="name" name="name" class="form-control" value="<?php echo htmlspecialchars($user_name); ?>" required />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group fw-bold">
                            <label for="email" class="form-label text-white">Email</label>
                            <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user_email); ?>" required />
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group fw-bold">
                            <label for="table" class="form-label text-white">Table No</label>
                            <input type="text" id="table" name="table" class="form-control" value="<?php echo htmlspecialchars($t_name); ?>" readonly />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group fw-bold">
                            <label for="price" class="form-label text-white">Amount</label>
                            <input type="number" id="price" name="price" class="form-control" value="<?php echo htmlspecialchars($amount); ?>" readonly />
                        </div>
                        <div class="form-group mt-1">
                            <div class="form-check">
                                <input type="checkbox" id="partial-pay-checkbox" class="form-check-input">
                                <label for="partial-pay-checkbox" class="form-check-label text-white fw-bold">Partial Pay</label>
                                <div id="partial-pay-input" class="partial-pay-input mt-2">
                                    <input type="number" min="300" name="partial" class="form-control" placeholder="Enter partial amount" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="date" class="form-label text-white fw-bold">Date</label>
                            <input type="date" id="date" name="date" class="form-control" min="<?php echo $current_date; ?>" required />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label text-white fw-bold">Time Slot</label>
                            <select name="time_slot" class="form-control" required>
                                <option value="">Select Time slot</option>
                                <option value="10:00AM-11:30AM">10:00AM-11:30AM</option>
                                <option value="2:30PM-5:00PM">2:30PM-5:00PM</option>
                                <option value="7:00PM-10:00PM">7:00PM-10:00PM</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-success mt-3">Set Pay</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkbox = document.getElementById('partial-pay-checkbox');
            const partialPayInput = document.getElementById('partial-pay-input');

            checkbox.addEventListener('change', function() {
                if (checkbox.checked) {
                    partialPayInput.style.display = 'block';
                } else {
                    partialPayInput.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>
