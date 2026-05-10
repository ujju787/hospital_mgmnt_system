<?php
session_start();
include('db_connect.php');

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../admin/adminLogin.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['booking_id']) && isset($_POST['status'])) {
    $booking_id = (int)$_POST['booking_id'];
    $status = $_POST['status'];

    // Validate status
    $valid_statuses = ['Pending', 'Confirmed', 'Completed', 'Cancelled'];
    if (!in_array($status, $valid_statuses)) {
        header("Location: ../admin/appointments.php?error=invalid_status");
        exit();
    }

    // Update booking status
    $sql = "UPDATE bookings SET status = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "si", $status, $booking_id);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: ../admin/appointments.php?success=status_updated");
        } else {
            header("Location: ../admin/appointments.php?error=update_failed");
        }
        mysqli_stmt_close($stmt);
    } else {
        header("Location: ../admin/appointments.php?error=db_error");
    }
} else {
    header("Location: ../admin/appointments.php");
}
?>