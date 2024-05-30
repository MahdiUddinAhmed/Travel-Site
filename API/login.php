<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'db_connection.php';

// Start the session
session_start();

// Retrieve username and password from the form
if(isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // SQL query to check if the username and password match in the database
    $sql = "SELECT * FROM customer WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows == 1) {
        // Password and username match, set session variables and redirect
        $row = $result->fetch_assoc();
        $_SESSION['username'] = $username;
        $_SESSION['customer_id'] = $row['customer_id']; // Set customer_id session variable
        $_SESSION['phone'] = $row['phone'];
        $_SESSION['user_type'] = $row['user_type'];
        $_SESSION['loggedin'] = true;
        header("Location: customer.php");
        
    } else {
        // Invalid username or password
        $error = "Invalid username or password. Please try again.";
    }
} else {
    // Form fields not set
    $error = "Please provide both username and password.";
}

// Display error message if any
echo $error;
?>
