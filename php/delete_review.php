<?php
session_start();
require 'connection.php';

$user_id = $_SESSION['userid'];
$review_id = $_GET['id'];

// Check if the review belongs to the current user
$check_query = "SELECT * FROM hotel_reviews WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($check_query);
$stmt->bind_param("ii", $review_id, $user_id);
$stmt->execute();
$check_result = $stmt->get_result();

if ($check_result->num_rows === 1) {
    // Delete the review
    $delete_query = "DELETE FROM hotel_reviews WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("ii", $review_id, $user_id);

    if ($stmt->execute()) {
        echo "<script>alert('Review deleted successfully!'); window.location.href='viewhotel.php?id=" . $_GET['hotel_id'] . "';</script>";
    } else {
        echo "<script>alert('Failed to delete review.'); window.location.href='viewhotel.php?id=" . $_GET['hotel_id'] . "';</script>";
    }

    $stmt->close();
} else {
    echo "<p>Review not found or you do not have permission to delete this review.</p>";
}

$conn->close();
?>
