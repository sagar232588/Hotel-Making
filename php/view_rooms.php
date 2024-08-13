<?php
require 'connection.php';
session_start();
$hotel_id = isset($_GET['hotel_id']) ? intval($_GET['hotel_id']) : 0;
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Rooms</title>
    <link href="../css/admin.css" rel="stylesheet" type="text/css" media="all" />
    <link href="../css/style.css" rel="stylesheet" type="text/css" media="all" />
    <style>
        /* Styles for room cards */
        .room-card {
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin: 15px;
            padding: 15px;
            width: 300px;
            box-sizing: border-box;
        }
        .room-card h3 {
            margin-top: 0;
        }
        .room-card p {
            margin: 5px 0;
        }
        .book-room-button {
            display: inline-block;
            padding: 10px 15px;
            font-size: 14px;
            color: white;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
        }
        .book-room-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<div class="header">
    <!-- Include header navigation here -->
</div>

<div style="width:100%;background:whitesmoke;padding:20px 0;margin-top: 20px;">
    <div class="wrap">
        <!-- Display list of rooms -->
        <h2>Rooms in Hotel</h2>
        <div class="room-list">
            <?php
            $query = "SELECT * FROM rooms WHERE hotel_id = ? AND availability = TRUE";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $hotel_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<div class='room-card'>";
                    echo "<h3>Room Number: " . htmlspecialchars($row['room_number']) . "</h3>";
                    echo "<p><strong>Type:</strong> " . htmlspecialchars($row['room_type']) . "</p>";
                    echo "<p><strong>Price:</strong> $" . htmlspecialchars($row['price']) . "</p>";
                    echo "<a href='book_room_action.php?room_id=" . $row['id'] . "' class='book-room-button'>Book Now</a>";
                    echo "</div>";
                }
            } else {
                echo "<p>No rooms available for booking.</p>";
            }

            $stmt->close();
            $conn->close();
            ?>
        </div>
    </div>
</div>
</body>
</html>
