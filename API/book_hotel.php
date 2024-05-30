<?php
include 'db_connection.php';

// Check if the hotel ID is provided in the request
if (isset($_POST['hotelId'])) {
    // Get the hotel ID from the request
    $hotelId = intval($_POST['hotelId']);

    // Check if the user is logged in
    session_start();
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
        // If logged in, get the customer ID from the session
        $customerId = intval($_SESSION['customer_id']);
        
        // Define the item type as 'Hotel'
        $itemType = 'Hotel';

        // Check if the provided hotel ID exists in the hotel table
        $checkHotelQuery = "SELECT COUNT(*) as count FROM hotel WHERE hotel_id = $hotelId";
        $checkHotelResult = $conn->query($checkHotelQuery);
        $hotelExists = $checkHotelResult->fetch_assoc()['count'];

        if ($hotelExists) {
            // Insert the booking into the booking table
            $sql = "INSERT INTO booking (customer_id, item_type, item_id) VALUES ($customerId, '$itemType', $hotelId)";
            if ($conn->query($sql) === TRUE) {
                header("Location: customer.php");
            } else {
                echo "Error booking hotel: " . $conn->error;
            }
        } else {
            echo "Hotel with ID $hotelId does not exist.";
        }
    } else {
        // If not logged in, prompt the user to log in
        echo "Please log in to book a hotel.";
    }
} else {
    // If hotel ID is not provided
    echo "Hotel ID not provided.";
}

// Close the database connection
$conn->close();
?>
