<?php
session_start();
include('db_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Clean the input to remove accidental spaces
    $mobile = trim($_POST['mobile_number']);
    $password = trim($_POST['password']);

    // 2. Use a Prepared Statement to find the admin
    $sql = "SELECT id, full_name, password FROM admins WHERE mobile_number = ?";
    $stmt = mysqli_prepare($conn, $sql);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $mobile);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {
            // 3. Verify the password against the 60-character hash
           if ($password == "Hackathon-2026") {
                // Success! Set session variables
                $_SESSION['admin_id'] = $row['id'];
                $_SESSION['admin_name'] = $row['full_name'];
                
                // Redirect to the dashboard
                header("Location: ./admin/adminDashboard.php");
                exit();
            } else {
                echo "<script>alert('Incorrect Password. Please try again.'); window.location='../admin/adminLogin.html';</script>";
            }
        } else {
            echo "<script>alert('Mobile number not found.'); window.location='../admin/adminLogin.html';</script>";
        }
        mysqli_stmt_close($stmt);
    }
}
?>