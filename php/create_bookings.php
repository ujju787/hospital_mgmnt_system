<?php
include('db_connect.php');

// Create bookings table
$bookings_sql = "CREATE TABLE IF NOT EXISTS bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    age INT NOT NULL,
    gender ENUM('Male', 'Female', 'Other') NOT NULL,
    hospital VARCHAR(100) NOT NULL,
    speciality VARCHAR(100) NOT NULL,
    doctor VARCHAR(100) NOT NULL,
    address TEXT NOT NULL,
    contact_number VARCHAR(20) NOT NULL,
    booking_date DATE NOT NULL,
    booking_time TIME NOT NULL,
    status ENUM('Pending', 'Confirmed', 'Completed', 'Cancelled') DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if (mysqli_query($conn, $bookings_sql)) {
    echo "Bookings table created successfully\n";
} else {
    echo "Error creating bookings table: " . mysqli_error($conn) . "\n";
}

// Create hospitals table
$hospitals_sql = "CREATE TABLE IF NOT EXISTS hospitals (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    address TEXT,
    phone VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if (mysqli_query($conn, $hospitals_sql)) {
    echo "Hospitals table created successfully\n";
} else {
    echo "Error creating hospitals table: " . mysqli_error($conn) . "\n";
}

// Create specialities table
$specialities_sql = "CREATE TABLE IF NOT EXISTS specialities (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if (mysqli_query($conn, $specialities_sql)) {
    echo "Specialities table created successfully\n";
} else {
    echo "Error creating specialities table: " . mysqli_error($conn) . "\n";
}

// Create doctors table
$doctors_sql = "CREATE TABLE IF NOT EXISTS doctors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    speciality_id INT,
    hospital_id INT,
    experience_years INT,
    qualification VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (speciality_id) REFERENCES specialities(id),
    FOREIGN KEY (hospital_id) REFERENCES hospitals(id)
)";

if (mysqli_query($conn, $doctors_sql)) {
    echo "Doctors table created successfully\n";
} else {
    echo "Error creating doctors table: " . mysqli_error($conn) . "\n";
}

// Insert sample data
$sample_data = [
    "INSERT IGNORE INTO hospitals (id, name, address, phone) VALUES
    (1, 'City General Hospital', '123 Hospital Ave, City, State 12345', '555-0101'),
    (2, 'Metro Medical Center', '456 Medical Blvd, City, State 12346', '555-0102'),
    (3, 'Regional Health Hospital', '789 Health St, City, State 12347', '555-0103'),
    (4, 'Central Medical Center', '321 Care Rd, City, State 12348', '555-0104'),
    (5, 'University Hospital', '654 University Dr, City, State 12349', '555-0105')",

    "INSERT IGNORE INTO specialities (id, name, description) VALUES
    (1, 'Cardiology', 'Heart and cardiovascular diseases'),
    (2, 'Dermatology', 'Skin, hair, and nail disorders'),
    (3, 'Orthopedics', 'Bones, joints, and musculoskeletal system'),
    (4, 'Gynecology', 'Women\'s reproductive health'),
    (5, 'Neurology', 'Brain and nervous system disorders'),
    (6, 'Pediatrics', 'Child healthcare'),
    (7, 'Ophthalmology', 'Eye care and vision'),
    (8, 'Dentistry', 'Oral health and teeth')",

    "INSERT IGNORE INTO doctors (id, name, speciality_id, hospital_id, experience_years, qualification) VALUES
    (1, 'Dr. Smith', 1, 1, 15, 'MD Cardiology'),
    (2, 'Dr. Johnson', 2, 2, 12, 'MD Dermatology'),
    (3, 'Dr. Davis', 3, 3, 18, 'MD Orthopedics'),
    (4, 'Dr. Taylor', 4, 4, 10, 'MD Gynecology'),
    (5, 'Dr. Anderson', 5, 5, 20, 'MD Neurology'),
    (6, 'Dr. Wilson', 6, 1, 8, 'MD Pediatrics'),
    (7, 'Dr. Brown', 7, 2, 14, 'MD Ophthalmology'),
    (8, 'Dr. Miller', 8, 3, 11, 'DDS Dentistry')",

    "INSERT IGNORE INTO bookings (id, full_name, age, gender, hospital, speciality, doctor, address, contact_number, booking_date, booking_time, status) VALUES
    (1, 'John Doe', 35, 'Male', 'City General Hospital', 'Cardiology', 'Dr. Smith', '123 Main St, City, State 12345', '9876543210', '2026-05-15', '10:00:00', 'Confirmed'),
    (2, 'Jane Smith', 28, 'Female', 'Metro Medical Center', 'Dermatology', 'Dr. Johnson', '456 Oak Ave, City, State 12346', '9876543211', '2026-05-16', '14:30:00', 'Pending'),
    (3, 'Robert Brown', 42, 'Male', 'Regional Health Hospital', 'Orthopedics', 'Dr. Davis', '789 Pine Rd, City, State 12347', '9876543212', '2026-05-17', '09:15:00', 'Confirmed'),
    (4, 'Emily Wilson', 31, 'Female', 'Central Medical Center', 'Gynecology', 'Dr. Taylor', '321 Elm St, City, State 12348', '9876543213', '2026-05-18', '11:45:00', 'Pending'),
    (5, 'Michael Johnson', 55, 'Male', 'University Hospital', 'Neurology', 'Dr. Anderson', '654 Maple Dr, City, State 12349', '9876543214', '2026-05-19', '16:00:00', 'Confirmed')"
];

foreach ($sample_data as $sql) {
    if (mysqli_query($conn, $sql)) {
        echo "Sample data inserted successfully\n";
    } else {
        echo "Error inserting sample data: " . mysqli_error($conn) . "\n";
    }
}

echo "\nAll booking tables created and populated!\n";
?>
