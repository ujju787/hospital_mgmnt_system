<?php
session_start();
$_SESSION['admin_id'] = 1;
$_SESSION['admin_name'] = 'Admin User';
include('db_connect.php');

echo "=== TESTING BOOKINGS DISPLAY ===\n";
$recent_bookings_query = "SELECT * FROM bookings ORDER BY created_at DESC LIMIT 5";
$result = mysqli_query($conn, $recent_bookings_query);

if ($result) {
    echo "Found " . mysqli_num_rows($result) . " bookings:\n\n";
    while($row = mysqli_fetch_assoc($result)) {
        echo "Name: " . $row['full_name'] . "\n";
        echo "Date/Time: " . $row['booking_date'] . " " . $row['booking_time'] . "\n";
        echo "Hospital: " . $row['hospital'] . "\n";
        echo "Doctor: " . $row['doctor'] . "\n";
        echo "Status: " . $row['status'] . "\n";
        echo "Booked: " . $row['created_at'] . "\n";
        echo "---\n";
    }
} else {
    echo "Error: " . mysqli_error($conn) . "\n";
}
?>
