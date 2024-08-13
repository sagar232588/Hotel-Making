<?php
session_start();

// Check if the user is logged in as an admin
if (empty($_SESSION['userid']) || $_SESSION['role'] !== 'admin') {
  // Redirect to the login page or show an error message
  header("Location: signup.php");
  exit;
}

// Include the database connection file
include "connection.php";

// Retrieve all bookings from the database
$query = "SELECT * FROM bookings";
$result = mysqli_query($conn, $query);

// Handle cancel and confirm actions
if (isset($_POST['action']) && isset($_POST['booking_id'])) {
  $action = $_POST['action'];
  $booking_id = $_POST['booking_id'];

  if ($action === 'cancel') {
    // Update the booking status to 'Cancelled'
    $updateQuery = "UPDATE bookings SET status = 'Cancelled' WHERE id = $booking_id";
    mysqli_query($conn, $updateQuery);
  } elseif ($action === 'confirm') {
    // Update the booking status to 'Confirmed'
    $updateQuery = "UPDATE bookings SET status = 'Confirmed' WHERE id = $booking_id";
    mysqli_query($conn, $updateQuery);
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin Profile</title>
  <!-- Add your CSS styling here -->
  <link href="../css/admin.css" rel="stylesheet" type="text/css"  media="all" />
  <link href="../css/style.css" rel="stylesheet" type="text/css"  media="all" />
</head>
<body>
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
							<li ><a href="admin_profile.php">Booking Details</a></li>
							<li class="active"><a href="add-new-hotel.php">Add Hotel</a></li>
							<!-- <li><a href="change_password.php">Change Password</a></li> -->
							<li><a href="dispcontact.php">Messages</a></li>
							<li><a href="reservdetail.php"></a></li>
							<li ><a href="userdetail.php">User Details</a></li>
                     <li class="logout-button"><a href="logout.php">Logout</a></li>
							
							<div class="clear"> </div>
						</ul>
					</div>
				</div>
			</div>
</body>
</html>



<div style="width:80%;background:whitesmoke;height:1000px;padding:0px 200px;">
    <!-- Form to add new hotel -->
    <form class="hotel-form" method="post" action='addnewhotel.php' enctype="multipart/form-data">
        <h2>Add New Hotel</h2>
        <input type="text" name="name" placeholder="Hotel Name" /><br/>
        <!-- <input type="text" name="price" placeholder="Price" /><br/> -->
        <input type="text" name="description" placeholder="Hotel Description" /><br/>
        <input type="text" name="facility" placeholder="Facilities" /><br/>
        <input type="text" name="location" placeholder="Location" /><br/>
        <input type="file" name="file" id="fileToUpload"><br/> 
        <input type="submit" value="Add Hotel" name="submit"><br/>
    </form>
    <!-- End of add new hotel form -->
</div>

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f2f2f2;
        margin: 0;
        padding: 0;
    }

    .hotel-form {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        max-width: 400px;
        margin: 20px auto;
    }

    .hotel-form h2 {
        text-align: center;
        color: #333;
        margin-bottom: 20px;
    }

    .hotel-form input[type="text"],
    .hotel-form input[type="file"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    .hotel-form input[type="submit"] {
        width: 100%;
        padding: 10px;
        background-color: #4caf50;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
    }

    .hotel-form input[type="submit"]:hover {
        background-color: #45a049;
    }
</style>

