<?php
session_start();
include('db_connect.php');

echo "=== DATABASE CONNECTION TEST ===\n";
echo "DB Connected: " . ($conn ? "YES" : "NO") . "\n\n";

echo "=== TABLES IN DATABASE ===\n";
$result = mysqli_query($conn, "SHOW TABLES");
while($row = mysqli_fetch_array($result)) {
    echo "- " . $row[0] . "\n";
}

echo "\n=== CHECKING ADMINS TABLE ===\n";
$admins = mysqli_query($conn, "SELECT * FROM admins");
echo "Total admins: " . mysqli_num_rows($admins) . "\n";
while($row = mysqli_fetch_assoc($admins)) {
    echo "ID: " . $row['id'] . ", Mobile: " . $row['mobile_number'] . ", Name: " . $row['full_name'] . "\n";
}

echo "\n=== TEST LOGIN WITH CREDENTIALS ===\n";
$mobile = '9876543210';
$password = 'Hackathon-2026';
$sql = "SELECT id, full_name, password FROM admins WHERE mobile_number = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $mobile);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($result)) {
    echo "Admin found! Name: " . $row['full_name'] . "\n";
    if ($password == "Hackathon-2026") {
        echo "PASSWORD MATCH - Login would succeed!\n";
    } else {
        echo "PASSWORD MISMATCH\n";
    }
} else {
    echo "No admin found with that mobile number\n";
}
?>
