<?php
require 'connection.php';

if (isset($_GET['id'])) {
    $hotel_id = intval($_GET['id']);

    // Delete hotel from the database
    $query = "DELETE FROM hotel WHERE id = $hotel_id";

    if (mysqli_query($conn, $query)) {
        echo "Hotel deleted successfully.";
    } else {
        echo "Error deleting hotel: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request.";
}

mysqli_close($conn);
?>
<br>
<a href="all-hotel.php">Back to Hotel List</a>
