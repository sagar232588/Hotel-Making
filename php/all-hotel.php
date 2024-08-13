



    <?php require 'connection.php'; ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile</title>
    <link href="../css/admin.css" rel="stylesheet" type="text/css" media="all" />
    <link href="../css/style.css" rel="stylesheet" type="text/css" media="all" />
    <!-- Include Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <style>
      /* Card Layout Styles */
      .hotel-list {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            padding: 20px 0;
        }

        .hotel-card {
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin: 15px;
            padding: 15px;
            width: 300px;
            box-sizing: border-box;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            overflow: hidden;
            position: relative;
        }

        .hotel-card:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .hotel-card img {
            border-radius: 8px;
            width: 100%;
            height: auto;
            transition: transform 0.3s ease;
        }

        .hotel-card:hover img {
            transform: scale(1.1);
        }

        .hotel-card h3 {
            margin-top: 10px;
            font-size: 20px;
        }

        .hotel-card p {
            margin: 5px 0;
            font-size: 14px;
        }

        .button-container {
            margin-top: 15px;
            display: flex;
            justify-content: space-between;
        }

        .hotel-button {
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
            width: 30%;
            transition: background-color 0.3s ease;
        }

        .hotel-button:hover {
            background-color: #0056b3;
        }

        .edit-button {
            background-color: #28a745;
        }

        .edit-button:hover {
            background-color: #218838;
        }

        .delete-button {
            background-color: #dc3545;
        }

        .delete-button:hover {
            background-color: #c82333;
        }

        /* Rating Stars */
        .rating {
            display: flex;
            margin-top: 10px;
        }

        .rating i {
            font-size: 20px;
            color: gold;
            margin-right: 5px;
            cursor: pointer;
            transition: transform 0.2s ease;
        }

        .rating i:hover {
            transform: scale(1.2);
        }

        .selected {
            color: gold;
        }

        /* Modal Styles */
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
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 600px;
            border-radius: 8px;
            box-sizing: border-box;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
        }

        /* Add Hotel Button Styles */
        .add-hotel-button {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            color: white;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 20px 0;
            text-align: center;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .add-hotel-button:hover {
            background-color: #0056b3;
        }
    </style>
    <link href="../css/style.css" rel="stylesheet" type="text/css" media="all" />
    <style>
        .hotel-list {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            padding: 20px 0;
        }

        .hotel-card {
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin: 15px;
            padding: 15px;
            width: 300px;
            box-sizing: border-box;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            overflow: hidden;
            position: relative;
        }

        .hotel-card:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .hotel-card img {
            border-radius: 8px;
            width: 100%;
            height: auto;
            transition: transform 0.3s ease;
        }

        .hotel-card:hover img {
            transform: scale(1.1);
        }

        .hotel-card h3 {
            margin-top: 10px;
            font-size: 20px;
        }

        .hotel-card p {
            margin: 5px 0;
            font-size: 14px;
        }

        .rating-stars i {
            color: #ddd; /* Default color for uncolored stars */
            transition: color 0.3s ease;
        }

        .rating-stars i.filled {
            color: gold; /* Color for filled stars */
        }

        .button-container {
            margin-top: 15px;
            display: flex;
            justify-content: space-between;
        }

        .hotel-button {
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
            width: 30%;
            transition: background-color 0.3s ease;
        }

        .hotel-button:hover {
            background-color: #0056b3;
        }

        .edit-button {
            background-color: #28a745;
        }

        .edit-button:hover {
            background-color: #218838;
        }

        .delete-button {
            background-color: #dc3545;
        }

        .delete-button:hover {
            background-color: #c82333;
        }
        #map {
            width: 100%;
            height: 300px;
            margin-top: 10px;
        }

        /* Adjust modal content size to fit the map */
        .modal-content {
            width: 80%;
            max-width: 600px;
            height: auto;
            padding: 20px;
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
                    <p class="phone">Call us: <a href="#">9808147755, 9840602765</a></p>
                    <p class="gpa">Gps: <a href="https://www.google.com/maps/place/New+Hotel+Elite+(P)+Ltd/@27.7117484,85.3104502,17z/data=!3m1!4b1!4m9!3m8!1s0x39eb18fdefffffff:0xcf6b523c8d383f44!5m2!4m1!1i2!8m2!3d27.7117484!4d85.3130251!16s%2Fg%2F11b6dq98s8?entry=ttu">View map</a></p>
                </div>
                <div class="clear"> </div>
            </div>
        </div>
        <div class="header-top-nav">
            <div class="wrap">
                <ul>
                    <li><a href="admin_profile.php">Booking Details</a></li>
                    <li class="active"><a href="all-hotel.php">Our Hotels</a></li>
                    <li><a href="dispcontact.php">Messages</a></li>
                    <li><a href="userdetail.php">User Details</a></li>
                    <li class="logout-button"><a href="logout.php">Logout</a></li>
                    <div class="clear"> </div>
                </ul>
            </div>
        </div>
    </div>

    <div style="width:100%;background:whitesmoke;padding:20px 0;margin-top: 20px;">
        <div class="wrap">
            <button class="add-hotel-button" id="addHotelBtn">Add Hotel</button>
            <h2>List of Hotels</h2>
            <div class="hotel-list">
                <?php
                 // Fetch hotel details from the database
                 $query = "SELECT * FROM hotel";
                 $result = mysqli_query($conn, $query);
     
                 if (mysqli_num_rows($result) > 0) {
                     while($row = mysqli_fetch_assoc($result)) {
                         // Fetch average rating
                         $hotel_id = $row['id'];
                         $rating_query = "SELECT AVG(rating) as avg_rating FROM hotel_reviews WHERE hotel_id = $hotel_id";
                         $rating_result = mysqli_query($conn, $rating_query);
                         $rating = mysqli_fetch_assoc($rating_result)['avg_rating'];
                         $rating = $rating ? round($rating) : 0; // Default to 0 if no rating
                         
                         echo "<div class='hotel-card'>";
                         echo "<img src='uploads/" . htmlspecialchars($row['img']) . "' alt='Hotel Image'>";
                         echo "<h3>" . htmlspecialchars($row['name']) . "</h3>";
                         echo "<p><strong>Description:</strong> " . htmlspecialchars($row['description']) . "</p>";
                         echo "<p><strong>Facilities:</strong> " . htmlspecialchars($row['facility']) . "</p>";
                         echo "<p><strong>Location:</strong> " . htmlspecialchars($row['location']) . "</p>";
     
                         // Display average rating with stars
                         echo "<p><strong>Average Rating:</strong></p>";
                         echo "<div class='rating-stars'>";
                         for ($i = 1; $i <= 5; $i++) {
                             $star_class = $i <= $rating ? 'fas fa-star filled' : 'far fa-star';
                             echo "<i class='$star_class'></i>";
                         }
                         echo "</div>";
     
                         echo "<div class='button-container'>";
                         echo "<a href='viewhotel.php?id=" . $row['id'] . "' class='hotel-button'>View</a>";
                         echo "<a href='edithotel.php?id=" . $row['id'] . "' class='hotel-button edit-button'>Edit</a>";
                         echo "<a href='deletehotel.php?id=" . $row['id'] . "' class='hotel-button delete-button' onclick=\"return confirm('Are you sure you want to delete this hotel?');\">Delete</a>";
                         echo "</div>";
                         echo "</div>";
                     }
                 } else {
                     echo "<p>No hotels have been added yet.</p>";
                 }
     
                 mysqli_close($conn);
                
                ?>
            </div>
        </div>
    </div>

    <!-- The Modal -->
    <div id="hotelModal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Add New Hotel</h2>
            <form class="hotel-form" method="post" action="addnewhotel.php" enctype="multipart/form-data">
                <input type="text" name="name" placeholder="Hotel Name" required /><br />
                <input type="text" name="description" placeholder="Hotel Description" required /><br />
                <input type="text" name="facility" placeholder="Facilities" required /><br />
                <input type="text" name="location" placeholder="Location" required/><br/>

                <!-- Add a map container -->
                <div id="map"></div><br />
                <!-- Hidden inputs to store latitude and longitude -->
                <input type="hidden" id="latitude" name="latitude" required />
                <input type="hidden" id="longitude" name="longitude" required />
                <input type="file" name="file" id="fileToUpload" required><br />
                <input type="submit" value="Add Hotel" name="submit"><br />
            </form>
        </div>
    </div>

    <!-- Include Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
        // Get the modal
        var modal = document.getElementById("hotelModal");

        // Get the button that opens the modal
        var btn = document.getElementById("addHotelBtn");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks the button, open the modal 
        btn.onclick = function () {
            modal.style.display = "block";
            map.invalidateSize(); // Fix for Leaflet map rendering issues
        }

        // When the user clicks on <span> (x), close the modal
        span.onclick = function () {
            modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function (event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        // Initialize Leaflet map
        var map = L.map('map').setView([27.7117484, 85.3104502], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        var marker;

        // Add click event to the map
        map.on('click', function (e) {
            if (marker) {
                map.removeLayer(marker);
            }
            marker = L.marker(e.latlng).addTo(map);

            // Set the latitude and longitude values in the hidden fields
            document.getElementById('latitude').value = e.latlng.lat;
            document.getElementById('longitude').value = e.latlng.lng;
        });
    </script>
</body>
</html>
