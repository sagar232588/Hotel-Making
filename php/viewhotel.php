<?php
require 'connection.php';
session_start(); // Start the session to track logged-in user

// Check if the user is logged in by verifying if the 'userid' exists in the session


$user_id = $_SESSION['userid']; // Assuming user ID is stored in the session after login
$hotel_id = isset($_GET['id']) ? intval($_GET['id']) : 0; // Validate and sanitize the hotel ID

if ($hotel_id <= 0) {
    die('Invalid hotel ID.');
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Hotel</title>
    <link href="../css/style.css" rel="stylesheet" type="text/css" media="all" />
    		<link href='http://fonts.googleapis.com/css?family=PT+Sans+Narrow' rel='stylesheet' type='text/css'> 
		
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <style>
        .content {
            display: flex;
            flex-wrap: wrap;
            margin-top: 20px;
        }

        .hotel-details, .hotel-reviews {
            flex: 1;
            min-width: 50%;
            box-sizing: border-box;
            padding: 20px;
        }

        .hotel-details {
            border-right: 1px solid #ddd;
        }

        .reviews {
            margin-top: 20px;
        }

        .review-item {
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
        }

        .review-rating i {
            color: gold;
        }

        .rating-stars i {
            color: gold;
        }

        .room-list {
            margin-top: 30px;
        }

        .room-item {
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
        }

        .booking-button {
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
            display: inline-block;
        }

        .booking-button:hover {
            background-color: #0056b3;
        }

        .review-form {
            margin-top: 20px;
        }

        .review-form textarea, .review-form input[type="submit"], .review-form select {
            display: block;
            margin-top: 10px;
            width: 100%;
        }

        .review-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .review-actions {
            margin-top: 10px;
            display: flex;
            gap: 10px;
        }

        .review-action {
            color: #007bff;
            text-decoration: none;
            padding: 5px 10px;
            border: 1px solid #007bff;
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
        }

        .review-action:hover {
            background-color: #007bff;
            color: white;
        }

        .back-button {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 20px;
            font-size: 16px;
            color: #fff;
            background-color: #007BFF; /* Blue color */
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
        }

        .back-button:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }

        .map-container {
            height: 300px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="header">
    <a href="hotel_user.php" class="back-button">Back to Hotels</a>
</div>

<div class="wrap">
    <div class="content">
        <!-- Hotel Details Section -->
        <div class="hotel-details">
            <?php
            // Fetch hotel details
            $hotel_query = "SELECT * FROM hotel WHERE id = ?";
            $stmt = $conn->prepare($hotel_query);
            $stmt->bind_param("i", $hotel_id);
            $stmt->execute();
            $hotel_result = $stmt->get_result();

            if ($hotel_result->num_rows > 0) {
                $hotel = $hotel_result->fetch_assoc();
                
                // Fetch average rating and total number of ratings
                $rating_query = "SELECT AVG(rating) as avg_rating, COUNT(rating) as total_ratings FROM hotel_reviews WHERE hotel_id = ?";
                $stmt = $conn->prepare($rating_query);
                $stmt->bind_param("i", $hotel_id);
                $stmt->execute();
                $rating_result = $stmt->get_result();
                $rating_data = $rating_result->fetch_assoc();
                $avg_rating = round($rating_data['avg_rating']);  // Rounding to the nearest whole number
                $total_ratings = $rating_data['total_ratings']; // Total number of ratings

                echo "<h1>" . htmlspecialchars($hotel['name']) . "</h1>";
                echo "<img src='uploads/" . htmlspecialchars($hotel['img']) . "' alt='Hotel Image'>";
                echo "<p><strong>Description:</strong> " . htmlspecialchars($hotel['description']) . "</p>";
                echo "<p><strong>Facilities:</strong> " . htmlspecialchars($hotel['facility']) . "</p>";
                echo "<p><strong>Location:</strong> " . htmlspecialchars($hotel['location']) . "</p>";

                // Map container for hotel location
                echo "<div id='map' class='map-container'></div>";

                // Fetch available rooms
                echo "<h3>Available Rooms:</h3>";
                $room_query = "SELECT * FROM hotel_rooms WHERE hotel_id = ?";
                $stmt = $conn->prepare($room_query);
                $stmt->bind_param("i", $hotel_id);
                $stmt->execute();
                $room_result = $stmt->get_result();

                if ($room_result->num_rows > 0) {
                    echo "<div class='room-list'>";
                    while ($room = $room_result->fetch_assoc()) {
                        echo "<div class='room-item'>";
                        echo "<h4>" . htmlspecialchars($room['room_type']) . "</h4>";
                        echo "<p><strong>Price:</strong> $" . htmlspecialchars($room['price']) . " per night</p>";
                        echo "<p><strong>Services:</strong> " . htmlspecialchars($room['services']) . "</p>";
                        echo "<a href='reservation.php?room_id=" . htmlspecialchars($room['id']) . "' class='booking-button'>Book Now</a>";
                        echo "</div>";
                    }
                    echo "</div>";
                } else {
                    echo "<p>No rooms available.</p>";
                }

            } else {
                echo "<p>Hotel not found.</p>";
            }
            ?>
        </div>

         <!-- Hotel Reviews Section -->
    <div class="hotel-reviews">
        <?php
        // Calculate and display the average rating
        $avg_rating_query = "
            SELECT AVG(rating) as avg_rating 
            FROM hotel_reviews 
            WHERE hotel_id = ?";
        $stmt = $conn->prepare($avg_rating_query);
        $stmt->bind_param("i", $hotel_id);
        $stmt->execute();
        $avg_rating_result = $stmt->get_result();
        $avg_rating_row = $avg_rating_result->fetch_assoc();
        $average_rating = round($avg_rating_row['avg_rating'], 1);
    
        echo "<div class='average-rating'>";
        echo "<h3>Average Rating: $average_rating</h3>";
          // Display total number of ratings
    
          echo "<p>Total Ratings: $total_ratings</p>";

    
        // Display stars for the average rating
        echo "<div class='rating-stars'>";
        for ($i = 1; $i <= 5; $i++) {
            $star_class = $i <= $average_rating ? 'fas fa-star' : 'far fa-star';
            echo "<i class='$star_class'></i>";
        }
        echo "</div>";
        echo "</div>";
        
        // Fetch reviews with user names
        $review_query = "
            SELECT hr.*, CONCAT(u.fname, ' ', u.lname) as user_name 
            FROM hotel_reviews hr 
            JOIN user_data u ON hr.user_id = u.userid 
            WHERE hr.hotel_id = ? 
            ORDER BY hr.created_at DESC";
        $stmt = $conn->prepare($review_query);
        $stmt->bind_param("i", $hotel_id);
        $stmt->execute();
        $review_result = $stmt->get_result();

        echo "<h3>User Reviews</h3>";
        echo "<div class='reviews'>";
        if ($review_result->num_rows > 0) {
            while ($review = $review_result->fetch_assoc()) {
                $review_rating = $review['rating'];
                $review_text = htmlspecialchars($review['review']);
                $user_name = htmlspecialchars($review['user_name']);
                $review_id = $review['id'];

                echo "<div class='review-item'>";
                echo "<div class='review-header'>";
                echo "<span class='reviewer-name'>" . $user_name . "</span>";
                echo "<div class='review-rating'>";
                for ($i = 1; $i <= 5; $i++) {
                    $star_class = $i <= $review_rating ? 'fas fa-star' : 'far fa-star';
                    echo "<i class='$star_class'></i>";
                }
                echo "</div>";
                echo "</div>";
                echo "<p class='review-text'>" . $review_text . "</p>";

                // Show edit and delete options only if the current user is the one who wrote the review
                if ($user_id == $review['user_id']) {
                    echo "<div class='review-actions'>";
                    echo "<a href='edit_review.php?id=$review_id' class='review-action'>Edit</a>";
                    echo "<a href='delete_review.php?id=$review_id&hotel_id=$hotel_id' class='review-action' onclick='return confirm(\"Are you sure you want to delete this review?\");'>Delete</a>";
                    echo "</div>";
                }

                echo "</div>";
            }
        } else {
            echo "<p>No reviews yet. Be the first to review this hotel!</p>";
        }
        echo "</div>";

        // Check if the user has already rated this hotel
        $user_rating_query = "SELECT * FROM hotel_reviews WHERE hotel_id = ? AND user_id = ? AND rating IS NOT NULL";
        $stmt = $conn->prepare($user_rating_query);
        $stmt->bind_param("ii", $hotel_id, $user_id);
        $stmt->execute();
        $user_rating_result = $stmt->get_result();
        $user_has_rated = $user_rating_result->num_rows > 0;

        // Review Submission Form
        echo "<div class='review-form'>";
        echo "<h3>Write a Review</h3>";
        echo "<form method='post' action='submit_review.php'>";

        // If user hasn't rated the hotel, show the rating dropdown
        if (!$user_has_rated) {
            echo "<div class='form-group'>";
            echo "<label for='rating'>Rating:</label>";
            echo "<select name='rating' id='rating' class='form-control'>";
            for ($i = 1; $i <= 5; $i++) {
                echo "<option value='$i'>$i Star" . ($i > 1 ? 's' : '') . "</option>";
            }
            echo "</select>";
            echo "</div>";
        } else {
            echo "<p>You have already rated this hotel.</p>";
        }

        echo "<div class='form-group'>";
        echo "<label for='review'>Your Review:</label>";
        echo "<textarea name='review' id='review' rows='4' class='form-control' placeholder='Share your experience...' required></textarea>";
        echo "</div>";
        echo "<input type='hidden' name='hotel_id' value='$hotel_id'>";
        echo "<button type='submit' class='submit-button'>Submit Review</button>";
        echo "</form>";
        echo "</div>";
        ?>
    </div>
</div>
</div>

<script>
    // Initialize the map
    var map = L.map('map').setView([<?php echo htmlspecialchars($hotel['latitude']); ?>, <?php echo htmlspecialchars($hotel['longitude']); ?>], 13);

    // Set up the OpenStreetMap layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap'
    }).addTo(map);

    // Add a marker for the hotel location
    L.marker([<?php echo htmlspecialchars($hotel['latitude']); ?>, <?php echo htmlspecialchars($hotel['longitude']); ?>]).addTo(map)
        .bindPopup("<b><?php echo htmlspecialchars($hotel['name']); ?></b><br><?php echo htmlspecialchars($hotel['location']); ?>")
        .openPopup();
</script>

</body>
</html>
