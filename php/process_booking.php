<?php
include "connection.php";
session_start();

// Check if user is logged in
if (!isset($_SESSION['userid'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and validate the form data
    $userid = $_SESSION['userid'];
    $firstName = trim($_POST['firstName']);
    $lastName = trim($_POST['lastName']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $roomType = trim($_POST['roomType']);
    $roomNo = trim($_POST['roomNo']);
    $checkInDate = trim($_POST['checkIn']);
    $checkOutDate = trim($_POST['checkOut']);
    $status = "Pending";

    // Basic validation
    if (empty($firstName) || empty($lastName) || empty($email) || empty($phone) || empty($roomType) || empty($roomNo) || empty($checkInDate) || empty($checkOutDate)) {
        echo "All fields are required.";
        exit();
    }

    // Validate that check-in date is not after check-out date
    if (strtotime($checkInDate) >= strtotime($checkOutDate)) {
        echo "Check-in date must be before check-out date.";
        exit();
    }

    // Sanitize the form data
    $firstName = mysqli_real_escape_string($conn, $firstName);
    $lastName = mysqli_real_escape_string($conn, $lastName);
    $email = mysqli_real_escape_string($conn, $email);
    $phone = mysqli_real_escape_string($conn, $phone);
    $roomType = mysqli_real_escape_string($conn, $roomType);
    $roomNo = mysqli_real_escape_string($conn, $roomNo);
    $checkInDate = mysqli_real_escape_string($conn, $checkInDate);
    $checkOutDate = mysqli_real_escape_string($conn, $checkOutDate);

    // Prepare the SQL statement using prepared statements
    $stmt = $conn->prepare("INSERT INTO hotel_bookings (user_id, hotel_id, first_name, last_name, email, phone, room_type, room_no, check_in, check_out, booking_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $hotelId = $_POST['hotelId']; // Assuming hotel_id is also submitted in the form
    $stmt->bind_param("iisssssssss", $userid, $hotelId, $firstName, $lastName, $email, $phone, $roomType, $roomNo, $checkInDate, $checkOutDate, $status);

    // Execute the statement
    if ($stmt->execute()) {
        // Booking successful
        echo '<script>alert("Booking recorded successfully!");</script>';
        echo '<script>window.location.href = "reservation.php";</script>';
    } else {
        // Error in the query
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
} else {
    // Redirect if the form was not submitted
    header("Location: reservation.php");
    exit();
}

// Close the database connection
mysqli_close($conn);
?>
