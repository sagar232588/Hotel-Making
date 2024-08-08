<?php
session_start();
include 'connection.php';

// Check if the user is logged in
if (!isset($_SESSION['userid'])) {
   header('Location: signup.php');
   exit;
}

// Get the user ID from the session
$userid = $_SESSION['userid'];

// Check if the form is submitted
if (isset($_POST['change_password'])) {
   // Retrieve the form data
   $currentPassword = $_POST['current_password'];
   $newPassword = $_POST['new_password'];
   $confirmPassword = $_POST['confirm_password'];

   // Validate the form data (e.g., check if passwords match, meet criteria, etc.)
   // Add your validation code here

   // Retrieve the current password from the database
   $query = "SELECT password FROM user_data WHERE userid = '$userid'";
   $result = mysqli_query($conn, $query);
   $row = mysqli_fetch_assoc($result);
   $storedPassword = $row['password'];

   // Verify if the current password matches the stored password
   if (password_verify($currentPassword, $storedPassword)) {
      // Hash the new password
      $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

      // Update the password in the database
      $updateQuery = "UPDATE user_data SET password = '$hashedPassword' WHERE id = '$userid'";
      $updateResult = mysqli_query($conn, $updateQuery);

      if ($updateResult) {
         // Password update successful
         $_SESSION['success_message'] = "Password updated successfully.";
         header("Location: user_profile.php");
         exit;
      } else {
         // Password update failed
         $_SESSION['error_message'] = "Failed to update password. Please try again.";
      }
   } else {
      // Current password is incorrect
      $_SESSION['error_message'] = "Current password is incorrect.";
   }
}
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>Hotel Website | Change Password </title>
		<link href="../css/style.css" rel="stylesheet" type="text/css"  media="all" />
      <link href="../css/changepass.css" rel="stylesheet" type="text/css"  media="all" />
		<!-- <link href='http://fonts.googleapis.com/css?family=PT+Sans+Narrow' rel='stylesheet' type='text/css'> -->
	</head>
	<body>
		<!---start-Wrap--->
			<!---start-header--->
			<div class="header">
				<div class="wrap">
					<div class="header-top">
						<div class="logo">
							<a href="index.html"><img src="../images/logo2.png" title="logo" /></a>
						</div>
						<div class="contact-info">
							<p class="phone">Call us : <a href="#">9808147755,9840602765</a></p>
							<p class="gpa">Gps : <a href="https://www.google.com/maps/place/New+Hotel+Elite+(P)+Ltd/@27.7117484,85.3104502,17z/data=!3m1!4b1!4m9!3m8!1s0x39eb18fdefffffff:0xcf6b523c8d383f44!5m2!4m1!1i2!8m2!3d27.7117484!4d85.3130251!16s%2Fg%2F11b6dq98s8?entry=ttu">View map</a></p>
						</div>
						<div class="clear"> </div>
					</div>
				</div>
				<div class="header-top-nav">
					<div class="wrap">
						<ul>
							<li ><a href="user_profile.php">Account Details</a></li>
							<li class="active"><a href="password.php">Change Password</a></li>
							<li><a href="reservation.php">Book Room</a></li>
							<li><a href="reservdetail.php">Booking Details</a></li>
							<li ><a href="notification.php">Notifications</a></li>
                     <li class="logout-button"><a href="php/logout.php">Logout</a></li>
							
							<div class="clear"> </div>
						</ul>
					</div>
				</div>
			</div>
            <div class="container">
      <h1>Change Password</h1>

      <?php
      // Display success or error message, if any
      if (isset($_SESSION['success_message'])) {
         echo '<p class="success-message">' . $_SESSION['success_message'] . '</p>';
         unset($_SESSION['success_message']);
      }
      if (isset($_SESSION['error_message'])) {
         echo '<p class="error-message">' . $_SESSION['error_message'] . '</p>';
         unset($_SESSION['error_message']);
      }
      ?>

      <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
         <div class="form-group">
            <label for="current_password">Current Password</label>
            <input type="password" id="current_password" name="current_password" required>
         </div>
         <div class="form-group">
            <label for="new_password">New Password</label>
            <input type="password" id="new_password" name="new_password" required>
         </div>
         <div class="form-group">
            <label for="confirm_password">Confirm Password</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
         </div>
         <div class="form-group">
            <button type="submit" name="change_password">Change Password</button>
         </div>
      </form>
</body>
</html>


  