<?php require 'connection.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link href="../css/style.css" rel="stylesheet" type="text/css" media="all" />
	<link href='http://fonts.googleapis.com/css?family=PT+Sans+Narrow' rel='stylesheet' type='text/css'> 
		
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
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

        /* Rating Stars */
        .rating-stars i {
            color: #ddd; /* Default color for uncolored stars */
            transition: color 0.3s ease;
        }

        .rating-stars i.filled {
            color: gold; /* Color for filled stars */
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
            <ul>
			<li ><a href="../index.html">Home</a></li>
			<li class="active"><a href="hotel.php">Our Hotels</a></li>
			<li><a href="../about.html">About</a></li>
			<li><a href="../services.html">Services</a></li>
			<li><a href="../gallery.html">Gallery</a></li>
			<li><a href="../contact.html">Contact</a></li>
			<li class="login-button"><a href="signup.php">Login</a></li>
			<div class="clear"> </div>
                </ul>
            </ul>
        </div>
    </div>
</div>

<div style="width:100%;background:whitesmoke;padding:20px 0;margin-top: 20px;">
    <div class="wrap">
        <h2>List of Hotels</h2>
		<form method="GET" action="">
                <input type="text" name="search" placeholder="Search hotels by name..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" />
                <input type="submit" value="Search" />
            </form>
        <div class="hotel-list">
            <?php
            // Get the search input
			$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
			// Modified query to include search functionality
		  $query = "SELECT * FROM hotel WHERE name LIKE '%$search%'";
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


<script src="https://kit.fontawesome.com/a076d05399.js"></script>
<script>
    // Get the modal
    var modal = document.getElementById("hotelModal");

    // Get the button that opens the modal
    var btn = document.getElementById("addHotelBtn");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks the button, open the modal 
    btn.onclick = function() {
        modal.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>
</body>
</html>
