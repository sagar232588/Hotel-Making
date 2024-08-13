<?php
require 'connection.php';

// Check if ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "Owner ID is missing.";
    exit();
}

$owner_id = $_GET['id'];

// Prepare and execute delete query
$delete_query = "DELETE FROM hotel_owners WHERE id = ?";
$stmt = $conn->prepare($delete_query);
$stmt->bind_param("i", $owner_id);

if ($stmt->execute()) {
    echo "Owner deleted successfully.";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();

// Redirect back to the manage page (optional)
header("Location: create_owner.php");
exit();
?>
