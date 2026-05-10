<?php
include('db_connect.php');
$result = mysqli_query($conn, 'SELECT COUNT(*) as count FROM bookings');
$row = mysqli_fetch_assoc($result);
echo 'Current bookings: ' . $row['count'] . "\n";
?>