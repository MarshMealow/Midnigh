<?php
session_start();
include 'db.php';

if (!isset($_SESSION['seller_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $car_id = $_GET['id'];
    $seller_id = $_SESSION['seller_id'];

    $sql = "DELETE FROM cars 
            WHERE car_id='$car_id' 
            AND seller_id='$seller_id'";

    mysqli_query($conn, $sql);
}

header("Location: cars.php");
exit();
?>