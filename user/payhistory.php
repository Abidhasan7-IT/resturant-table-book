<?php
include 'connection.php';

session_start();

// Redirect to login if the user is not authenticated
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}

$email= $_SESSION['email'];
// Fetch records with limit and offset
$sql = "SELECT * FROM `payment` where email='$email' ORDER BY `p_id` DESC ";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
$rows = $result->num_rows; // Get the number of rows returned
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User</title>
    <link rel="stylesheet" href="userstyle.css">
    <link rel="icon" href="../assets/img/favicon.ico">
    <link href="https://cdn.datatables.net/v/bs5/dt-2.1.3/b-3.1.1/b-html5-3.1.1/b-print-3.1.1/datatables.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>
<body>
    <?php include "Nav.php"; ?>

    
    <div class="container" style="margin-top: 5rem;">
        <?php if ($rows > 0): ?>
            <div class="table-responsive">
            <h3 class="text-center text-success fw-bold">Payment List</h3>
                <table class="table table-striped table-bordered text-center mt-2" id="example">
                    <thead class="table-dark">
                        <tr>
                            <th>res_Id</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>TableNo</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Timeslot</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['resid']); ?></td>
                                <td><?php echo htmlspecialchars($row['name']); ?></td>
                                <td><?php echo htmlspecialchars($row['email']); ?></td>
                                <td><?php echo htmlspecialchars($row['Tableno']); ?></td>
                                <td><?php echo htmlspecialchars($row['amount']); ?></td>
                                <td><?php echo htmlspecialchars($row['date']); ?></td>
                                <td><?php echo htmlspecialchars($row['timeslot']); ?></td>
                                <td><?php echo htmlspecialchars($row['status']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-info text-center" role="alert">
                No records found.
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/v/bs5/dt-2.1.3/b-3.1.1/b-html5-3.1.1/b-print-3.1.1/datatables.min.js"></script>

    <script>
    $(document).ready(function() {
        var table = $('#example').DataTable({
            buttons: ['pdf', 'print'],
            dom: 'Bfrtip' // Include buttons in the DOM
        });

        table.buttons().container().appendTo('#example_wrapper .col-md-6:eq(0)');
    });
    </script>
</body>
</html>
