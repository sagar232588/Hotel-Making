<!DOCTYPE HTML>
<html>
	<head>
		<title>Hotel Website | Reservation Details </title>
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
							<li ><a href="user_profile.php">Account Details</a></li>
							<li><a href="../room_details.html">Room Details</a></li>
							<!-- <li><a href="password.php">Change Password</a></li> -->
							<li><a href="reservation.php">Book Room</a></li>
							<li class="active"><a href="reservdetail.php">Booking Details</a></li>
							
                     <li class="logout-button"><a href="logout.php">Logout</a></li>
							
							<div class="clear"> </div>
						</ul>
					</div>
				</div>
			</div>
			<div>
<?php
include 'connection.php';
session_start();
if(isset($_SESSION['userid'])){
// Get the user ID from the session
$userid = $_SESSION['userid'];

// Fetch the booking details for the logged-in user
$query = "SELECT * FROM bookings WHERE user_id = '$userid'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
   echo "<h2>Booking Details</h2>";
   echo "<table>";
   echo "<tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Room Type</th>
            <th>Room No</th>
            <th>Check-in Date</th>
            <th>Check-out Date</th>
            <th>Country</th>
            <th>Status</th>
         </tr>";
   
   while ($row = mysqli_fetch_assoc($result)) {
      echo "<tr>";
      echo "<td>" . $row['first_name'] . "</td>";
      echo "<td>" . $row['last_name'] . "</td>";
      echo "<td>" . $row['email'] . "</td>";
      echo "<td>" . $row['phone'] . "</td>";
      echo "<td>" . $row['room_type'] . "</td>";
      echo "<td>" . $row['room_no'] . "</td>";
      echo "<td>" . $row['check_in_date'] . "</td>";
      echo "<td>" . $row['check_out_date'] . "</td>";
      echo "<td>" . $row['country'] . "</td>";
      echo "<td>" . $row['STATUS'] . "</td>";
      echo "</tr>";
   }
   
   echo "</table>";

} else {
   echo "No booking details found.";
}}
?>
</div>
	</body>
</html>
