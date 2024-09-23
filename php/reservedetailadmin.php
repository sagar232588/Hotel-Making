<?php 
require 'connection.php'; 
session_start(); // Start the session to access user information

// Check if the user is logged in and is an admin
if (!isset($_SESSION['userid']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Initialize an empty array to hold booking details
$bookings = [];

// Fetch all bookings
$query = "SELECT * FROM hotel_bookings";
$stmt = $conn->prepare($query);

// Execute the query
$stmt->execute();
$result = $stmt->get_result();

// Fetch all booking details
while ($row = $result->fetch_assoc()) {
    $bookings[] = $row;
}

// Close the statement
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Booking Details</title>
    <link href="../css/style.css" rel="stylesheet" type="text/css" media="all" />
    <link href="../css/reservedetail.css" rel="stylesheet" type="text/css" media="all" />
    <link href='http://fonts.googleapis.com/css?family=PT+Sans+Narrow' rel='stylesheet' type='text/css'> 
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
</head>
<body>
<div class="header">
    <div class="wrap">
        <div class="header-top">
            <div class="logo">
                <a href="index.html"><img src="../images/logo2.png" title="logo" /></a>
            </div>
            <div class="contact-info">
                <p class="phone">Call us : <a href="#">9808147755,9840602765</a></p>
            </div>
            <div class="clear"></div>
        </div>
    </div>
    <div class="header-top-nav">
        <div class="wrap">
            <ul>
                <li><a href="all-hotel.php">Our Hotels</a></li>
                <li><a href="create_owner.php">Owner Accounts</a></li>
                <li class="active"><a href="reservedetailadmin.php">Booking Details</a></li>
                <li><a href="dispcontact.php">Messages</a></li>
                <li><a href="userdetail.php">User Details</a></li>
                <li class="logout-button"><a href="logout.php">Logout</a></li>
                <div class="clear"></div>
            </ul>
        </div>
    </div>
</div>

<div class="wrap">
    <h1>All Booking Details</h1>
    <table>
        <thead>
            <tr>
                <th>Booking ID</th>
                <th>User Name</th>
                <th>Hotel Name</th>
                <th>Room Type</th>
                <th>Check-In</th>
                <th>Check-Out</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($bookings)): ?>
                <?php foreach ($bookings as $booking): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($booking['booking_id']); ?></td>
                        <td><?php echo htmlspecialchars($booking['first_name'] . ' ' . $booking['last_name']); ?></td>
                        <td><?php 
                            // Fetch hotel name using hotel_id from the booking
                            $hotelQuery = "SELECT name FROM hotel WHERE id = ?";
                            $hotelStmt = $conn->prepare($hotelQuery);
                            $hotelStmt->bind_param("i", $booking['hotel_id']);
                            $hotelStmt->execute();
                            $hotelStmt->bind_result($hotelName);
                            $hotelStmt->fetch();
                            echo htmlspecialchars($hotelName);
                            $hotelStmt->close();
                        ?></td>
                        <td><?php echo htmlspecialchars($booking['room_type']); ?></td>
                        <td><?php echo htmlspecialchars($booking['check_in']); ?></td>
                        <td><?php echo htmlspecialchars($booking['check_out']); ?></td>
                        <td><?php echo htmlspecialchars($booking['booking_status']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">No bookings found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>
