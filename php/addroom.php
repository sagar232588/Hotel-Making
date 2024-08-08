<?php
session_start();
include 'connection.php';

// Check if the admin is logged in and has the appropriate role (e.g., 'admin')
if (!isset($_SESSION['userid']) || $_SESSION['role'] !== 'admin') {
  header('Location: login.php');
  exit;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  // Retrieve the form data
  $roomType = $_POST['roomType'];
  $roomNo = $_POST['roomNo'];

  // Perform any necessary validation on the form data
  // Add your validation code here

  // Insert the room details into the database
  $query = "INSERT INTO rooms (room_type, room_no) VALUES ('$roomType', '$roomNo')";
  $result = mysqli_query($conn, $query);

  if ($result) {
    // Room details added successfully
    $_SESSION['success_message'] = "Room details added successfully.";
    header("Location: admin_profile.php");
    exit;
  } else {
    // Error in adding room details
    $_SESSION['error_message'] = "Failed to add room details. Please try again.";
  }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Add Room Details</title>
  <link rel="stylesheet" type="text/css" href="styles.css">
  <link href="../css/style.css" rel="stylesheet" type="text/css"  media="all" />
  <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            padding: 20px;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus {
            border-color: #4caf50;
        }

        button[type="submit"] {
            padding: 10px 20px;
            background-color: #4caf50;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #45a049;
        }

        /* Optional: Add some responsive styles */
        @media screen and (max-width: 768px) {
            form {
                max-width: 100%;
            }
        }
    </style>
</head>
<body>
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
							<li class="active"><a href="admin_profile.php">Booking Details</a></li>
							<!-- <li><a href="change_password.php">Change Password</a></li> -->
							<li><a href="addroom.php">Add Room</a></li>
							<li><a href="reservdetail.php"></a></li>
							<li ><a href="userdetail.php">User Details</a></li>
                     <li class="logout-button"><a href="logout.php">Logout</a></li>
							
							<div class="clear"> </div>
						</ul>
					</div>
				</div>
			</div>
  <div class="container">
    <h1 align="center">Add Room Details</h1>

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
      <label for="roomType">Room Type:</label>
            <select id="roomType" name="roomType" class="form-control" onchange="updateRoomOptions()" required>
                <option value="-1">- Not selected -</option>
                <option value="Standard">Standard</option>
                <option value="Deluxe">Deluxe</option>
                <option value="Suite">Suite</option>
                <option value="Executive">Executive</option>
                <!-- Add more options as needed -->
            </select>
      </div>
      <div class="form-group">
        <label for="roomNo">Room No:</label>
        <input type="text" id="roomNo" name="roomNo" required>
      </div>
      <div class="form-group">
        <button type="submit">Add Room</button>
      </div>
    </form>
  </div>
</body>
</html>
