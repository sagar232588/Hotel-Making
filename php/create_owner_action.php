<?php
session_start();
require 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $hotel_id = isset($_POST['hotel_id']) ? $_POST['hotel_id'] : '';
    $owner_name = isset($_POST['owner_name']) ? $_POST['owner_name'] : '';
    $owner_email = isset($_POST['owner_email']) ? $_POST['owner_email'] : '';
   
    $owner_phone = isset($_POST['owner_phone']) ? $_POST['owner_phone'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';

    // Check if all fields are filled
    if (empty($hotel_id) || empty($owner_name) || empty($owner_email)  || empty($owner_phone) || empty($password) || empty($confirm_password)) {
        echo "<script>alert('All fields are required.'); window.location.href='create_owner.php';</script>";
        exit();
    }

    // Check if phone number has at least 10 digits
    if (strlen($owner_phone) < 10) {
        echo "<script>alert('Phone number must be at least 10 digits.'); window.location.href='create_owner.php';</script>";
        exit();
    }

    // Check if passwords match
    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match.'); window.location.href='create_owner.php';</script>";
        exit();
    }

    // No hashing: storing password as plaintext (for testing purposes only)
    $plain_password = $password;

    // Check if the email already exists
    $check_query = "SELECT * FROM hotel_owners WHERE owner_email = ?";
    $stmt = $conn->prepare($check_query);
    $stmt->bind_param("s", $owner_email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Email already exists. Please choose another.'); window.location.href='create_owner.php';</script>";
    } else {
        // Check if the hotel already has an owner
        $hotel_check_query = "SELECT * FROM hotel WHERE id = ? AND owner_id IS NOT NULL";
        $stmt = $conn->prepare($hotel_check_query);
        $stmt->bind_param("i", $hotel_id);
        $stmt->execute();
        $hotel_result = $stmt->get_result();

        if ($hotel_result->num_rows > 0) {
            echo "<script>alert('This hotel already has an owner.'); window.location.href='create_owner.php';</script>";
        } else {
            // Insert the new owner into the database
            $insert_query = "INSERT INTO hotel_owners (hotel_id, owner_name, owner_email,  owner_phone, password) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($insert_query);
            $stmt->bind_param("issss", $hotel_id, $owner_name, $owner_email,  $owner_phone, $plain_password);

            if ($stmt->execute()) {
                // Get the newly created owner ID
                $owner_id = $stmt->insert_id;

                // Update the hotel record with the new owner_id
                $update_query = "UPDATE hotel SET owner_id = ? WHERE id = ?";
                $stmt = $conn->prepare($update_query);
                $stmt->bind_param("ii", $owner_id, $hotel_id);

                if ($stmt->execute()) {
                    echo "<script>alert('Owner account created successfully.'); window.location.href='create_owner.php';</script>";
                } else {
                    echo "<script>alert('Error updating hotel record: " . $stmt->error . "'); window.location.href='create_owner.php';</script>";
                }
            } else {
                echo "<script>alert('Error creating owner account: " . $stmt->error . "'); window.location.href='create_owner.php';</script>";
            }
        }
    }

    $stmt->close();
    $conn->close();
}
?>
