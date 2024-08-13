<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
  <title>Hotel Website | Home</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
		<link href="../css/style.css" rel="stylesheet" type="text/css"  media="all" />
		<!-- <link href='http://fonts.googleapis.com/css?family=PT+Sans+Narrow' rel='stylesheet' type='text/css'> -->
		<link rel="stylesheet" href="../css/responsiveslides.css">

  
  
  <script>
  
  $( function() {
    $( ".datepicker" ).datepicker({
      changeMonth: true,
      changeYear: true
    });
  } );
  </script>








</head>
<body>

<header>
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
							<li><a href="../hotel.php">Our Hotels</a></li>
							<li class="active"><a href="about.html">About</a></li>
							<li><a href="services.html">Services</a></li>
							<li><a href="gallery.html">Gallery</a></li>
							<li><a href="contact.html">Contact</a></li>
							<li class="login-button"><a href="php/signup.php">Login</a></li>
							<div class="clear"> </div>
						</ul>
					</div>
				</div>
			</div>
</header>


<div class="search-form-div">
<h2 style="font-weight: bold;">SEARCH HOTELS </h2>
</div>
<div class="search-form-div">
	
		<form class="serach-form" action='search.php' method='post'>
		  <input type="text" name="city" placeholder="City name"> 
		  <input type="text" class='datepicker' name="checkin"  placeholder="Check-in">
		  <input type="text" class='datepicker' name="checkout" placeholder="Check-out">
		    
		  <input type="text" name="budgetmax" placeholder="Budget max">
		  
		  <input type="submit" value="Submit" style="background:green;height:20px;background: #120c4e;height: 30px;color: white;"> 
		</form> 
</div>

