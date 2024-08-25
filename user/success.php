<?php
include('connection.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// Retrieve reservation ID from GET request
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Check if ID is valid
if ($id <= 0) {
    die("Invalid reservation ID.");
}

// Prepare the SQL statement to fetch reservation details
$stmt = $conn->prepare("SELECT * FROM reservation WHERE res_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

// Check if any reservation is found
if ($result->num_rows > 0) {
    // Fetch reservation details
    $row = $result->fetch_assoc();
    $resid = $row['res_id'];
    $name = $row['name'];
    $email = $row['email'];
    $date = $row['date'];
    $table = $row['table'];
    $amount = $row['amount'];
    $timeslot = $row['timeslot'];
} else {
    die("Reservation not found.");
}

// Handle payment submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Prepare the SQL statement to insert payment details
    $stmt = $conn->prepare("INSERT INTO payment (resid, name, email, Tableno, amount, date, timeslot, status) VALUES (?, ?, ?, ?, ?, ?, ?, 'paid')");
    $stmt->bind_param("ssssiss", $resid, $name, $email, $table, $amount, $date, $timeslot);
    
    if ($stmt->execute()) {

        
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
                    $mail->Body    = "Congratulation, Your payment has been successfully done , please check your payment history 😊";
                    
                    // Send email
                    $mail->send();
                    
                    echo "<b class='text-success text-center'>Message has been sent to $email</b>";
                } catch (Exception $e) {
                    echo "<b class='text-danger text-center'>Message could not be sent. Mailer Error: {$mail->ErrorInfo}</b>";
                }

        header("Location: payhistory.php");
        exit();
    } else {
        die("Error processing payment: " . $stmt->error);
    }
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Successful Payment</title>
    <link rel="shortcut icon" href="../assets/img/favicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="vh-100 d-flex justify-content-center align-items-center">
        <div>
            <div class="mb-4 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="text-success" width="75" height="75" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                </svg>
            </div>
            <div class="text-center">
                <h1>Thank You!</h1>
                <p>We have received your payment. Please confirm by clicking the button below. 🎉🎉🎉</p>
                
                <form method="post">
                    <button type="submit" class="btn btn-primary">Send Done</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
