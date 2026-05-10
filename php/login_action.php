<?php
session_start();
include('db_connect.php'); // Both are in the 'php' folder, so no path change needed

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mobile = mysqli_real_escape_string($conn, $_POST['mobile_number']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM admins WHERE mobile_number = '$mobile'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['password'])) {
            $_SESSION['admin_id'] = $row['id'];
            // Since this file is in /php/, we go UP one level then into /admin/
            header("Location: ../admin/adminDashboard.html");
            exit();
        } else {
            echo "<script>alert('Incorrect Password'); window.location='../admin/adminlogin.php';</script>";
        }
    } else {
        echo "<script>alert('Mobile not found'); window.location='../admin/adminlogin.php';</script>";
    }
}
?>