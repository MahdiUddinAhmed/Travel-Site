<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'db_connection.php';

// Start the session
session_start();

// Check if user is not logged in, redirect to login page
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.html");
    exit();
}

// Fetch user's bookings from the database
$customerId = $_SESSION['customer_id'];
$user_type = $_SESSION['user_type']; 


// Initialize an empty array to store the bookings
$bookings = [];

// Initialize an empty array to store the item prices
$itemPrices = [];

// SQL query to retrieve the bookings
$sql = "SELECT * FROM booking WHERE customer_id = $customerId";
$result = $conn->query($sql);

$customerSql = "SELECT * FROM customer";
$customerResult = $conn->query($customerSql);

// Check if query was successful
if ($result === false) {
    // Query failed, handle error
    echo "Error retrieving bookings: " . $conn->error;
    exit();
}

// Loop through the result set and store the bookings in an array
while ($row = $result->fetch_assoc()) {
    $bookings[] = $row;
}

// Loop through the bookings and fetch the price for each item type
foreach ($bookings as $booking) {
    $itemType = $booking['item_type'];
    $itemId = $booking['item_id'];

    // Fetch price for the item based on its type and ID
    $priceSql = "";
    switch ($itemType) {
        case 'Hotel':
            $priceSql = "SELECT price FROM hotel WHERE hotel_id = $itemId";
            break;
        case 'Transport':
            $priceSql = "SELECT price FROM transport WHERE transport_id = $itemId";
            break;
        case 'Flight':
            $priceSql = "SELECT price FROM flight WHERE flight_id = $itemId";
            break;
        // Add more cases for other item types if needed
    }

    // Execute the price query
    $priceResult = $conn->query($priceSql);

    // Check if query was successful
    if ($priceResult === false) {
        // Query failed, handle error
        echo "Error retrieving price for $itemType: " . $conn->error;
        continue; // Skip to the next booking
    }

    // Fetch the price and store it in the item prices array
    $priceRow = $priceResult->fetch_assoc();
    $itemPrices[$booking['booking_id']] = $priceRow['price'];
}

$rusername = '';
$rsql = "SELECT username FROM customer WHERE customer_id = $customerId";
$rresult = $conn->query($rsql);

if ($result->num_rows > 0) {
    // If the query returns a row, fetch the username
    $row = $rresult->fetch_assoc();
    $rusername = $row['username'];
}
// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link rel="stylesheet" href="customerstyle.css">
</head>
<body>
<header>
    <logo>
        <h1>Logo</h1>
    </logo>
    <nav>
        <a href='../index.html'>Home</a>
        <a href='../rent.html'>Rent Hotel</a>
        <a href='../flight.html'>Flight</a>
        <a href='#' class="active">User Dashboard</a>
    </nav>
</header>
<div class="userinterface">
    <div class="container">
        <h1>Welcome, <?php echo $rusername; ?>!</h1>
        <p>This is the user page. You are logged in.</p>
        <p>User Type: <?php echo $user_type; ?>.</p>
        <button><a href="logout.php">Logout</a></button>
        <?php if ($user_type == "customer"): ?>
    <div class="booking">
        <h2>Your Bookings</h2>
        <table>
            <thead>
                <tr>
                    <th>Booking ID</th>
                    <th>Item Type</th>
                    <th>Booking Date</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bookings as $booking): ?>
                    <tr>
                        <td><?php echo $booking['booking_id']; ?></td>
                        <td><?php echo $booking['item_type']; ?></td>
                        <td><?php echo $booking['booking_date']; ?></td>
                        <td><?php echo isset($itemPrices[$booking['booking_id']]) ? $itemPrices[$booking['booking_id']] : 'N/A'; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <div class="customer-table">
        <h2>Customer Table</h2>
        <table>
            <thead>
                <tr>
                    <th>Customer ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>User Type</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // SQL query to retrieve all customers
               
                if ($customerResult->num_rows > 0) {
                    while ($row = $customerResult->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['customer_id'] . "</td>";
                        echo "<td>" . $row['name'] . "</td>";
                        echo "<td>" . $row['email'] . "</td>";
                        echo "<td>" . $row['phone'] . "</td>";
                        echo "<td>" . $row['address'] . "</td>";
                        echo "<td>" . $row['username'] . "</td>";
                        echo "<td>" . $row['password'] . "</td>";
                        echo "<td>" . $row['user_type'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No customers found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>


    </div>
</div>
</body>
</html>
</html>
