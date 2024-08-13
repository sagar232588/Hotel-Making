<?php
session_start();
require 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $hotel_id = $_POST['hotel_id'];
    $rating = $_POST['rating'];
    $review_text = $_POST['review'];
    $user_id = $_SESSION['userid'];

    // Check if the user has already rated this hotel
    $check_rating_query = "SELECT * FROM hotel_reviews WHERE hotel_id = $hotel_id AND user_id = $user_id";
    $check_rating_result = mysqli_query($conn, $check_rating_query);

    if (mysqli_num_rows($check_rating_result) > 0) {
        // User has already rated this hotel
        echo "<script>alert('You have already rated this hotel.'); window.location.href='viewhotel.php?id=$hotel_id';</script>";
    } else {
        // Insert the new review
        $stmt = $conn->prepare("INSERT INTO hotel_reviews (hotel_id, user_id, rating, review) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiss", $hotel_id, $user_id, $rating, $review_text);

        if ($stmt->execute()) {
            echo "<script>alert('Review submitted successfully!'); window.location.href='viewhotel.php?id=$hotel_id';</script>";
        } else {
            echo "<script>alert('Failed to submit review.'); window.location.href='viewhotel.php?id=$hotel_id';</script>";
        }

        $stmt->close();
    }

    $conn->close();
}
?>
