<?php
session_start();
require 'connection.php'; // Ensure this file contains the database connection code

// Check if the user is logged in and has the role of 'owner'
if (!isset($_SESSION['userid']) || $_SESSION['role'] !== 'owner') {
    header("Location: loginvalidation.php");
    exit();
}

// Validate the booking ID and booking status from the form
if (isset($_POST['booking_id']) && isset($_POST['booking_status'])) {
    $booking_id = intval($_POST['booking_id']);
    $booking_status = $_POST['booking_status'];

    // Ensure the booking status is one of the valid options
    $valid_statuses = ['Pending', 'Confirmed', 'Cancelled'];
    if (!in_array($booking_status, $valid_statuses)) {
        // Invalid status, redirect with error
        header("Location: reservedetailowner.php?error=invalid_status");
        exit();
    }

    // Prepare the SQL query to update the booking status
    $query = "UPDATE hotel_bookings SET booking_status = ? WHERE booking_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('si', $booking_status, $booking_id);

    // Execute the update query
    if ($stmt->execute()) {
        // Redirect back to the booking history page with a success message
        header("Location: reservedetailowner.php?success=booking_updated");
    } else {
        // Redirect back with an error if the query failed
        header("Location: reservedetailowner.php?error=update_failed");
    }

    // Close the statement
    $stmt->close();
} else {
    // Redirect back with an error if the form data is missing
    header("Location: reservedetailowner.php?error=missing_data");
}

// Close the database connection
$conn->close();
exit();
?>
