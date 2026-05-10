-- Create database
CREATE DATABASE IF NOT EXISTS careflow;
USE careflow;

-- Admins table
CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    name VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert sample admin
INSERT INTO admins (username, password, name) VALUES ('admin', '$2y$10$examplehashedpassword', 'Admin User');

-- Patients table
CREATE TABLE patients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(20),
    address TEXT,
    dob DATE,
    gender ENUM('Male', 'Female', 'Other'),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert sample patients
INSERT INTO patients (name, email, phone, address, dob, gender) VALUES
('John Doe', 'john@example.com', '1234567890', '123 Main St', '1980-01-01', 'Male'),
('Jane Smith', 'jane@example.com', '0987654321', '456 Elm St', '1990-02-02', 'Female');

-- Appointments table
CREATE TABLE appointments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT,
    appointment_date DATE NOT NULL,
    appointment_time TIME NOT NULL,
    status ENUM('Pending', 'Confirmed', 'Completed', 'Cancelled') DEFAULT 'Pending',
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES patients(id)
);

-- Insert sample appointments
INSERT INTO appointments (patient_id, appointment_date, appointment_time, status) VALUES
(1, '2026-05-15', '10:00:00', 'Confirmed'),
(2, '2026-05-16', '14:00:00', 'Pending');

-- Messages table
CREATE TABLE messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sender_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    message TEXT NOT NULL,
    read_status TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert sample messages
INSERT INTO messages (sender_name, email, message, read_status) VALUES
('Patient A', 'a@example.com', 'Hello, I need help.', 0),
('Patient B', 'b@example.com', 'Appointment inquiry.', 1);

-- Feedback table
CREATE TABLE feedback (
    id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT,
    feedback_text TEXT NOT NULL,
    rating INT CHECK (rating >= 1 AND rating <= 5),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES patients(id)
);

-- Insert sample feedback
INSERT INTO feedback (patient_id, feedback_text, rating) VALUES
(1, 'Great service!', 5),
(2, 'Could be better.', 3);