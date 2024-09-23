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
    SELECT h.id AS hotel_id, h.name AS hotel_name, h.description AS hotel_description, 
           h.facility, h.location, h.img
    FROM hotel h
    JOIN hotel_owners o ON h.id = o.hotel_id
    WHERE o.id = ?";
    
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $owner_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $hotel = $result->fetch_assoc();
    $hotel_id = $hotel['hotel_id'];
} else {
    $hotel = null;
    $hotel_id = null;
}

$stmt->close();

// Fetch reviews and calculate the average rating
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

$ratings_query = "SELECT AVG(rating) as average_rating FROM hotel_reviews WHERE hotel_id = ?";
$stmt_avg = $conn->prepare($ratings_query);
$stmt_avg->bind_param("i", $hotel_id);
$stmt_avg->execute();
$avg_rating_result = $stmt_avg->get_result();
$average_rating = $avg_rating_result->fetch_assoc()['average_rating'] ?? 0;

$stmt_avg->close();
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
    <style>
        .container {
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
        .review-actions {
            margin-top: 5px;
        }
        .review-action {
            color: #007bff;
            text-decoration: none;
            margin-right: 10px;
        }
        .review-action:hover {
            text-decoration: underline;
        }
        .average-rating {
            font-size: 1.2em;
            font-weight: bold;
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
                    <li><a href="owner_profile.php">Profile</a></li>
                    <li class="active"><a href="hotel_details_owner.php">Hotel</a></li>
                    <li><a href="room_details.php">Rooms</a></li>
                    <!-- <li><a href="services.html">Services</a></li>
                    <li><a href="gallery.html">Gallery</a></li>
                    <li><a href="contact.html">Contact</a></li> -->
                    <li><a href="reservedetailowner.php">Booking History</a></li>
                    <li class="logout-button"><a href="logout.php">Logout</a></li>
                    <div class="clear"> </div>
                </ul>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="hotel-details">
            <h2>Your Hotel Details</h2>
            <?php if ($hotel): ?>
                <img src="uploads/<?php echo htmlspecialchars($hotel['img']); ?>" alt="Hotel Image" style="max-width: 400px;">
                <p><strong>Hotel Name:</strong> <?php echo htmlspecialchars($hotel['hotel_name']); ?></p>
                <p><strong>Description:</strong> <?php echo htmlspecialchars($hotel['hotel_description']); ?></p>
                <p><strong>Facility:</strong> <?php echo htmlspecialchars($hotel['facility']); ?></p>
                <p><strong>Location:</strong> <?php echo htmlspecialchars($hotel['location']); ?></p>
            <?php else: ?>
                <p>No hotel information found for this owner.</p>
            <?php endif; ?>
        </div>

        <div class="hotel-reviews">
            <h2>Hotel Reviews & Ratings</h2>
            <?php if ($average_rating): ?>
                <p class="average-rating">Average Rating: <?php echo number_format($average_rating, 1); ?> / 5</p>
            <?php else: ?>
                <p class="average-rating">No ratings yet.</p>
            <?php endif; ?>

            <?php if ($review_result->num_rows > 0): ?>
                <div class="reviews">
                    <?php while ($review = $review_result->fetch_assoc()): ?>
                        <div class="review-item">
                            <p><strong><?php echo htmlspecialchars($review['user_name']); ?></strong></p>
                            <div class="review-rating">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <i class="<?php echo $i <= $review['rating'] ? 'fas fa-star' : 'far fa-star'; ?>"></i>
                                <?php endfor; ?>
                            </div>
                            <p><?php echo htmlspecialchars($review['review']); ?></p>
                            <?php if ($owner_id == $review['user_id']): ?>
                                <div class="review-actions" style="display: block;">
                                    <a href="edit_review.php?id=<?php echo $review['id']; ?>" class="review-action">Edit</a>
                                    <a href="delete_review.php?id=<?php echo $review['id']; ?>&hotel_id=<?php echo $hotel_id; ?>" class="review-action" onclick="return confirm('Are you sure you want to delete this review?');" style="color: red;">Delete</a>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <p>No reviews yet.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
