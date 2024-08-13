<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['userid'])) {
   header('Location: signup.php');
   exit;
}

// Rest of the code for the user profile page
include 'connection.php';
$userid = $_SESSION['userid'];

// Fetch user data from the database
$query = "SELECT * FROM user_data WHERE userid = '$userid'";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) == 0) {
   echo "Failed to fetch user data";
   exit;
}

$fetch = mysqli_fetch_assoc($result);
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Hotel Website | User Profile</title>
    <link href="../css/style.css" rel="stylesheet" type="text/css" media="all" />
    <link href="../css/userprofile.css" rel="stylesheet" type="text/css" media="all" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        #map {
            height: 400px; /* Adjust height as needed */
            width: 100%;
            margin-top: 20px;
        }
    </style>
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
                    <p class="phone">Call us : <a href="#">9808147755,9840602765</a></p>
                    <p class="gpa">Gps : <a href="https://www.google.com/maps/place/New+Hotel+Elite+(P)+Ltd/@27.7117484,85.3104502,17z/data=!3m1!4b1!4m9!3m8!1s0x39eb18fdefffffff:0xcf6b523c8d383f44!5m2!4m1!1i2!8m2!3d27.7117484!4d85.3130251!16s%2Fg%2F11b6dq98s8?entry=ttu">View map</a></p>
                </div>
                <div class="clear"> </div>
            </div>
        </div>
        <div class="header-top-nav">
            <div class="wrap">
                <ul>
                    <li class="active"><a href="user_profile.php">Profile</a></li>
                    <li ><a href="hotel_user.php">Our Hotels</a></li>
                    <li><a href="../room_details.html">Room Details</a></li>
                    <li><a href="reservdetail.php">Booking Details</a></li>
                    <li class="logout-button"><a href="logout.php">Logout</a></li>
                    <div class="clear"> </div>
                </ul>
            </div>
        </div>
    </div>
    <div class="settings">
        <h3>Account Details</h3>
        <form>
            <div class="form-group">
                <label for="firstName">First Name</label>
                <input type="text" id="firstName" name="firstName" value="<?php echo $fetch['fname']; ?>" disabled>
            </div>
            <div class="form-group">
                <label for="lastName">Last Name</label>
                <input type="text" id="lastName" name="lastName" value="<?php echo $fetch['lname']; ?>" disabled>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php echo $fetch['email']; ?>" disabled>
            </div>
        </form>
        <div id="map"></div>
    </div>

	<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
    // Initialize the map
    var map = L.map('map').setView([51.505, -0.09], 13);

    // Add OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Get user's location
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            var lat = position.coords.latitude;
            var lon = position.coords.longitude;

            // Set the map view to the user's location
            map.setView([lat, lon], 13);

            // Add a marker for the user's location
            L.marker([lat, lon]).addTo(map)
                .bindPopup("You are here")
                .openPopup();
            
            // Fetch and display nearby hotels
            fetch(`getHotels.php?lat=${lat}&lon=${lon}`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(hotel => {
                        L.marker([hotel.location_lat, hotel.location_lon]).addTo(map)
                            .bindPopup(`<a href="hotel_user.php?id=${hotel.id}">${hotel.name}</a><br>Distance: ${hotel.distance.toFixed(2)} km`);
                    });
                })
                .catch(error => console.error('Error fetching hotels:', error));
        });
    } else {
        alert("Geolocation is not supported by this browser.");
    }
</script>


</body>
</html>
