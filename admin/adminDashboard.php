<?php
session_start();
include('../php/db_connect.php');

// 1. Session Guard: If not logged in, send back to login page
if (!isset($_SESSION['admin_id'])) {
    header("Location: adminLogin.html");
    exit();
}

/**
 * 2. Database Stats Logic
 */

// Total Patients
$res_p = mysqli_query($conn, "SELECT id FROM patients");
$total_patients = ($res_p) ? mysqli_num_rows($res_p) : 0;

// Total Appointments
$res_a = mysqli_query($conn, "SELECT id FROM appointments");
$total_appointments = ($res_a) ? mysqli_num_rows($res_a) : 0;

// New Messages
$res_m = mysqli_query($conn, "SELECT id FROM messages WHERE read_status = 0");
$new_messages = ($res_m) ? mysqli_num_rows($res_m) : 0;

// Total Feedback
$res_f = mysqli_query($conn, "SELECT id FROM feedback");
$total_feedback = ($res_f) ? mysqli_num_rows($res_f) : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CareFlow - Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="font-sans text-gray-800 bg-gray-50">

    <nav class="flex items-center justify-between px-8 py-4 bg-white shadow-sm sticky top-0 z-50">
        <div class="flex items-center space-x-2">
            <div class="bg-emerald-500 p-2 rounded-full">
                <i class="fas fa-heartbeat text-white text-xl"></i>
            </div>
            <span class="text-2xl font-bold text-gray-700 tracking-tight"><span style="color:green;">Care</span>Flow</span>
        </div>

        <div class="hidden md:flex items-center space-x-6 text-gray-600 font-medium">
            <a href="adminDashboard.php" class="text-emerald-500">Dashboard</a>
            <a href="admin.patent.html" class="hover:text-emerald-500">Patients</a>
            <a href="admin.visit.html" class="hover:text-emerald-500">Visits</a>
            <a href="admin.feedback.html" class="hover:text-emerald-500">Feedback</a>
            <a href="admin.massage.html" class="hover:text-emerald-500">Messages</a>
            <a href="appointments.php" class="hover:text-emerald-500">Appointments</a>
            <a href="admin.registration.html" class="hover:text-emerald-500">Registration</a>
        </div>

        <div class="flex items-center space-x-4">
            <span class="text-gray-600">Welcome, <strong><?php echo htmlspecialchars($_SESSION['admin_name']); ?></strong></span>
            <a href="../php/logout.php" class="bg-red-500 text-white px-4 py-2 rounded-md font-medium hover:bg-red-600 transition">Logout</a>
        </div>
    </nav>

    <main class="px-8 py-8">
        <h1 class="text-4xl font-bold text-gray-900 mb-8">Admin Dashboard</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white p-6 rounded-lg shadow-md text-center">
                <div class="bg-emerald-100 p-3 rounded-full w-16 h-16 mx-auto mb-4">
                    <i class="fas fa-users text-emerald-500 text-2xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-700 mb-2">Total Patients</h3>
                <p class="text-3xl font-bold text-emerald-500"><?php echo $total_patients; ?></p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md text-center">
                <div class="bg-emerald-100 p-3 rounded-full w-16 h-16 mx-auto mb-4">
                    <i class="fas fa-calendar-check text-emerald-500 text-2xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-700 mb-2">Total Appointments</h3>
                <p class="text-3xl font-bold text-emerald-500"><?php echo $total_appointments; ?></p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md text-center">
                <div class="bg-emerald-100 p-3 rounded-full w-16 h-16 mx-auto mb-4">
                    <i class="fas fa-envelope text-emerald-500 text-2xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-700 mb-2">New Messages</h3>
                <p class="text-3xl font-bold text-emerald-500"><?php echo $new_messages; ?></p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md text-center">
                <div class="bg-emerald-100 p-3 rounded-full w-16 h-16 mx-auto mb-4">
                    <i class="fas fa-comments text-emerald-500 text-2xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-700 mb-2">Feedback</h3>
                <p class="text-3xl font-bold text-emerald-500"><?php echo $total_feedback; ?></p>
            </div>
        </div>

    </main>

</body>
</html>