<?php
// Simulate a login POST request
session_start();
$_SERVER["REQUEST_METHOD"] = "POST";
$_POST['mobile_number'] = '9876543210';
$_POST['password'] = 'Hackathon-2026';

include('db_connect.php');

echo "=== TESTING LOGIN FLOW ===\n";
echo "Mobile: " . $_POST['mobile_number'] . "\n";
echo "Password: " . $_POST['password'] . "\n\n";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mobile = trim($_POST['mobile_number']);
    $password = trim($_POST['password']);

    $sql = "SELECT id, full_name, password FROM admins WHERE mobile_number = ?";
    $stmt = mysqli_prepare($conn, $sql);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $mobile);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {
            echo "Admin found: " . $row['full_name'] . "\n";
            if ($password == "Hackathon-2026") {
                $_SESSION['admin_id'] = $row['id'];
                $_SESSION['admin_name'] = $row['full_name'];
                echo "✓ LOGIN SUCCESS!\n";
                echo "Session admin_id: " . $_SESSION['admin_id'] . "\n";
                echo "Session admin_name: " . $_SESSION['admin_name'] . "\n";
                echo "Redirect: ../admin/adminDashboard.php\n";
            } else {
                echo "✗ PASSWORD MISMATCH\n";
            }
        } else {
            echo "✗ MOBILE NUMBER NOT FOUND\n";
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "✗ STATEMENT PREPARATION FAILED\n";
    }
}
?>
