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
  <link href='http://fonts.googleapis.com/css?family=PT+Sans+Narrow' rel='stylesheet' type='text/css'> 
		
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
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
							<!-- <p class="gpa">Gps : <a href="https://www.google.com/maps/place/New+Hotel+Elite+(P)+Ltd/@27.7117484,85.3104502,17z/data=!3m1!4b1!4m9!3m8!1s0x39eb18fdefffffff:0xcf6b523c8d383f44!5m2!4m1!1i2!8m2!3d27.7117484!4d85.3130251!16s%2Fg%2F11b6dq98s8?entry=ttu">View map</a></p> -->
						</div>
						<div class="clear"> </div>
					</div>
				</div>
				<div class="header-top-nav">
					<div class="wrap">
						<ul>
							<!-- <li class="active"><a href="admin_profile.php">Booking Details</a></li> -->
							<!-- <li><a href="change_password.php">Change Password</a></li> -->
              <li><a href="all-hotel.php">Our Hotels</a></li>
              <li><a href="create_owner.php">Owner Accounts</a></li>
              <li><a href="reservedetailadmins.php">Booking Details</a></li>
							<li><a href="dispcontact.php">Messages</a></li>
							<li ><a href="userdetail.php">User Details</a></li>
                     <li class="logout-button"><a href="logout.php">Logout</a></li>
							
							<div class="clear"> </div>
						</ul>
					</div>
				</div>
			</div>
  <h1>Welcome, Admin!</h1>
  
  <h2>Bookings</h2>
  <table>
    <tr>
      <th>Id</th>
      <th>First Name</th>
      <th>Last Name</th>
      <th>Email</th>
      <th>Phone</th>
      
      <th>Room Type</th>
      <th>Room No</th>
      <th>Check-In Date</th>
      <th>Check-Out Date</th>
      
      <th>Country</th>
      
      <th>Status</th>
      <th>Action</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
      <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['first_name']; ?></td>
        <td><?php echo $row['last_name']; ?></td>
        <td><?php echo $row['email']; ?></td>
        <td><?php echo $row['phone']; ?></td>
     
        <td><?php echo $row['room_type']; ?></td>
        <td><?php echo $row['room_no']; ?></td>
        <td><?php echo $row['check_in_date']; ?></td>
        <td><?php echo $row['check_out_date']; ?></td>
      
        <td><?php echo $row['country']; ?></td>
       
        <td><?php echo $row['STATUS']; ?></td>
        <td>
          <?php if ($row['STATUS'] === 'Pending') { ?>
            <form method="post">
              <input type="hidden" name="booking_id" value="<?php echo $row['id']; ?>">
              <button type="submit" name="action" value="cancel">Cancel</button>
              <button type="submit" name="action" value="confirm">Confirm</button>
            </form>
          <?php } ?>
        </td>
      </tr>
    <?php } ?>
  </table>
  
  

</body>
</html>