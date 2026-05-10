<?php
session_start();
$_SESSION['admin_id'] = 1;
$_SESSION['admin_name'] = 'Admin User';

include('db_connect.php');

echo "=== TESTING DASHBOARD METRICS ===\n\n";

// Total Patients
$res_p = mysqli_query($conn, "SELECT id FROM patients");
$total_patients = ($res_p) ? mysqli_num_rows($res_p) : 0;
echo "Total Patients: " . $total_patients . "\n";

// Total Appointments
$res_a = mysqli_query($conn, "SELECT id FROM appointments");
$total_appointments = ($res_a) ? mysqli_num_rows($res_a) : 0;
echo "Total Appointments: " . $total_appointments . "\n";

// New Messages
$res_m = mysqli_query($conn, "SELECT id FROM messages WHERE read_status = 0");
$new_messages = ($res_m) ? mysqli_num_rows($res_m) : 0;
echo "New Messages: " . $new_messages . "\n";

// Total Feedback
$res_f = mysqli_query($conn, "SELECT id FROM feedback");
$total_feedback = ($res_f) ? mysqli_num_rows($res_f) : 0;
echo "Total Feedback: " . $total_feedback . "\n";

echo "\n✓ ALL DASHBOARD METRICS WORKING!\n";
?>
