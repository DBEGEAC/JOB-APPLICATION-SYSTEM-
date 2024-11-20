<?php
// Database connection settings
$servername = "localhost";
$username = "root";   // Default XAMPP username for MySQL
$password = "";       // Default XAMPP password is empty
$dbname = "job_application_system";  // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
