<?php
session_start();
require 'connection.php';

$user_id = $_SESSION['userid'];
$review_id = $_GET['id'];

// Fetch the review details
$review_query = "SELECT * FROM hotel_reviews WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($review_query);
$stmt->bind_param("ii", $review_id, $user_id);
$stmt->execute();
$review_result = $stmt->get_result();

if ($review_result->num_rows === 1) {
    $review = $review_result->fetch_assoc();
} else {
    echo "<p>Review not found or you do not have permission to edit this review.</p>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rating = $_POST['rating'];
    $review_text = $_POST['review'];

    // Update the review
    $update_query = "UPDATE hotel_reviews SET rating = ?, review = ? WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("issi", $rating, $review_text, $review_id, $user_id);

    if ($stmt->execute()) {
        echo "<script>alert('Review updated successfully!'); window.location.href='viewhotel.php?id=" . $review['hotel_id'] . "';</script>";
    } else {
        echo "<script>alert('Failed to update review.'); window.location.href='viewhotel.php?id=" . $review['hotel_id'] . "';</script>";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Review</title>
    <link href="../css/style.css" rel="stylesheet" type="text/css" media="all" />
</head>
<body>
<div class="wrap">
    <h1>Edit Review</h1>
    <form method="post" action="">
        <label for="rating">Rating:</label>
        <select name="rating" id="rating">
            <?php for ($i = 1; $i <= 5; $i++): ?>
                <option value="<?php echo $i; ?>" <?php echo $i == $review['rating'] ? 'selected' : ''; ?>><?php echo $i; ?></option>
            <?php endfor; ?>
        </select>
        <label for="review">Review:</label>
        <textarea name="review" id="review" rows="4" required><?php echo htmlspecialchars($review['review']); ?></textarea>
        <input type="submit" value="Update Review">
    </form>
</div>
</body>
</html>
