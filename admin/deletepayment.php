<?php
include('connection.php');
$id = $_GET['id'];

    $sql = 'Delete from payment where p_id='.$id;
    $res = mysqli_query($conn,$sql);
    echo "<script>alert('Deleted successfully')</script>";
    header('location:reservations.php');
?>