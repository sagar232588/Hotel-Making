<?php

// include("connection.php");



// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     $userName = $_POST['userName'];
//     $userEmail = $_POST['userEmail'];
//     $userPhone = $_POST['userPhone'];
//     $userMsg = $_POST['userMsg'];

//     // Prepare and execute the SQL query to insert the data into the database
//     $sql = "INSERT INTO contact (full_name, email, mobile_number, subject) 
//             VALUES ('$userName', '$userEmail', '$userPhone', '$userMsg')";

//     if ($conn->query($sql) === TRUE) {
//         echo "Form data submitted successfully!";
//     } else {
//         echo "Error: " . $sql . "<br>" . $conn->error;
//     }
// }


// $conn->close();
?>
<?php
include("connection.php");

// Initialize variables for the success message
$successMessage = '';

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userName = $_POST['userName'];
    $userEmail = $_POST['userEmail'];
    $userPhone = $_POST['userPhone'];
    $userMsg = $_POST['userMsg'];

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO contact (full_name, email, mobile_number, subject) 
                            VALUES (?, ?, ?, ?)");

    // Bind parameters and execute the statement
    $stmt->bind_param("ssss", $userName, $userEmail, $userPhone, $userMsg);

    if ($stmt->execute()) {
        $successMessage = "Form data submitted successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Hotel Website | Contact </title>
		<link href="../css/style.css" rel="stylesheet" type="text/css"  media="all" />
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
							<li ><a href="../index.html">Home</a></li>
							<li><a href="../about.html">About</a></li>
							<li><a href="../services.html">Services</a></li>
							<li><a href="../gallery.html">Gallery</a></li>
							<li class="active"><a href="../contact.html">Contact</a></li>
							<li class="../login-button"><a href="signup.php">Login</a></li>
							<div class="clear"> </div>
						</ul>
					</div>
				</div>
			</div>
			<!---End-header--->
			<div class="clear"> </div>
			<!---start-content----->
			<div class="content">
				<div class="wrap">
					<!-------start-contatct------>
					<div class="contact">
				<div class="section group">				
				<div class="col span_1_of_3">
					<div class="contact_info">
			    	 	
      				</div>
      			<div class="company_address">
				     	<h3>Company Information :</h3>
						    	<p>Thamel</p>
						   		
						   		<p>Kathmandu, Nepal</p>
				   		<p>Phone:(01) 4225752</p>
				   		<p>Fax: (000) 00000000</p>
				 	 	<p>Email: <span>info@hotelelite.com</span></p>
				   		<p>Follow us on: <span>Facebook</span>, <span>Twitter</span></p>
						
				   </div>
				</div>				
				<div class="col span_2_of_3">
				  <div class="contact-form">
                  <?php echo $successMessage; ?>

                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
				  	<h3>Contact Us</h3>
					    <form method="post" action="php/contact.php">
					    	<div>
						    	<span><label>FULL NAME</label></span>
						    	<span><input name="userName" type="text" class="textbox"></span>
						    </div>
						    <div>
						    	<span><label>E-MAIL ID</label></span>
						    	<span><input name="userEmail" type="text" class="textbox"></span>
						    </div>
						    <div>
						     	<span><label>MOBILE NUMBER</label></span>
						    	<span><input name="userPhone" type="text" class="textbox"></span>
						    </div>
						    <div>
						    	<span><label>SUBJECT</label></span>
						    	<span><textarea name="userMsg"> </textarea></span>
						    </div>
						   <div>
						   		<span><input type="submit" value="Submit"></span>
						  </div>
					    </form>

				    </div>
  				</div>				
			  </div>
			</div>
					<!-------start-contatct------>
				</div>
				<div class="clear"> </div>
				<div class="boxs"></div>
				<div class="wrap"></div>
				<div class="box"></div>
				
				</div>
				<div class="box center-box">
					<ul>
						<li><a href="feedbank.html">Leave a Feedback</a></li>
						<li><a href="">Packages</a></li>
						
					</ul>
				</div>
		
				<div class="clear"> </div>
			</div>
			<!---start-box---->
		</div>
		<!---start-copy-Right----->
		<div class="copy-tight">
			<p>&copy Elite HOTEL,Nepal 2017
			</p>
		</div>
		<!---End-copy-Right----->
			</div>
			<!---End-content----->
		</div>
		<!---End-Wrap--->
	</body>
</html>


