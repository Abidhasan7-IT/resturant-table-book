<?php
include('connection.php');

if(isset($_POST['submit'])){
    session_start();
    $name = $_POST['name'];
    $pass = $_POST['pass'];
    $pass_de = md5($pass);
    echo $pass_de;
    $sql = "SELECT * FROM admin WHERE name='$name' AND pass='$pass_de'";
		$result = mysqli_query($conn, $sql);
		if ($result->num_rows > 0) {
            $row = mysqli_fetch_assoc($result);
            $_SESSION['name'] = $row['name'];
            $_SESSION['pass'] = $row['pass'];
            header('location:admin.php');
        }
        else{
            echo "<script>alert('Wrong credentials ❌')</script>" ;
        }
   
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="shortcut icon" href="../assets/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="adminstyle.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

</head>

<body>
<?php include('adminNav.php');?>
    <section class="form">
        <div class="contents">
            <div class="content">
                <h1 class="text-center" style="color: white;">Admin Login</h1>
                <form action="login.php" method="POST" class="d-flex flex-column justify-content-center align-items-spacebetween">
                    <div class="form-group mt-3">
                        <input id="name" name="name" type="text" required>
                        <label  for="name">Name</label>
                    </div>
                    <div class="form-group">
                        <input id="name" name="pass" type="password" required>
                        <label for="name">Password</label>
                    </div>
                    <input class="btn btn-outline-success mt-3" type="submit" name="submit" value="Login">
                </form>
                
            </div>
            <div class="content-text">
                <h2 class=" h-100 p-3  d-flex align-items-center">
                     ADMIN LOGIN SYSTEM
                </h2>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
            integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
            crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
            integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
            crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js"
            integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
            crossorigin="anonymous"></script>    </section>
</body>
 
</html>