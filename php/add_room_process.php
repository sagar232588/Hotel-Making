<?php
session_start();
require 'connection.php';

// Check if the user is logged in and has the role of 'owner'
if (!isset($_SESSION['userid']) || $_SESSION['role'] !== 'owner') {
    header("Location: loginvalidation.php");
    exit();
}

$owner_id = $_SESSION['userid'];

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $hotel_id = isset($_POST['hotel_id']) ? $_POST['hotel_id'] : null; // Make sure to use 'hotel_id' in the form
    $room_number = $_POST['room_number'] ?? null;
    $room_type = $_POST['room_type'] ?? null;
    $price = $_POST['price'] ?? null;
    $availability = isset($_POST['availability']) ? 'Available' : 'Not Available';

    // Handle file upload
    $image_path = null;
    if (isset($_FILES['room_image']) && $_FILES['room_image']['error'] === 0) {
        $file_tmp = $_FILES['room_image']['tmp_name'];
        $file_name = $_FILES['room_image']['name'];
        $file_size = $_FILES['room_image']['size'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        
        // Define allowed file types and size limit
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];
        $max_size = 5 * 1024 * 1024; // 5MB

        if (in_array($file_ext, $allowed_ext) && $file_size <= $max_size) {
            // Generate a unique file name and move the file
            $new_file_name = uniqid('', true) . '.' . $file_ext;
            $upload_dir = 'uploads/';
            $image_path = $upload_dir . $new_file_name;

            if (!move_uploaded_file($file_tmp, $image_path)) {
                echo "<script>alert('Failed to move uploaded file.');</script>";
                exit();
            }
        } else {
            echo "<script>alert('Invalid file type or file size too large.');</script>";
            exit();
        }
    }

    // Handle selected services
    $services = isset($_POST['services']) ? $_POST['services'] : [];
    $services_json = json_encode($services);

    // Prepare and execute SQL query to insert room data
    $stmt = $conn->prepare("INSERT INTO hotel_rooms (hotel_id, room_number, room_type, price, availability, room_image, services) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issdsss", $hotel_id, $room_number, $room_type, $price, $availability, $image_path, $services_json);

    try {
        if ($stmt->execute()) {
            echo "<script>alert('Room added successfully!');</script>";
        } else {
            throw new Exception($stmt->error);
        }
    } catch (Exception $e) {
        if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
            echo "<script>alert('Error: Duplicate room number for this hotel.');</script>";
        } else {
            echo "<script>alert('Failed to add room: " . addslashes($e->getMessage()) . "');</script>";
        }
    }

    $stmt->close();
    $conn->close();
}
?>
