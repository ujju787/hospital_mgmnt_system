<?php
session_start();
include('db_connect.php');

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../admin/adminLogin.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['booking_id'])) {
    $booking_id = (int)$_POST['booking_id'];

    // Delete booking
    $sql = "DELETE FROM bookings WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $booking_id);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: ../admin/appointments.php?success=booking_deleted");
        } else {
            header("Location: ../admin/appointments.php?error=delete_failed");
        }
        mysqli_stmt_close($stmt);
    } else {
        header("Location: ../admin/appointments.php?error=db_error");
    }
} else {
    header("Location: ../admin/appointments.php");
}
?>