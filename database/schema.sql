CREATE DATABASE IF NOT EXISTS ujlogsys;
USE ujlogsys;

-- Users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('Admin', 'Lecturer', 'Consultant', 'Tutor', 'Student') NOT NULL,
    matric_staff_id VARCHAR(50),
    photo VARCHAR(255),
    dept_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Departments table
CREATE TABLE IF NOT EXISTS departments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE
);

-- Sessions table
CREATE TABLE IF NOT EXISTS sessions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    department_id INT,
    FOREIGN KEY (department_id) REFERENCES departments(id) ON DELETE CASCADE
);

-- Attendance table
CREATE TABLE IF NOT EXISTS attendance_records (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT,
    session_id INT,
    consultant_id INT,
    attendance_date DATE NOT NULL,
    status ENUM('Present', 'Absent') NOT NULL,
    is_confirmed BOOLEAN DEFAULT FALSE,
    confirmed_at TIMESTAMP NULL,
    FOREIGN KEY (student_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (session_id) REFERENCES sessions(id) ON DELETE CASCADE,
    FOREIGN KEY (consultant_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Log Activity Fields
CREATE TABLE IF NOT EXISTS log_activity_fields (
    id INT AUTO_INCREMENT PRIMARY KEY,
    field_label VARCHAR(100) NOT NULL,
    field_type ENUM('text', 'date', 'number', 'textarea') NOT NULL,
    is_required BOOLEAN DEFAULT TRUE
);

-- Log Activity Types
CREATE TABLE IF NOT EXISTS log_activity_types (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    department_id INT,
    FOREIGN KEY (department_id) REFERENCES departments(id) ON DELETE CASCADE
);

-- Map Fields to Activity Types
CREATE TABLE IF NOT EXISTS log_activity_type_fields (
    type_id INT,
    field_id INT,
    PRIMARY KEY (type_id, field_id),
    FOREIGN KEY (type_id) REFERENCES log_activity_types(id) ON DELETE CASCADE,
    FOREIGN KEY (field_id) REFERENCES log_activity_fields(id) ON DELETE CASCADE
);

-- Log Activity Entries
CREATE TABLE IF NOT EXISTS log_activity_entries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT,
    type_id INT,
    consultant_id INT,
    data_json TEXT NOT NULL,
    is_approved BOOLEAN DEFAULT FALSE,
    approved_at TIMESTAMP NULL,
    FOREIGN KEY (student_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (type_id) REFERENCES log_activity_types(id) ON DELETE CASCADE,
    FOREIGN KEY (consultant_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Evaluation Variables
CREATE TABLE IF NOT EXISTS evaluation_variables (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    category ENUM('Attitude', 'Behavioral', 'Scoring') NOT NULL
);

-- Settings table
CREATE TABLE IF NOT EXISTS settings (
    id INT PRIMARY KEY,
    org_name VARCHAR(255) NOT NULL,
    org_logo VARCHAR(255) NULL,
    theme_primary VARCHAR(50) DEFAULT '#000080',
    theme_secondary VARCHAR(50) DEFAULT '#FFD700'
);

-- Insert Default Settings
INSERT IGNORE INTO settings (id, org_name) VALUES (1, 'UJ Medical College of Health Science');

-- Insert Default Admin
INSERT INTO users (full_name, username, password_hash, role) 
VALUES ('System Admin', 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Admin'); -- password: password
