<?php
$conn = mysqli_connect("localhost", "root", "", "midnight_motors");

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>