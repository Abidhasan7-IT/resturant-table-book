<?php
include('connection.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $cpass = $_POST['cpass'];
    $number = $_POST['p_number'];

    // Check if the passwords match
    if ($pass === $cpass) {
        // Encrypt password
        $pass_en = md5($pass);

        // Check if email already exists in the database
        $check_email_query = "SELECT * FROM user WHERE email = '$email'";
        $check_email_result = mysqli_query($conn, $check_email_query);

        if (mysqli_num_rows($check_email_result) > 0) {
            // If email already exists
            echo "<script>alert('Your Email is already registered 😑')</script>";
        } else {
            // Insert new user into database
            $sql = "INSERT INTO user (`name`, `email`, `pass`, `p_number`) VALUES ('$name', '$email', '$pass_en', '$number')";
            if (mysqli_query($conn, $sql)) {
                echo "<script>alert('Account Has been Created Successfully ✅')</script>";

                // Confirmation mail
                $mail = new PHPMailer(true);

                try {
                    // Server settings
                    $mail->isSMTP();                                            // Send using SMTP
                    $mail->Host       = 'smtp.gmail.com';                        // Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                    $mail->Username   = 'abidhasanstudent20@gmail.com';          // SMTP username
                    $mail->Password   = 'rxrvhdpgdxdwmvsn';                     // SMTP password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            // Enable implicit TLS encryption
                    $mail->Port       = 465;                                    // TCP port to connect to
        
                    // Recipients
                    $mail->setFrom('abidhasanstudent20@gmail.com', 'Delicious Restaurant');
                    $mail->addAddress($email, $name);                           // Add a recipient
        
                    // Content
                    $mail->isHTML(true);                                        // Set email format to HTML
                    $mail->Subject = "Hi, $name";
                    $mail->Body    = "Welcome to our Delicious Restaurant site. You are Successfully Registered 😊, Now you can log in..";
                    
                    // Send email
                    $mail->send();
                    
                    echo "<b class='text-success text-center'>Message has been sent to $email</b>";
                } catch (Exception $e) {
                    echo "<b class='text-danger text-center'>Message could not be sent. Mailer Error: {$mail->ErrorInfo}</b>";
                }
            } else {
                echo "<script>alert('Error: '. $sql . '<br>' . mysqli_error($conn))</script>";
            }
        }
    } else {
        echo "<script>alert('Your passwords do not match 😑')</script>";
    }

    $conn->close();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Register</title>
    <link href="../assets/img/favicon.ico" rel="icon">
    <link rel="stylesheet" href="userstyle.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>
<body>
    <?php include('Nav.php'); ?>

    <section class="form">
        <div class="contents">
            <div class="content">
                <h4 class="text-light">Create User Account</h4>
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data" method="POST" class="d-flex flex-column justify-content-center">
                    <div class="form-group">
                        <input id="name" name="name" type="text" required>
                        <label for="name">Name</label>
                    </div>
                    <div class="form-group">
                        <input id="email" name="email" type="email" required>
                        <label for="email">Email</label>
                    </div>
                    <div class="form-group">
                        <input id="pass" name="pass" type="password" required>
                        <label for="pass">Password</label>
                    </div>
                    <div class="form-group">
                        <input id="cpass" name="cpass" type="password" required>
                        <label for="cpass">Confirm Password</label>
                    </div>
                    <div class="form-group">
                        <input id="p_number" name="p_number" type="number" required>
                        <label for="p_number">Phone Number</label>
                    </div>
                    <input class="btn btn-outline-success mt-2" name="submit" type="submit" value="Register" style="width: 50%; margin:auto;">
                </form>
                <div class="text-light mt-1">
                    Already have an account? <a href="login.php">Login</a>
                </div>
            </div>
            <div class="content-text">
                <h2 class="h-100 p-3 d-flex align-items-center">
                    USER REGISTRATION SYSTEM
                </h2>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    </section>
</body>
</html>
