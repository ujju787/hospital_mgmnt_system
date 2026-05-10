<?php
// Create all missing tables
include('db_connect.php');

$tables = [
    "CREATE TABLE IF NOT EXISTS patients (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(100) UNIQUE NOT NULL,
        phone VARCHAR(20),
        address TEXT,
        dob DATE,
        gender ENUM('Male', 'Female', 'Other'),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )",
    
    "CREATE TABLE IF NOT EXISTS appointments (
        id INT AUTO_INCREMENT PRIMARY KEY,
        patient_id INT,
        appointment_date DATE NOT NULL,
        appointment_time TIME NOT NULL,
        status ENUM('Pending', 'Confirmed', 'Completed', 'Cancelled') DEFAULT 'Pending',
        notes TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (patient_id) REFERENCES patients(id)
    )",
    
    "CREATE TABLE IF NOT EXISTS messages (
        id INT AUTO_INCREMENT PRIMARY KEY,
        sender_name VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL,
        message TEXT NOT NULL,
        read_status TINYINT(1) DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )",
    
    "CREATE TABLE IF NOT EXISTS feedback (
        id INT AUTO_INCREMENT PRIMARY KEY,
        patient_id INT,
        feedback_text TEXT NOT NULL,
        rating INT CHECK (rating >= 1 AND rating <= 5),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (patient_id) REFERENCES patients(id)
    )"
];

foreach ($tables as $sql) {
    if (mysqli_query($conn, $sql)) {
        echo "Table created/checked successfully\n";
    } else {
        echo "Error: " . mysqli_error($conn) . "\n";
    }
}

// Insert sample data if tables are empty
$insert_data = [
    "INSERT IGNORE INTO patients (id, name, email, phone, address, dob, gender) VALUES
    (1, 'John Doe', 'john@example.com', '1234567890', '123 Main St', '1980-01-01', 'Male'),
    (2, 'Jane Smith', 'jane@example.com', '0987654321', '456 Elm St', '1990-02-02', 'Female')",
    
    "INSERT IGNORE INTO appointments (id, patient_id, appointment_date, appointment_time, status) VALUES
    (1, 1, '2026-05-15', '10:00:00', 'Confirmed'),
    (2, 2, '2026-05-16', '14:00:00', 'Pending')",
    
    "INSERT IGNORE INTO messages (id, sender_name, email, message, read_status) VALUES
    (1, 'Patient A', 'a@example.com', 'Hello, I need help.', 0),
    (2, 'Patient B', 'b@example.com', 'Appointment inquiry.', 1)",
    
    "INSERT IGNORE INTO feedback (id, patient_id, feedback_text, rating) VALUES
    (1, 1, 'Great service!', 5),
    (2, 2, 'Could be better.', 3)"
];

foreach ($insert_data as $sql) {
    mysqli_query($conn, $sql);
}

echo "\nAll tables created and sample data inserted!\n";
?>
