<?php
include "connection.php";
session_start();
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the form data
    $userid = $_SESSION['userid'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    
    $roomType = $_POST['roomType'];
    $roomNo = $_POST['roomNo'];
    $checkInDate = $_POST['checkIn'];
    $checkOutDate = $_POST['checkOut'];
   
    $country = $_POST['country'];
    
    $status = "Pending";

    // Sanitize the form data
    $firstName = mysqli_real_escape_string($conn, $firstName);
    $lastName = mysqli_real_escape_string($conn, $lastName);
    $email = mysqli_real_escape_string($conn, $email);
    $phone = mysqli_real_escape_string($conn, $phone);
   
    $roomType = mysqli_real_escape_string($conn, $roomType);
    $roomNo = mysqli_real_escape_string($conn, $roomNo);
    $checkInDate = mysqli_real_escape_string($conn, $checkInDate);
    $checkOutDate = mysqli_real_escape_string($conn, $checkOutDate);
    
    $country = mysqli_real_escape_string($conn, $country);
  
    $status = mysqli_real_escape_string($conn, $status);

    // Prepare the SQL statement
    $query = "INSERT INTO bookings (user_id, first_name, last_name, email, phone, room_type, room_no, check_in_date, check_out_date,country,  status)
              VALUES ('$userid','$firstName', '$lastName', '$email', '$phone', '$roomType', '$roomNo', '$checkInDate', '$checkOutDate', '$country', '$status')";

// Execute the query
if (mysqli_query($conn, $query)) {
    // Successful insertion
    echo '<script>alert("Booking recorded successfully!");</script>';
    // Redirect the user to booking.php
    echo '<script>window.location.href = "reservation.php";</script>';
} else {
    // Error in insertion
    echo "Error: " . mysqli_error($conn);
}

// ...

} else {
    // Redirect the user if the form is not submitted
    header("Location: reservation.php");
    exit();
}

mysqli_close($conn);
?>