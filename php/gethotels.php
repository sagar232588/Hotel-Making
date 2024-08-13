<?php
require 'connection.php';

if (isset($_GET['lat']) && isset($_GET['lon'])) {
    $userLat = mysqli_real_escape_string($conn, $_GET['lat']);
    $userLon = mysqli_real_escape_string($conn, $_GET['lon']);

    // Define the maximum distance in kilometers (e.g., 10km)
    $maxDistance = 10;

    // Haversine formula to calculate distance between two points on the earth
    $query = "
    SELECT id, name, latitude, longitude, 
        (6371 * acos(cos(radians($userLat)) * cos(radians(latitude)) * cos(radians(longitude) - radians($userLon)) + sin(radians($userLat)) * sin(radians(latitude)))) AS distance 
    FROM hotel 
    HAVING distance <= $maxDistance 
    ORDER BY distance 
    LIMIT 0, 20"; // Limit to the nearest 20 hotels

    $result = mysqli_query($conn, $query);

    if (!$result) {
        // Query error
        echo json_encode(['error' => 'Database query failed']);
        exit;
    }

    $hotels = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $hotels[] = [
            'id' => $row['id'],
            'name' => $row['name'],
            'location_lat' => $row['latitude'],
            'location_lon' => $row['longitude'],
            'distance' => $row['distance']
        ];
    }

    // Return the hotels as a JSON array
    echo json_encode($hotels);
} else {
    echo json_encode([]);
}

mysqli_close($conn);
?>
