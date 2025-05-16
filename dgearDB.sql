-- Create the database
CREATE DATABASE dgear;

-- Use the database
USE dgear;

-- Create the contacts table (not contact_form, since your PHP code uses 'contacts')
CREATE TABLE contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    message TEXT NOT NULL,
    file_path VARCHAR(255),
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
