<?php
session_start();
require 'connection.php';

// Check if the user is logged in and has the role of 'owner'
if (!isset($_SESSION['userid']) || $_SESSION['role'] !== 'owner') {
    header("Location: loginvalidation.php");
    exit();
}

$owner_id = $_SESSION['userid'];

// Fetch owner details and hotel information from the database
$query = "SELECT o.owner_name, o.owner_email, h.id AS hotel_id, h.name AS hotel_name 
          FROM hotel_owners o 
          JOIN hotel h ON o.hotel_id = h.id 
          WHERE o.id = ?";
$stmt = $conn->prepare($query);
if (!$stmt) {
    die("Preparation failed: (" . $conn->errno . ") " . $conn->error);
}
$stmt->bind_param("i", $owner_id);

if (!$stmt->execute()) {
    die("Execution failed: (" . $stmt->errno . ") " . $stmt->error);
}

$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $owner = $result->fetch_assoc();
    $hotel_id = $owner['hotel_id'];
    $hotel_name = $owner['hotel_name'];
} else {
    // Handle case where owner or hotel is not found
    echo "Owner or Hotel not found.";
    exit();
}

$stmt->close();

// Initialize an empty array to hold booking details
$bookings = [];

// Fetch bookings for the hotel owned by the user
// Updated query without joining the users table
$query = "SELECT booking_id, first_name, last_name, room_type, check_in, check_out, booking_status 
          FROM hotel_bookings 
          WHERE hotel_id = ?";
$stmt = $conn->prepare($query);
if (!$stmt) {
    die("Preparation failed: (" . $conn->errno . ") " . $conn->error);
}
$stmt->bind_param("i", $hotel_id);

if (!$stmt->execute()) {
    die("Execution failed: (" . $stmt->errno . ") " . $stmt->error);
}

$result = $stmt->get_result();

// Fetch all booking details
while ($row = $result->fetch_assoc()) {
    $bookings[] = $row;
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owner - Booking History</title>
    <link href="../css/style.css" rel="stylesheet" type="text/css" media="all" />
    <link href="../css/reservedetail.css" rel="stylesheet" type="text/css" media="all" />
    <link href='https://fonts.googleapis.com/css?family=PT+Sans+Narrow' rel='stylesheet' type='text/css'> 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
</head>
<body>
<div class="header">
    <div class="wrap">
        <div class="header-top">
            <div class="logo">
                <a href="index.html"><img src="../images/logo2.png" alt="logo" title="logo" /></a>
            </div>
            <div class="contact-info">
                <p class="phone">Call us : 
                    <a href="tel:9808147755">9808147755</a>, 
                    <a href="tel:9840602765">9840602765</a>
                </p>
            </div>
            <div class="clear"></div>
        </div>
    </div>
    <div class="header-top-nav">
        <div class="wrap">
            <ul>
                <li><a href="owner_profile.php">Profile</a></li>
                <li><a href="hotel_details_owner.php">Hotel</a></li>
                <li><a href="room_details.php">Rooms</a></li>
                <li class="active"><a href="reservedetailowner.php">Booking History</a></li>
                <li class="logout-button"><a href="logout.php">Logout</a></li>
                <div class="clear"></div>
            </ul>
        </div>
    </div>
</div>

<div class="wrap">
    <h1>Booking History - <?php echo htmlspecialchars($hotel_name); ?></h1>
    <table>
        <thead>
            <tr>
                <th>Booking ID</th>
                <th>User Name</th>
                <th>Room Type</th>
                <th>Check-In</th>
                <th>Check-Out</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($bookings)): ?>
                <?php foreach ($bookings as $booking): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($booking['booking_id']); ?></td>
                        <td><?php echo htmlspecialchars($booking['first_name'] . ' ' . $booking['last_name']); ?></td>
                        <td><?php echo htmlspecialchars($booking['room_type']); ?></td>
                        <td><?php echo htmlspecialchars($booking['check_in']); ?></td>
                        <td><?php echo htmlspecialchars($booking['check_out']); ?></td>
                        <td><?php echo htmlspecialchars($booking['booking_status']); ?></td>
                        <td>
                            <form method="POST" action="update_booking_owner.php">
                                <input type="hidden" name="booking_id" value="<?php echo htmlspecialchars($booking['booking_id']); ?>">
                                <select name="booking_status" required>
                                    <option value="Pending" <?php echo ($booking['booking_status'] === 'Pending') ? 'selected' : ''; ?>>Pending</option>
                                    <option value="Confirmed" <?php echo ($booking['booking_status'] === 'Confirmed') ? 'selected' : ''; ?>>Confirmed</option>
                                    <option value="Cancelled" <?php echo ($booking['booking_status'] === 'Cancelled') ? 'selected' : ''; ?>>Cancelled</option>
                                </select>
                                <button type="submit">Update</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">No bookings found for your hotel.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>
