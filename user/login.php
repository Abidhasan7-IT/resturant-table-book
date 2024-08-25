<?php

include('connection.php');

if(isset($_POST['submit'])){
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = mysqli_real_escape_string($conn, $_POST['pass']);
    $pass_en = md5($pass); // MD5 should ideally be replaced with stronger hashing methods

    $sql = "SELECT * FROM user WHERE `email`='$email' AND pass='$pass_en'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        session_start();
        $_SESSION['email'] = $row['email']; 
        $_SESSION['pass'] = $row['name'];   
        header('Location: user.php');       // Redirect to user.php 
        exit();
    } else {
        echo "<script>alert('Wrong credentials ❌')</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <link href="../assets/img/favicon.ico" rel="icon">
    <link rel="stylesheet" href="userstyle.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

</head>

<body>
    <?php include('Nav.php'); ?>
    <section class="form">
        <div class="contents">
            <div class="content">
                <h1 class="text-center" style="color: white;">User Login</h1>
                <form action="login.php" method="POST" class="d-flex flex-column justify-content-center align-items-spacebetween">
                    <div class="form-group mt-3">
                        <input id="email" name="email" type="email" required>
                        <label for="email">Email</label>
                    </div>
                    <div class="form-group">
                        <input id="pass" name="pass" type="password" required>
                        <label for="pass">Password</label>
                    </div>
                    <input class="btn btn-outline-success mt-3" type="submit" name="submit" value="Login">
                </form>
                <div class="text-light mt-3">
                    Not registered? <a href="registration.php">Register Now</a>
                </div>
                <div class="text-center text-light"> <a href="forgetpassword.php">Forget </a>Password</div>
            </div>
            <div class="content-text">
                <h2 class=" h-100 p-3  d-flex align-items-center">
                     USER LOGIN SYSTEM
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
            crossorigin="anonymous"></script>
    </section>
</body>

</html>
