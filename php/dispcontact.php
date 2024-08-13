<!DOCTYPE html>
<html>
<head>
    <title>Recorded Data</title>
    <link href="../css/style.css" rel="stylesheet" type="text/css"  media="all" />
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            padding: 20px;
        }

        h3 {
            color: #4caf50;
        }

        ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        li {
            margin-bottom: 10px;
        }

        li:last-child {
            margin-bottom: 20px;
        }

        li strong {
            font-weight: bold;
        }

        /* Optional: Add some responsive styles */
        @media screen and (max-width: 768px) {
            ul {
                font-size: 16px;
            }
        }
    </style>
    <link href="../css/admin.css" rel="stylesheet" type="text/css"  media="all" />
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
                            <li><a href="all-hotel.php">Our Hotels</a></li>
							<!-- <li><a href="change_password.php">Change Password</a></li> -->
							<li class="active"><a href="dispcontact.php">Messages</a></li>
							<li ><a href="userdetail.php">User Details</a></li>
                     <li class="logout-button"><a href="logout.php">Logout</a></li>
							
							<div class="clear"> </div>
						</ul>
					</div>
				</div>
			</div>
    <?php
    // Include the database connection file
    include 'connection.php';

    // Retrieve data from the database table
    $sql = "SELECT * FROM contact";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<h3>Message Received:</h3>";
        echo "<ul>";
        while ($row = $result->fetch_assoc()) {
            echo "<li>Full Name: " . $row['full_name'] . "</li>";
            echo "<li>Email: " . $row['email'] . "</li>";
            echo "<li>Mobile Number: " . $row['mobile_number'] . "</li>";
            echo "<li>Subject: " . $row['subject'] . "</li>";
            echo "<br>";
        }
        echo "</ul>";
    } else {
        echo "No data found.";
    }

    // Close the database connection
    $conn->close();
    ?>
</body>
</html>
