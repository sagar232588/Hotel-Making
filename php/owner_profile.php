<?php
session_start();
require 'connection.php';

// Check if the user is logged in and has the role of 'owner'
if (!isset($_SESSION['userid']) || $_SESSION['role'] !== 'owner') {
    header("Location: loginvalidation.php");
    exit();
}

$owner_id = $_SESSION['userid'];

// Fetch owner details and hotel name from the database
$query = "SELECT o.owner_name, o.owner_email, h.name AS hotel_name 
          FROM hotel_owners o 
          JOIN hotel h ON o.hotel_id = h.id 
          WHERE o.id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $owner_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $owner = $result->fetch_assoc();
} else {
    $owner = null;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owner Profile</title>
    <link rel="stylesheet" href="styles.css">
    <link href="../css/style.css" rel="stylesheet" type="text/css" media="all" />
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
                    <!-- <p class="gpa">Gps : <a href="https://www.google.com/maps/place/New+Hotel+Elite+(P)+Ltd/@27.7117484,85.3104502,17z/data=!3m1!4b1!4m9!3m8!1s0x39eb18fdefffffff:0xcf6b523c8d383f44!5m2!4m1!1i2!8m2!3d27.7117484!4d85.3130251!16s%2Fg%2F11b6dq98s8?entry=ttu">View map</a></p> -->
                </div>
                <div class="clear"> </div>
            </div>
        </div>
        <div class="header-top-nav">
            <div class="wrap">
                <ul>
                    <li class="active"><a href="owner_profile.php">Profile</a></li>
                    <li><a href="hotel_details_owner.php">Hotel</a></li>
                    <li><a href="room_details.php">Rooms</a></li>
                    <li><a href="reservedetailowner.php">Booking History</a></li>
                    <!-- <li><a href="services.html">Services</a></li>
                    <li><a href="gallery.html">Gallery</a></li>
                    <li><a href="contact.html">Contact</a></li> -->
                    <li class="logout-button"><a href="logout.php">Logout</a></li>
                    <div class="clear"> </div>
                </ul>
            </div>
        </div>
    </div>

    <main>
        <h2>Your Profile</h2>

        <?php if ($owner): ?>
            <p><strong>Owner Name:</strong> <?php echo htmlspecialchars($owner['owner_name']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($owner['owner_email']); ?></p>
            <p><strong>Hotel Name:</strong> <?php echo htmlspecialchars($owner['hotel_name']); ?></p>
        <?php else: ?>
            <p>No profile information found.</p>
        <?php endif; ?>
    </main>
</body>
</html>
