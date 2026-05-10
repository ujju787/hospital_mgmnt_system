<?php
include('db_connect.php');
$result = mysqli_query($conn, 'DESCRIBE bookings');
echo "Table structure:\n";
while($row = mysqli_fetch_assoc($result)) {
    echo $row['Field'] . ' - ' . $row['Type'] . "\n";
}
?>