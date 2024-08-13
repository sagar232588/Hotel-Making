<?php
require 'connection.php';

if (isset($_POST['submit'])) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["file"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is an actual image or fake image
    $check = getimagesize($_FILES["file"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["file"]["size"] > 5000000) { // 5MB max
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        // Ensure the uploads directory exists
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true); // Create the directory if it doesn't exist
        }

        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            // Insert hotel data into the database
            $name = mysqli_real_escape_string($conn, $_POST['name']);
            $description = mysqli_real_escape_string($conn, $_POST['description']);
            $facility = mysqli_real_escape_string($conn, $_POST['facility']);
            $location = mysqli_real_escape_string($conn, $_POST['location']);
            $latitude = mysqli_real_escape_string($conn, $_POST['latitude']);
            $longitude = mysqli_real_escape_string($conn, $_POST['longitude']);
            $img = basename($_FILES["file"]["name"]);

            $query = "INSERT INTO hotel (name, description, facility, location, img, latitude, longitude)
                      VALUES ('$name', '$description', '$facility', '$location', '$img', '$latitude', '$longitude')";

            if (mysqli_query($conn, $query)) {
                echo "The hotel has been added successfully.";
            } else {
                echo "Error: " . $query . "<br>" . mysqli_error($conn);
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    mysqli_close($conn);
}
?>
