<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Forget Password</title>
    <link rel="shortcut icon" href="../assets/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="userstyle.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>
<body>
    <div class="m-5 pb-4 text-center">
        <form method="post" class="mb-5">
            <h3><b>Recover Password</b></h3>
            <input type="text" name="email" placeholder="Enter your email.." required>
            <input type="submit" name="submit" class="bg-danger text-light p-1">
        </form>
        <div>
            <a href="login.php" class="bg-info text-light p-1">LOG IN</a>
        </div>
    </div>

    
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if(isset($_POST['submit'])){
    $to_email = $_POST['email'];
    include('connection.php');
    
    // Ensure the email is safe to use in SQL (preventing SQL injection)
    $safe_email = mysqli_real_escape_string($conn, $to_email);
    
    $query = "SELECT * FROM user WHERE email='$safe_email'";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0){
        $rows = mysqli_fetch_assoc($result);
        $R_password = $rows['pass'];
        $name = $rows['name'];

        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                        //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'abidhasanstudent20@gmail.com';          //SMTP username
            $mail->Password   = 'ywzkwhvjksizjbop';                     //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to

            //Recipients
            $mail->setFrom('abidhasanstudent20@gmail.com', 'Delicious Restaurant');
            $mail->addAddress($to_email, $name);                       //Add a recipient

            //Content
            $mail->isHTML(true);                                        //Set email format to HTML
            $mail->Subject = 'Password Recovery for Delicious Restaurant site';
            $mail->Body    = "Your Password is : $R_password ";
            
            // Send email
            $mail->send();
            
            echo "<b class='text-success text-center'>Message has been sent to $to_email</b>";
        } catch (Exception $e) {
            echo "<b class='text-danger text-center'>Message could not be sent. Mailer Error: {$mail->ErrorInfo}</b>";
        }
    } else {
        echo "<b class='text-warning text-center'>Your email does not exist in our records.</b>";
    }
}
?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>

