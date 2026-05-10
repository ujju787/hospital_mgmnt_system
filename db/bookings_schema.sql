-- Add to existing careflow database
USE careflow;

-- Create bookings table for appointment requests
CREATE TABLE IF NOT EXISTS bookings (
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
);

-- Insert sample booking data
INSERT INTO bookings (full_name, age, gender, hospital, speciality, doctor, address, contact_number, booking_date, booking_time, status) VALUES
('John Doe', 35, 'Male', 'City General Hospital', 'Cardiology', 'Dr. Smith', '123 Main St, City, State 12345', '9876543210', '2026-05-15', '10:00:00', 'Confirmed'),
('Jane Smith', 28, 'Female', 'Metro Medical Center', 'Dermatology', 'Dr. Johnson', '456 Oak Ave, City, State 12346', '9876543211', '2026-05-16', '14:30:00', 'Pending'),
('Robert Brown', 42, 'Male', 'Regional Health Hospital', 'Orthopedics', 'Dr. Davis', '789 Pine Rd, City, State 12347', '9876543212', '2026-05-17', '09:15:00', 'Confirmed'),
('Emily Wilson', 31, 'Female', 'Central Medical Center', 'Gynecology', 'Dr. Taylor', '321 Elm St, City, State 12348', '9876543213', '2026-05-18', '11:45:00', 'Pending'),
('Michael Johnson', 55, 'Male', 'University Hospital', 'Neurology', 'Dr. Anderson', '654 Maple Dr, City, State 12349', '9876543214', '2026-05-19', '16:00:00', 'Confirmed');

-- Create hospitals table for dropdown options
CREATE TABLE IF NOT EXISTS hospitals (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    address TEXT,
    phone VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert sample hospitals
INSERT INTO hospitals (name, address, phone) VALUES
('City General Hospital', '123 Hospital Ave, City, State 12345', '555-0101'),
('Metro Medical Center', '456 Medical Blvd, City, State 12346', '555-0102'),
('Regional Health Hospital', '789 Health St, City, State 12347', '555-0103'),
('Central Medical Center', '321 Care Rd, City, State 12348', '555-0104'),
('University Hospital', '654 University Dr, City, State 12349', '555-0105');

-- Create specialities table for dropdown options
CREATE TABLE IF NOT EXISTS specialities (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert sample specialities
INSERT INTO specialities (name, description) VALUES
('Cardiology', 'Heart and cardiovascular diseases'),
('Dermatology', 'Skin, hair, and nail disorders'),
('Orthopedics', 'Bones, joints, and musculoskeletal system'),
('Gynecology', 'Women\'s reproductive health'),
('Neurology', 'Brain and nervous system disorders'),
('Pediatrics', 'Child healthcare'),
('Ophthalmology', 'Eye care and vision'),
('Dentistry', 'Oral health and teeth');

-- Create doctors table for dropdown options
CREATE TABLE IF NOT EXISTS doctors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    speciality_id INT,
    hospital_id INT,
    experience_years INT,
    qualification VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (speciality_id) REFERENCES specialities(id),
    FOREIGN KEY (hospital_id) REFERENCES hospitals(id)
);

-- Insert sample doctors
INSERT INTO doctors (name, speciality_id, hospital_id, experience_years, qualification) VALUES
('Dr. Smith', 1, 1, 15, 'MD Cardiology'),
('Dr. Johnson', 2, 2, 12, 'MD Dermatology'),
('Dr. Davis', 3, 3, 18, 'MD Orthopedics'),
('Dr. Taylor', 4, 4, 10, 'MD Gynecology'),
('Dr. Anderson', 5, 5, 20, 'MD Neurology'),
('Dr. Wilson', 6, 1, 8, 'MD Pediatrics'),
('Dr. Brown', 7, 2, 14, 'MD Ophthalmology'),
('Dr. Miller', 8, 3, 11, 'DDS Dentistry');
