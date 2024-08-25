<?php
include('connection.php');

// Retrieve the ID from the query string and sanitize it
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Check if the ID is valid
if ($id > 0) {
    // Create the SQL DELETE query
    $sql = "DELETE FROM `user` WHERE id = $id";

    // Execute the query
    $res = mysqli_query($conn, $sql);

    if ($res) {
        // If deletion was successful, redirect to the list page
        header('Location: userlist.php');
        exit(); // Ensure no further code is executed
    } else {
        // If there was an error, show an alert
        echo "<script>alert('Error executing query: " . mysqli_error($conn) . "')</script>";
    }
} else {
    // If the ID is not valid, show an alert
    echo "<script>alert('Invalid ID')</script>";
}

// Close the database connection
mysqli_close($conn);
?>
