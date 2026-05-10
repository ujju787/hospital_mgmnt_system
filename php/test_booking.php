<?php
// Simulate a booking submission
$_SERVER["REQUEST_METHOD"] = "POST";
$_POST['full_name'] = 'Test User';
$_POST['age'] = 25;
$_POST['gender'] = 'Male';
$_POST['hospital'] = 'Apollo Hospital';
$_POST['speciality'] = 'Cardiology';
$_POST['doctor'] = 'Dr. Sitara';
$_POST['address'] = '123 Test Street';
$_POST['contact_number'] = '9876543210';

include('db_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = trim($_POST['full_name']);
    $age = (int)$_POST['age'];
    $gender = $_POST['gender'];
    $hospital = $_POST['hospital'];
    $speciality = $_POST['speciality'];
    $doctor = $_POST['doctor'];
    $address = trim($_POST['address']);
    $contact_number = trim($_POST['contact_number']);

    $future_date = date('Y-m-d', strtotime('+'.rand(1,30).' days'));
    $random_hour = rand(9, 16);
    $random_minute = rand(0, 3) * 15;
    $booking_time = sprintf('%02d:%02d:00', $random_hour, $random_minute);

    $sql = "INSERT INTO bookings (full_name, age, gender, hospital, speciality, doctor, address, contact_number, booking_date, booking_time, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt) {
        $status = 'Pending';
        mysqli_stmt_bind_param($stmt, "sisssssssss", $full_name, $age, $gender, $hospital, $speciality, $doctor, $address, $contact_number, $future_date, $booking_time, $status);

        if (mysqli_stmt_execute($stmt)) {
            echo "SUCCESS: Booking created for $full_name on $future_date at $booking_time\n";
        } else {
            echo "ERROR: " . mysqli_error($conn) . "\n";
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "ERROR: Failed to prepare statement\n";
    }
}
?>