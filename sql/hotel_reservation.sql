-- Create the database
CREATE DATABASE IF NOT EXISTS hotel_db;

-- Switch to the database
USE hotel_db;

-- Create the users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') NOT NULL DEFAULT 'user'
);

-- Create the bookings table
CREATE TABLE bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    first_name VARCHAR(50),
    last_name VARCHAR(50),
    email VARCHAR(50),
    phone VARCHAR(10),
    room_type VARCHAR(25),
    room_no VARCHAR(25),
    check_in_date DATE,
    check_out_date DATE,
    country VARCHAR(50),
    status VARCHAR(50),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Create the contact table
CREATE TABLE IF NOT EXISTS contact (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    mobile_number VARCHAR(15) NOT NULL,
    subject TEXT NOT NULL
);

-- Create the rooms table
CREATE TABLE IF NOT EXISTS rooms (
    id INT AUTO_INCREMENT PRIMARY KEY,
    room_type VARCHAR(50) NOT NULL,
    room_no VARCHAR(10) NOT NULL UNIQUE
);
