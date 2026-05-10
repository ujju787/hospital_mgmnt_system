<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
session_start();
include('db_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $full_name = trim($_POST['full_name'] ?? '');
    $age = (int)($_POST['age'] ?? 0);
    $gender = $_POST['gender'] ?? '';
    $hospital = $_POST['hospital'] ?? '';
    $speciality = $_POST['speciality'] ?? '';
    $doctor = $_POST['doctor'] ?? '';
    $address = trim($_POST['address'] ?? '');
    $contact_number = trim($_POST['contact_number'] ?? '');

    // Validate
    if (!$full_name || !$age || !$gender || !$hospital || !$speciality || !$doctor || !$address || !$contact_number) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'All fields are required']);
        exit();
    }

    // Generate a random future date and time for the appointment
    $future_date = date('Y-m-d', strtotime('+'.rand(1,30).' days'));
    $random_hour = rand(9, 16); // 9 AM to 4 PM
    $random_minute = rand(0, 3) * 15; // 0, 15, 30, or 45 minutes
    $booking_time = sprintf('%02d:%02d:00', $random_hour, $random_minute);

    // Insert into database
    $sql = "INSERT INTO bookings (full_name, age, gender, hospital, speciality, doctor, address, contact_number, booking_date, booking_time, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt) {
        $status = 'Pending';
        mysqli_stmt_bind_param($stmt, "sisssssssss", $full_name, $age, $gender, $hospital, $speciality, $doctor, $address, $contact_number, $future_date, $booking_time, $status);

        if (mysqli_stmt_execute($stmt)) {
            // Get the inserted booking ID
            $booking_id = mysqli_insert_id($conn);
            
            // Return success response with booking data
            http_response_code(200);
            echo json_encode([
                'success' => true,
                'message' => 'Appointment booked successfully!',
                'booking' => [
                    'id' => $booking_id,
                    'full_name' => $full_name,
                    'age' => $age,
                    'gender' => $gender,
                    'hospital' => $hospital,
                    'speciality' => $speciality,
                    'doctor' => $doctor,
                    'address' => $address,
                    'contact_number' => $contact_number,
                    'booking_date' => $future_date,
                    'booking_time' => $booking_time
                ]
            ]);
            exit();
        } else {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Error booking appointment: ' . mysqli_error($conn)]);
            exit();
        }
        mysqli_stmt_close($stmt);
    } else {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Database error: ' . mysqli_error($conn)]);
        exit();
    }
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit();
}