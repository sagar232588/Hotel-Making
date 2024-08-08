<?php
// Include the database connection file
include 'connection.php';

// Retrieve user account data from the database
$query = "SELECT * FROM user_data";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
  // Loop through each user account
  while ($user = mysqli_fetch_assoc($result)) {
    // Fetch additional details like booking history for each user
    // ... (You can modify the query and fetch additional details as needed)

    // Display user account details in a table row
    echo '<tr>';
    echo '<td>' . $user['fname'] . '</td>';
    echo '<td>' . $user['lname'] . '</td>';
    echo '<td>' . $user['email'] . '</td>';
    echo '<td>' . $user['role'] . '</td>';
    echo '<td><a href="edit_user.php?userid=' . $user['userid'] . '" class="user-action-link">Edit</a> | <a href="delete_user.php?userid=' . $user['userid'] . '" class="user-action-link">Delete</a></td>';
    echo '</tr>';
  }
} else {
  echo '<tr><td colspan="4">No user accounts found.</td></tr>';
}
?>