<?php
// Include the database connection file
include 'connection.php';

// Check if the delete confirmation is received
if (isset($_GET['confirm']) && $_GET['confirm'] === 'yes') {
    // Retrieve the user ID from the URL parameter
    $userId = $_GET['userid'];

    // Delete user's bookings first
    $deleteBookingsQuery = "DELETE FROM bookings WHERE user_id = $userId";
    if (mysqli_query($conn, $deleteBookingsQuery)) {
        // Delete the user account from the database
        $deleteUserQuery = "DELETE FROM user_data WHERE userid = $userId";
        if (mysqli_query($conn, $deleteUserQuery)) {
            // User account and associated bookings deleted successfully
            header("Location: userdetail.php");
            exit();
        } else {
            echo 'Error deleting user account: ' . mysqli_error($conn);
        }
    } else {
        echo 'Error deleting user bookings: ' . mysqli_error($conn);
    }
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete User</title>
    <!-- Add some styles to center the confirmation message -->
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .confirmation-box {
            text-align: center;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .confirm-button {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="confirmation-box">
        <h3>Are you sure you want to delete this user account and associated bookings?</h3>
        <button class="confirm-button" onclick="confirmDelete()">Yes</button>
        <button class="confirm-button" onclick="cancelDelete()">No</button>
    </div>

    <!-- JavaScript to handle confirmation -->
    <script>
        function confirmDelete() {
            // Redirect to this page with a confirm=yes parameter
            window.location.href = '<?php echo $_SERVER['PHP_SELF'] . '?userid=' . $_GET['userid'] . '&confirm=yes'; ?>';
        }

        function cancelDelete() {
            // Redirect back to the userdetail.php without performing any deletion
            window.location.href = 'userdetail.php';
        }
    </script>
</body>
</html>
