<?php
include 'connection.php';

session_start();

if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}

$id = $_GET['id'];
$email = $_SESSION['email'];

// Fetch records from the reservation table based on the user's email
$sql = "SELECT * FROM reservation WHERE table_id='$id' AND email='$email' ORDER BY table_id DESC";
$result = $conn->query($sql);

function isPaid($res_id, $conn) {
    $stmt = $conn->prepare("SELECT status FROM payment WHERE resid = ?");
    $stmt->bind_param("i", $res_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        return $row['status'] === 'paid';
    }
    return false;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User</title>
    <link rel="stylesheet" href="userstyle.css">
    <link href="../assets/img/favicon.ico" rel="icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>
    <?php include "Nav.php"; ?>

    <div class="container" style="margin-top: 5rem;">
        <h3 class="text-center text-success mb-4">Pay Process</h3>
        <div class="table-responsive">
            <table class="table table-striped table-bordered text-center">
                <thead class="table-dark">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>TableNo</th>
                        <th>Amount</th>
                        <th>Date</th>
                        <th>TimeSlot</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['table']); ?></td>
                            <td><?php echo htmlspecialchars($row['amount']); ?></td>
                            <td><?php echo htmlspecialchars($row['date']); ?></td>
                            <td><?php echo htmlspecialchars($row['timeslot']); ?></td>
                            <td>
                                <?php if (isPaid($row['res_id'], $conn)): ?>
                                    <span class="text-success">Paid</span>
                                    <a href="deletebook.php?id=<?php echo $row['res_id']; ?>" class="btn btn-danger btn-sm">X</a>
                                <?php else: ?>
                                    <a href="deletebook.php?id=<?php echo $row['res_id']; ?>" class="btn btn-danger btn-sm">X</a>
                                    <a href="payment.php?id=<?php echo $row['res_id']; ?>" class="btn btn-success btn-sm">Pay</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
</body>

</html>

<style>
    .table thead th {
        background-color: #343a40; /* Darker background for the table header */
        color: #ffffff; /* White text color */
    }

    .table tbody tr:nth-child(even) {
        background-color: #f2f2f2; /* Light grey background for even rows */
    }

    .table tbody tr:hover {
        background-color: #eaeaea; /* Slightly darker grey on row hover */
    }
</style>
