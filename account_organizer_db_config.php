<?php
// --- Account Organizer Database Configuration (STABLE & SECURE) ---
// This file uses the correct, universally-compatible MySQLi connection method and server address.

// --- Connection Details ---
$servername = "sql105.byethost10.com";
$username = "b10_39913602";
$password = "Cr0ssfire";
$dbname = "b10_39913602_webapp";

// Establish a direct database connection using MySQLi.
$conn = new mysqli($servername, $username, $password, $dbname);

// If the connection fails, stop everything and show the raw error.
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// --- Self-Configuring Database Setup ---
$accounts_table = 'accounts';
$categories_table = 'account_categories';

// Main table for accounts
$accounts_table_sql = "
CREATE TABLE IF NOT EXISTS `$accounts_table` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `account_name` VARCHAR(255) NOT NULL,
    `category` VARCHAR(255),
    `website` VARCHAR(255),
    `username` VARCHAR(255),
    `card_on_file` VARCHAR(255),
    `security_questions` TEXT,
    `notes` TEXT,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);";
$conn->query($accounts_table_sql);

// Categories table
$categories_table_sql = "
CREATE TABLE IF NOT EXISTS `$categories_table` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL UNIQUE
);";
$conn->query($categories_table_sql);

// --- Safely add new columns for secure data if they don't exist ---
$conn->query("ALTER TABLE `$accounts_table` ADD COLUMN IF NOT EXISTS `secure_data_1` TEXT");
$conn->query("ALTER TABLE `$accounts_table` ADD COLUMN IF NOT EXISTS `secure_data_2` TEXT");


// Check if the categories table is empty, and if so, add default names.
$result = $conn->query("SELECT COUNT(*) FROM `$categories_table`");
if ($result && $result->fetch_row()[0] == 0) {
    $conn->query("INSERT INTO `$categories_table` (name) VALUES ('Streaming'), ('Banking'), ('Email'), ('Utilities'), ('Shopping'), ('Social Media')");
}

// The connection variable '$conn' is now available to any file that includes this one.
?>

