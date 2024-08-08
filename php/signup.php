

<!DOCTYPE html>
<html>
<head>
	<title>Signup Page</title>
	<!-- <link href='http://fonts.googleapis.com/css?family=PT+Sans+Narrow' rel='stylesheet' type='text/css'> -->
	<link href="../css/style.css"  rel="stylesheet" type="text/css"  media="all" />
	<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
    
    crossorigin="anonymous" referrerpolicy="no-referrer" /> -->
  <link rel="stylesheet" href="../css/login.css">
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
					<li><a href="../index.html">Home</a></li>
					<li><a href="../about.html">About</a></li>
					<li><a href="../services.html">Services</a></li>
					<li><a href="../gallery.html">Gallery</a></li>
					<li><a href="../contact.html">Contact</a></li>
          <li class="active"><a href="signup.php">Login</a></li>

					<div class="clear"> </div>
				</ul>
			</div>
		</div>
	</div>
  <div class="form">
    <ul class="tab-group">
      <li class="tab active"><a href="#signup" style="border-radius: 15px!important;margin-right:8x;">Sign Up</a></li>
      <li class="tab"><a href="#login" style="border-radius: 15px!important;margin-left:8px;">Log In</a></li>
    </ul>
    <div class="tab-content">
      <div id="signup">
        <h1>Register</h1>
        <form action="signupval.php" method="post">
          <div class="top-row">
            
            <div class="field-wrap">
              <input type="text" name="fname" required placeholder="First Name" />
              <div id="errorContainer"></div>

            </div>
            <div class="field-wrap">
              <input type="text" name="lname" required placeholder="Last Name" />
              <div id="errorContainer"></div>  
            </div>
          </div>
          <div class="field-wrap">
            <input type="email" name="email" required placeholder="Email Address"/>
            <div id="errorContainer"></div>
          </div>
          <div class="field-wrap">
            <input type="password" name="password" required placeholder="Password" />
          
            <div id="errorContainer"></div></div>
          <div class="field-wrap">
            <input type="password" name="repassword" required placeholder="Confirm Password" />
          
            <div id="errorContainer"></div>
          </div>
          <div class="field-wrap">
            <label for="role" style="color: white;">Role:</label>
            <select name="role" id="role" required>
              <option value="admin">Admin</option>
              <option value="user" selected>User</option>
            </select>
          </div>
          <input type="hidden" name ='check' value="1">
          
             
          <button type="submit" name="submit" class="button button-block" >Sign Up</button>
        </form>
      </div>
      <div id="login">
        <h1>Welcome Back!</h1>
        <form action="loginvalidation.php" method="post">
          <div class="field-wrap">
            <input type="email"  name="logemail" placeholder="Email" />
          </div>
          <div class="field-wrap">
            <input type="password" name="logpass" placeholder="Password" />
          </div>
          <p class="forgot"><a href="">Forgot Password?</a></p>
          <button class="button button-block" name="login">Login</button>
        </form>
      </div>
    </div>
  </div> 
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="../js/login.js"></script>
</body>
</html>
