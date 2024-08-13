<?php
require 'connection.php';

if (isset($_GET['id'])) {
    $hotel_id = intval($_GET['id']);
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Get the updated data from the form
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $description = mysqli_real_escape_string($conn, $_POST['description']);
        $facility = mysqli_real_escape_string($conn, $_POST['facility']);
        $location = mysqli_real_escape_string($conn, $_POST['location']);

        // Handle the image upload if a new file is uploaded
        if (!empty($_FILES['file']['name'])) {
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["file"]["name"]);
            move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);

            // Update query with image
            $query = "UPDATE hotel SET name = '$name', description = '$description', facility = '$facility', location = '$location', img = '" . basename($_FILES["file"]["name"]) . "' WHERE id = $hotel_id";
        } else {
            // Update query without image
            $query = "UPDATE hotel SET name = '$name', description = '$description', facility = '$facility', location = '$location' WHERE id = $hotel_id";
        }

        if (mysqli_query($conn, $query)) {
            echo "Hotel updated successfully.";
        } else {
            echo "Error updating hotel: " . mysqli_error($conn);
        }
    }

    // Fetch current hotel details
    $query = "SELECT * FROM hotel WHERE id = $hotel_id";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $hotel = mysqli_fetch_assoc($result);
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Edit Hotel</title>
            <link href="../css/style.css" rel="stylesheet" type="text/css" media="all" />
        </head>
        <body>
            <div class="hotel-edit">
                <h2>Edit Hotel</h2>
                <form method="post" enctype="multipart/form-data">
                    <input type="text" name="name" value="<?php echo htmlspecialchars($hotel['name']); ?>" required/><br/>
                    <input type="text" name="description" value="<?php echo htmlspecialchars($hotel['description']); ?>" required/><br/>
                    <input type="text" name="facility" value="<?php echo htmlspecialchars($hotel['facility']); ?>" required/><br/>
                    <input type="text" name="location" value="<?php echo htmlspecialchars($hotel['location']); ?>" required/><br/>
                    <label>Update Image:</label>
                    <input type="file" name="file"><br/>
                    <input type="submit" value="Update Hotel">
                </form>
                <a href="all-hotel.php">Back to Hotel List</a>
            </div>
        </body>
        </html>
        <?php
    } else {
        echo "Hotel not found.";
    }
} else {
    echo "Invalid request.";
}

mysqli_close($conn);
?>
