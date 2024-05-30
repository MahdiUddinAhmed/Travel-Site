<?php
include 'db_connection.php';

// Check if the flight ID is provided in the request
if (isset($_POST['flightId'])) {
    // Get the flight ID from the request
    $flightId = intval($_POST['flightId']);

    // Check if the user is logged in
    session_start();
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
        // If logged in, get the customer ID from the session
        $customerId = intval($_SESSION['customer_id']);
        
        // Define the item type as 'Flight'
        $itemType = 'Flight';

        // Check if the provided flight ID exists in the flight table
        $checkFlightQuery = "SELECT COUNT(*) as count FROM flight WHERE flight_id = $flightId";
        $checkFlightResult = $conn->query($checkFlightQuery);
        $flightExists = $checkFlightResult->fetch_assoc()['count'];

        if ($flightExists) {
            // Insert the booking into the booking table
            $sql = "INSERT INTO booking (customer_id, item_type, item_id) VALUES ($customerId, '$itemType', $flightId)";
            if ($conn->query($sql) === TRUE) {
                header("Location: customer.php");
            } else {
                echo "Error booking flight: " . $conn->error;
            }
        } else {
            echo "Flight with ID $flightId does not exist.";
        }
    } else {
        // If not logged in, prompt the user to log in
        echo "Please log in to book a flight.";
    }
} else {
    // If flight ID is not provided
    echo "Flight ID not provided.";
}

// Close the database connection
$conn->close();
?>
