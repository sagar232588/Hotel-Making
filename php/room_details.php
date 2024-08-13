
  

    <?php
session_start();
require 'connection.php';

// Check if the user is logged in and has the role of 'owner'
if (!isset($_SESSION['userid']) || $_SESSION['role'] !== 'owner') {
    header("Location: loginvalidation.php");
    exit();
}

$owner_id = $_SESSION['userid'];

// Fetch the hotel details for the logged-in owner
$query = "
    SELECT h.id AS hotel_id, h.name AS hotel_name
    FROM hotel h
    JOIN hotel_owners o ON h.id = o.hotel_id
    WHERE o.id = ?";
    
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $owner_id);
$stmt->execute();
$result = $stmt->get_result();

$hotels = [];
$selected_hotel_id = null;

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $hotels[] = $row;
        if (is_null($selected_hotel_id)) {
            $selected_hotel_id = $row['hotel_id'];
        }
    }
}

$stmt->close();

// Fetch the rooms for the selected hotel
$rooms_query = "SELECT * FROM hotel_rooms WHERE hotel_id = ?";
$stmt_rooms = $conn->prepare($rooms_query);
$stmt_rooms->bind_param("i", $selected_hotel_id);
$stmt_rooms->execute();
$rooms_result = $stmt_rooms->get_result();

$rooms = [];
if ($rooms_result->num_rows > 0) {
    while ($room = $rooms_result->fetch_assoc()) {
        $rooms[] = $room;
    }
}

$stmt_rooms->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Hotel Rooms</title>
    <link rel="stylesheet" href="styles.css">
    <link href="../css/style.css" rel="stylesheet" type="text/css" media="all" />
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h2, h3 {
            text-align: center;
            color: #333;
        }

        .room-list {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .room-card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 300px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .room-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .room-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .room-card-body {
            padding: 15px;
        }

        .room-card-body h4 {
            margin: 0;
            color: #007bff;
            font-size: 18px;
            margin-bottom: 10px;
        }

        .room-card-body p {
            margin: 5px 0;
            color: #555;
        }

        .add-room-btn {
            display: block;
            width: 200px;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-align: center;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .add-room-btn:hover {
            background-color: #0056b3;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
            padding-top: 60px;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
            border-radius: 10px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
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
                    <p class="gpa">Gps : <a href="https://www.google.com/maps/place/New+Hotel+Elite+(P)+Ltd/@27.7117484,85.3104502,17z/data=!3m1!4b1!4m9!3m8!1s0x39eb18fdefffffff:0xcf6b523c8d383f44!5m2!4m1!1i2!8m2!3d27.7117484!4d85.3130251!16s%2Fg%2F11b6dq98s8?entry=ttu">View map</a></p>
                </div>
                <div class="clear"> </div>
            </div>
        </div>
        <div class="header-top-nav">
            <div class="wrap">
                <ul>
                    <li><a href="owner_profile.php">Profile</a></li>
                    <li><a href="hotel_details_owner.php">Hotel</a></li>
                    <li class="active"><a href="room_details.php">Rooms</a></li>
                    <li><a href="services.html">Services</a></li>
                    <li><a href="gallery.html">Gallery</a></li>
                    <li><a href="contact.html">Contact</a></li>
                    <li class="logout-button"><a href="logout.php">Logout</a></li>
                    <div class="clear"> </div>
                </ul>
            </div>
        </div>
    </div>
    <div class="container">
        <h2>Manage Hotel Rooms</h2>
        <h3><?php echo htmlspecialchars($hotels[0]['hotel_name']); ?></h3>

        <div class="room-list">
            <?php if (count($rooms) > 0): ?>
                <?php foreach ($rooms as $room): ?>
                    <div class="room-card">
                        <img src="<?php echo htmlspecialchars($room['room_image']); ?>" alt="Room Image">
                        <div class="room-card-body">
                            <h4>Room Number: <?php echo htmlspecialchars($room['room_number']); ?></h4>
                            <p>Room Type: <?php echo htmlspecialchars($room['room_type']); ?></p>
                            <p>Price: $<?php echo htmlspecialchars($room['price']); ?></p>
                            <p>Availability: <?php echo htmlspecialchars($room['availability']); ?></p>
                            <p>Services: 
                                <?php 
                                $services = json_decode($room['services'], true);
                                if (is_array($services)) {
                                    echo htmlspecialchars(implode(", ", $services));
                                } else {
                                    echo htmlspecialchars($room['services']);
                                }
                                ?>
                            </p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No rooms added yet for this hotel.</p>
            <?php endif; ?>
        </div>

        <button class="add-room-btn" id="addRoomBtn">Add Room</button>

        <div id="addRoomModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h3><?php echo htmlspecialchars($hotels[0]['hotel_name']); ?></h3> <!-- Display the hotel name here -->
        <form method="post" action="add_room_process.php" enctype="multipart/form-data">
            <!-- Add the hidden input field for hotel_id -->
            <input type="hidden" name="hotel_id" value="<?php echo htmlspecialchars($selected_hotel_id, ENT_QUOTES, 'UTF-8'); ?>">

            <div class="form-group">
                <label for="room_number">Room Number</label>
                <input type="text" id="room_number" name="room_number" required>
            </div>

            <div class="form-group">
                <label for="room_type">Room Type</label>
                <input type="text" id="room_type" name="room_type" required>
            </div>

            <div class="form-group">
                <label for="price">Price per Night</label>
                <input type="number" id="price" name="price" step="0.01" required>
            </div>

            <div class="form-group">
                <label for="availability">Availability</label>
                <div class="availability-options">
                    <label>
                        <input type="checkbox" id="availability" name="availability" value="Available">
                        Available
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label>Extra Services</label>
                <div class="services">
                    <label><input type="checkbox" name="services[]" value="Wi-Fi"> Wi-Fi</label>
                    <label><input type="checkbox" name="services[]" value="TV"> TV</label>
                    <label><input type="checkbox" name="services[]" value="Attached Bathroom"> Attached Bathroom</label>
                </div>
            </div>

            <div class="form-group">
                <label for="room_image">Room Image</label>
                <input type="file" id="room_image" name="room_image" accept="image/*">
            </div>

            <div class="form-group">
                <input type="submit" value="Add Room">
            </div>
        </form>
    </div>
</div>


    <script>
        var modal = document.getElementById("addRoomModal");
        var btn = document.getElementById("addRoomBtn");
        var span = document.getElementsByClassName("close")[0];

        btn.onclick = function() {
            modal.style.display = "block";
        }

        span.onclick = function() {
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>
</html>
