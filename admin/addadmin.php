
<?php
session_start();
require "includes/functions.php";
require "connection.php";

if (!isset($_SESSION['name'])) {
    header('Location: login.php');
    exit();
}

$msg = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $name = htmlentities($_POST['name'], ENT_QUOTES, 'UTF-8');
    $password = htmlentities($_POST['pass'], ENT_QUOTES, 'UTF-8');
    
    if ($name != "" && $password != "" ) {
        $stmt = $conn->prepare("SELECT * FROM `admin` WHERE name = ? LIMIT 1");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows) {
            $msg = "<p style='color:red; padding: 10px; background: #ffeeee;'>No duplicate name allowed. Try again!!!😥</p>";
        } else {
            //insert admin database table into
            $pass_en = md5($password);
            $stmt = $conn->prepare("INSERT INTO `admin` (name, pass) VALUES (?, ?)");
            $stmt->bind_param("ss", $name, $pass_en);
            
            if ($stmt->execute()) {
                $msg = "<p style='color:green; padding: 10px; background: #eeffee;'>NewAdmin successfully saved</p>";
            } else {
                $msg = "<p style='color:red; padding: 10px; background: #ffeeee;'>Could not insert record, try again</p>";
            }
        }
        $stmt->close();
    } else {
        $msg = "<p style='color:red; padding: 10px; background: #ffeeee;'>Incomplete form data</p>";
    }
}

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
    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Animation library for notifications -->
    <link href="assets/css/animate.min.css" rel="stylesheet" />
    <!-- Light Bootstrap Table core CSS -->
    <link href="assets/css/light-bootstrap-dashboard.css" rel="stylesheet" />
    <!-- CSS for Demo Purpose -->
    <link href="assets/css/demo.css" rel="stylesheet" />
    <!-- Fonts and icons -->
    <link href="assets/css/pe-icon-7-stroke.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
</head>

<body>
    <div class="wrapper">
        <div class="sidebar" data-color="black">
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
                            <a class="navbar-brand" href="#" style="color: #fff;">ADD ADMIN </a>
                        </div>
                        <div class="collapse navbar-collapse">
                            <ul class="nav navbar-nav navbar-right">
                                <li>
                                    <a href="logout.php" style="color: #fff;">Logout</a>
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
                                        <h4 class="title">ADD ADMIN</h4>
                                    </div>
                                    <div class="content">
                                        <form method="post" action="addadmin.php" enctype="multipart/form-data">
                                            
                                            <div class="row">
                                                <div class="col-md-12">
                                                <?php echo $msg; ?>
                                                    <div class="form-group">
                                                        <label style="color: #333" for="name">Name</label>
                                                        <input type="text" name="name" id="price" class="form-control" placeholder="Enter name.. " required />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label style="color: #333" for="pass">Password</label>
                                                        <input id="pass" type="text" class="form-control" placeholder="Enter password.." name="pass" required></input>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="submit" name="submit" style="background: #27ae60; border: 1px solid #27ae70" value="Save Table" class="btn btn-info btn-fill pull-right" />
                                            <div class="clearfix"></div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <footer class="footer">
                    <div class="container-fluid">
                        <p class="copyright pull-right">
                            &copy; 2024 <a href="#" style="color: #FF5722;">Delicious Restaurant</a>
                        </p>
                    </div>
                </footer>
            </div>
        </div>
    </div>
</body>

<!-- Core JS Files -->
<script src="assets/js/jquery-1.10.2.js" type="text/javascript"></script>
<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
<!-- Checkbox, Radio & Switch Plugins -->
<script src="assets/js/bootstrap-checkbox-radio-switch.js"></script>
<!-- Charts Plugin -->
<script src="assets/js/chartist.min.js"></script>
<!-- Notifications Plugin -->
<script src="assets/js/bootstrap-notify.js"></script>
<!-- Light Bootstrap Table Core javascript -->
<script src="assets/js/light-bootstrap-dashboard.js"></script>
<!-- Light Bootstrap Table DEMO methods -->
<script src="assets/js/demo.js"></script>

</html>
