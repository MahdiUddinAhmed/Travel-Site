<?php
// Include the database connection file
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'db_connection.php';

// Retrieve form data
$name = $_POST['name'];
$username = $_POST['username'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$address = $_POST['address'];
$password = $_POST['password'];

// Prepare and bind the SQL statement
$stmt = $conn->prepare("INSERT INTO customer (name, username, email, phone, address, password) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssss", $name, $username, $email, $phone, $address, $password);

// Execute the statement
if ($stmt->execute()) {
    echo "Registration successful";
} else {
    echo "Error: " . $stmt->error;
}

// Close the statement and database connection
$stmt->close();
$conn->close();
?>
