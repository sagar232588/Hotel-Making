<html>
<head>
  <link rel="stylesheet" type="text/css" href="style.css">
  
</head>
<body>
<?php
// Include the database connection file
include 'connection.php';

// Retrieve the user ID from the URL parameter
$userId = $_GET['userid'];

// Retrieve the user account data from the database based on the ID
$query = "SELECT * FROM user_data WHERE userid = $userId";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 1) {
  $user = mysqli_fetch_assoc($result);
  echo '<div class="container">';
  // Display the user account edit form
  echo '<h1>Edit User Account</h1>';
  echo '<form action="update_user.php" method="POST">';
  echo 'First Name: <input type="text" name="fname" value="' . $user['fname'] . '"><br>';
  echo 'Last Name: <input type="text" name="lname" value="' . $user['lname'] . '"><br>';
  echo 'Email: <input type="email" name="email" value="' . $user['email'] . '"><br>';
 
  // Add more fields as needed
  echo '<input type="hidden" name="user_id" value="' . $user['userid'] . '">';
  echo '<center><input type="submit" value="Update"></center>';
  echo '</form>';
  echo '</div>';
} else {
  echo 'User account not found.';
}

// Close the database connection
mysqli_close($conn);
?>
</body>
</html>