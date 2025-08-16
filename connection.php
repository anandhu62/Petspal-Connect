<?php
// Define database credentials
$servername = "localhost"; // Replace with your server name if needed
$username = "root";        // Replace with your MySQL username
$password = "anandhu";            // Replace with your MySQL password
$dbname = "petadoption"; // Replace with your database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Optionally, you can use this message to confirm the connection (remove or comment in production)
echo "Connected successfully";

?>
