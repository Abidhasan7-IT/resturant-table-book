<?php
session_start();
require "includes/functions.php";
require "connection.php";

if (!isset($_SESSION['name'])) {
    header('Location: login.php');
    exit();
}

// Handle search query
$search = '';
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $search = htmlspecialchars($search); // Sanitize the search input
}

// Fetch records with search query and pagination
$sql = "SELECT * FROM `payment` WHERE `name` LIKE ? OR `email` LIKE ? OR `Tableno` LIKE ? OR `amount` LIKE ? ORDER BY `p_id` DESC";
$stmt = $conn->prepare($sql);

// Prepare parameters for the search query
$searchParam = "%$search%";
$stmt->bind_param('ssss', $searchParam, $searchParam, $searchParam, $searchParam);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->num_rows; // Get the number of rows returned
?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="icon" type="image/png" href="../assets/img/favicon.ico">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Delicius Restaurant</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

    <!-- Bootstrap core CSS     -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Animation library for notifications   -->
    <link href="assets/css/animate.min.css" rel="stylesheet"/>
    <!--  Light Bootstrap Table core CSS    -->
    <link href="assets/css/light-bootstrap-dashboard.css" rel="stylesheet"/>
    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="assets/css/demo.css" rel="stylesheet" />
    <!--     Fonts and icons     -->
    <link href="assets/css/pe-icon-7-stroke.css" rel="stylesheet" />

    <link href="assets/css/style.css" rel="stylesheet" />

	
</head>
<body>

<div class="wrapper">
<div class="sidebar" data-color="black" >

<?php require "includes/side_wrapper.php"; ?>

<div class="main-panel">
<nav class="navbar navbar-default navbar-fixed" style="background: #27ae70;">
    <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example-2">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar" style="background: #fff;"></span>
                        <span class="icon-bar" style="background: #fff;"></span>
                        <span class="icon-bar" style="background: #fff;"></span>
                    </button>
                    <a class="navbar-brand" href="#" style="color: #fff;">RESERVATIONS </a>
                </div>
                <div class="collapse navbar-collapse">

                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a href="logout.php" style="color: #fff;">
                                Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>


        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">RESERVATIONS LIST</h4>
                            </div>
                            <form class="form-inline float-right" method="GET" action="">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="search" placeholder="Search" value="<?php echo htmlspecialchars($search); ?>">
                                    </div>
                                    <button type="submit" class="btn btn-primary" style="margin-right:1rem;">Search</button>
                                    <button type="button" class="btn btn-success " onclick="printTable()">Print</button>
                                </form>

                            <?php if ($row > 0): ?>
                            <div class="content table-responsive">
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
                            <th>Action</th>
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
                                <td>
                                    <a href="deletepayment.php?id=<?php echo $row['p_id']; ?>" class="btn btn-danger btn-sm">X</a>
                            </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>  
        <?php else: ?>
            <div class="alert alert-info text-center" role="alert">
                No records found.
            </div>
        <?php endif; ?>

                            </div>
                        </div>
                    </div>                    

                </div>
            </div>
        </div>


        <footer class="footer">
            <div class="container-fluid">
                
                <p class="copyright pull-right">
                    &copy; 2024 <a href="#" style="color: #FF5722;">delicious Restaurant</a>
                </p>
            </div>
        </footer>

    </div>
</div>

<script>
function printTable() {
    var table = document.getElementById("example");
    var newWindow = window.open('', '', 'height=500,width=700');
    newWindow.document.write('<html><head><title>Print</title>');
    newWindow.document.write('<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">'); // Include any required CSS
    newWindow.document.write('</head><body >');
    newWindow.document.write('<h4 class="text-center mb-4">Reservations List</h4>');
    newWindow.document.write(table.outerHTML);
    newWindow.document.write('</body></html>');
    newWindow.document.close();
    newWindow.focus();
    newWindow.print();
}
</script>

</body>

    <!--   Core JS Files   -->
    <script src="assets/js/jquery-1.10.2.js" type="text/javascript"></script>
	<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>

	<!--  Checkbox, Radio & Switch Plugins -->
	<script src="assets/js/bootstrap-checkbox-radio-switch.js"></script>

	<!--  Charts Plugin -->
	<script src="assets/js/chartist.min.js"></script>

    <!--  Notifications Plugin    -->
    <script src="assets/js/bootstrap-notify.js"></script>

    <!--  Google Maps Plugin    -->
    
    <!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
	<script src="assets/js/light-bootstrap-dashboard.js"></script>

	<!-- Light Bootstrap Table DEMO methods, don't include it in your project! -->
	<script src="assets/js/demo.js"></script>


</html>

