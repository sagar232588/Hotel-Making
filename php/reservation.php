<?php
// Connect to your database
include 'connection.php';

if (isset($_GET['hotel_id'])) {
    $hotel_id = $_GET['hotel_id'];

    // Fetch the hotel information using the hotel_id
    $query = "SELECT name FROM hotel WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $hotel_id);
    $stmt->execute();
    $stmt->bind_result($hotel_name);
    $stmt->fetch();
    $stmt->close();

    // Fetch available rooms for the selected hotel
    $roomQuery = "SELECT room_number AS room_no, room_type FROM hotel_rooms WHERE hotel_id = ? AND availability = 'Available'";
    $stmtRooms = $conn->prepare($roomQuery);
    $stmtRooms->bind_param("i", $hotel_id);
    $stmtRooms->execute();
    $resultRooms = $stmtRooms->get_result();
    
    $rooms = [];
    while ($row = $resultRooms->fetch_assoc()) {
        $rooms[] = $row;
    }
    $stmtRooms->close();
} else {
    // Redirect back or show an error if hotel_id is not set
    header("Location: hotel_user.php");
    exit();
}
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Hotel Website | Reservation</title>
    <link href="../css/style.css" rel="stylesheet" type="text/css" media="all" />
    <link href="../css/userprofile.css" rel="stylesheet" type="text/css" media="all" />
    <link href="../css/reservation.css" rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=PT+Sans+Narrow' rel='stylesheet' type='text/css'>
</head>
<body>
    <!---start-Wrap--->
    <!---start-header--->
    <div class="header">
        <div class="wrap">
            <div class="header-top">
                <div class="logo">
                    <a href="index.html"><img src="../images/logo2.png" title="logo" /></a>
                </div>
                <div class="contact-info">
                    <p class="phone">Call us : <a href="#">9808147755, 9840602765</a></p>
                </div>
                <div class="clear"></div>
            </div>
        </div>
        <div class="header-top-nav">
            <div class="wrap">
                <ul>
                    <li class="active"><a href="reservation.php">Book Room</a></li>
                    <li><a href="hotel_user.php">Back</a></li>
                    <li class="logout-button"><a href="logout.php">Logout</a></li>
                    <div class="clear"></div>
                </ul>
            </div>
        </div>
    </div>

    <form id="bookingForm" action="process_booking.php" method="POST">
        <h4 align="left">Please fill up the form</h4>

        <!-- Hidden field for hotel ID -->
        <input type="hidden" id="hotelId" name="hotelId" value="<?php echo htmlspecialchars($hotel_id); ?>">

        <!-- Hotel name displayed -->
        <div class="form-group">
            <label for="hotelName">Hotel Name</label>
            <input type="text" id="hotelName" name="hotelName" value="<?php echo htmlspecialchars($hotel_name); ?>" readonly>
        </div>

        <div class="form-group">
            <label for="firstName">First Name</label>
            <input type="text" id="firstName" name="firstName" required>
        </div>

        <div class="form-group">
            <label for="lastName">Last Name</label>
            <input type="text" id="lastName" name="lastName" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
        </div>

        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="tel" id="phone" name="phone" pattern="[0-9]{10}" required>
        </div>

        <!-- Room Type -->
        <div class="form-group">
            <label for="roomType">Room Type:</label>
            <select id="roomType" name="roomType" class="form-control" onchange="filterRoomsByType()" required>
                <option value="-1">- Not selected -</option>
                <?php
                // Display unique room types
                $roomTypes = array_unique(array_column($rooms, 'room_type'));
                foreach ($roomTypes as $type) {
                    echo "<option value='$type'>$type</option>";
                }
                ?>
            </select>
        </div>

        <!-- Room No -->
        <div class="form-group">
            <label for="roomNo">Room No:</label>
            <select id="roomNo" name="roomNo" class="form-control" required>
                <option value="-1">- Not selected -</option>
            </select>
        </div>

        <div class="form-group">
            <label for="checkIn">Check-in Date:</label>
            <input type="date" id="checkIn" name="checkIn" required>
        </div>

        <div class="form-group">
            <label for="checkOut">Check-out Date:</label>
            <input type="date" id="checkOut" name="checkOut" required>
        </div>

        <div class="form-group">
            <button type="submit">Submit</button>
        </div>
    </form>

    <script>
        // Store all rooms for filtering
        var rooms = <?php echo json_encode($rooms); ?>;

        function filterRoomsByType() {
            var roomTypeSelect = document.getElementById("roomType");
            var roomNoSelect = document.getElementById("roomNo");
            var selectedType = roomTypeSelect.value;

            // Clear the room number select options
            roomNoSelect.innerHTML = "<option value='-1'>- Not selected -</option>";

            // Filter rooms by the selected type
            rooms.forEach(function(room) {
                if (room.room_type === selectedType) {
                    var option = document.createElement("option");
                    option.value = room.room_no;
                    option.text = room.room_no;
                    roomNoSelect.appendChild(option);
                }
            });
        }

        // Initial call to populate room options if room type is pre-selected
        filterRoomsByType();
    </script>
</body>
</html>
