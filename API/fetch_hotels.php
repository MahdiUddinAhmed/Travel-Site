<?php
include 'db_connection.php'; // Include the database connection file

// Retrieve form data
$destination = $_POST['destination'];
$price = $_POST['price'];

// Query the database with conditions for destination and price range
$sql = "SELECT * FROM hotel WHERE country = '$destination' AND price <= $price";
$result = $conn->query($sql);

// Check if there are any hotels found
if ($result->num_rows > 0) {
    // Output data of each hotel
    while($row = $result->fetch_assoc()) {
        // Output hotel information in HTML format
        echo "<div class='hotel'>";
        echo "<h2 class='Htitle'>{$row['name']}</h2>";
        echo "<div class='Hinfo'";
        echo "<p>Available Rooms: {$row['available_rooms']}</p>";
        echo "<p>Location: {$row['city']}, {$row['country']}</p>";
        echo "<p>Price: \${$row['price']}</p>";
        echo "</div>";
        echo "<img src='{$row['image_url']}' alt='{$row['name']}' class='hotel-image'>";
        session_start();
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
            // If logged in, show book button
            echo "<form action='API/book_hotel.php' method='post'>";
            echo "<input type='hidden' name='hotelId' value='{$row['hotel_id']}'>";
            echo "<button type='submit'>Book</button>";
            echo "</form>";
        }
        else{
            echo "<p> Login to Book</p>";
        }
        echo "</div>";
    }
} else {
    // If no hotels found
    echo "No hotels found within the specified criteria.";
}

// Close the database connection
$conn->close();
?>
