<?php
include 'db_connection.php';

$destination = $_POST['destination'];
$price = $_POST['price'];
$source = $_POST['source'];

$sql = "SELECT * FROM flight WHERE destination_city = '$destination' AND source_city='$source' AND price<=$price";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='flight'>";
        echo "<h2>{$row['airline']}</h2>";
        echo "<div class='flight-info'>";
        echo "<p>Available Seats: {$row['available_seats']}</p>";
        echo "<p>Location: {$row['destination_city']}, {$row['destination_country']}</p>";
        echo "<p>Price: \${$row['price']}</p>";
        // Check if the user is logged in
        session_start();
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
            // If logged in, show book button
            echo "<form action='API/book_flight.php' method='post'>";
            echo "<input type='hidden' name='flightId' value='{$row['flight_id']}'>";
            echo "<button type='submit'>Book</button>";
            echo "</form>";
        }
        echo "</div>";
        echo "</div>";
    }
} else {
    // If no flights found
    echo "No flights found within the specified criteria.";
}

// Close the database connection
$conn->close();
?>
