<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['userid'])) {
   header('Location: signup.php');
   exit;
}

// Rest of the code for the user profile page
include 'connection.php';
$userid = $_SESSION['userid'];

// Fetch user data from the database
$query = "SELECT * FROM user_data WHERE userid = '$userid'";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) == 0) {
   echo "Failed to fetch user data";
   exit;
}

$fetch = mysqli_fetch_assoc($result);
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Hotel Website | User Profile </title>
		<link href="../css/style.css" rel="stylesheet" type="text/css"  media="all" />
      <link href="../css/userprofile.css" rel="stylesheet" type="text/css"  media="all" />
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
							<li class="active"><a href="user_profile.php">Account Details</a></li>
							<li><a href="../room_details.html">Room Details</a></li>
							<li><a href="reservation.php">Book Room</a></li>
							<li><a href="reservdetail.php">Booking Details</a></li>
                     <li class="logout-button"><a href="logout.php">Logout</a></li>
							
							<div class="clear"> </div>
						</ul>
					</div>
				</div>
			</div>
         <div class="settings">
            <h3 >Account Details</h3>
            <form>
            <div class="form-group">
      <label for="firstName">First Name</label>
      <input type="text" id="firstName" name="firstName" value="<?php echo $fetch['fname']; ?>" disabled>
   </div>
   <div class="form-group">
      <label for="lastName">Last Name</label>
      <input type="text" id="lastName" name="lastName" value="<?php echo $fetch['lname']; ?>" disabled>
   </div>
   <div class="form-group">
      <label for="email">Email</label>
      <input type="email" id="email" name="email" value="<?php echo $fetch['email']; ?>" disabled>
   </div>
   <div class="form-group">
      <!-- <button type="button" onclick="location.href='change_password.php'">Change Password</button> -->
   </div>
              
         
            </form>
         </div>
      </div>
   </div>
</body>
</html>
