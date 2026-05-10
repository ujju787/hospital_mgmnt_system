<?php
include('db_connect.php');

// Clear sample booking data
mysqli_query($conn, "DELETE FROM bookings");
echo "Sample bookings data cleared\n";

// Optional: Clear other sample data if needed
// mysqli_query($conn, "DELETE FROM patients");
// mysqli_query($conn, "DELETE FROM appointments");
// mysqli_query($conn, "DELETE FROM messages");
// mysqli_query($conn, "DELETE FROM feedback");

echo "Ready for real data!\n";
?>