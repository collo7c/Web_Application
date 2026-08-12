<?php
// ===== Database Connection (MySQLi) =====
require_once 'config.php';

// 1. Connect to the MySQL server first (no database selected yet),
//    so we can create the database if it doesn't already exist.
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS);

if ($conn->connect_error) {
    die('Database connection failed: ' . $conn->connect_error);
}

// 2. Create the database if it's not there yet.
$conn->query("CREATE DATABASE IF NOT EXISTS " . DB_NAME . " CHARACTER SET utf8mb4");

// 3. Select the database.
$conn->select_db(DB_NAME);

// 4. Create the registrations table if it doesn't exist yet.
$createTable = "
    CREATE TABLE IF NOT EXISTS registrations (
        id INT AUTO_INCREMENT PRIMARY KEY,
        full_name VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL,
        phone VARCHAR(20) NOT NULL,
        age INT NULL,
        gender VARCHAR(10) NULL,
        plan VARCHAR(50) NOT NULL,
        goals VARCHAR(255) NULL,
        comments TEXT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )
";

if (!$conn->query($createTable)) {
    die('Error creating registrations table: ' . $conn->error);
}