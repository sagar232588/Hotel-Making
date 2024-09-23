<?php
include 'connection.php';

// Fetch all hotel locations from the database
$query = "SELECT name, latitude, longitude FROM hotel";
$result = mysqli_query($conn, $query);

$hotels = [];

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $hotels[] = [
            'name' => $row['name'],
            'location_lat' => $row['latitude'],
            'location_lon' => $row['longitude']
        ];
    }
}

// Return data as JSON
echo json_encode($hotels);
?>
