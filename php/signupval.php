<?php
session_start();
include "connection.php";

if (isset($_POST['submit'])) {
    $formData = $_POST;
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $repass = $_POST['repassword'];

    $flag = 0;
    $errorMessage = "";

    // Check if password and confirm password match
    if ($pass != $repass) {
        $flag = 1;
        $errorMessage = "Password and confirm password must be the same.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $flag = 1;
        $errorMessage = "Invalid email format."; 
    } elseif ($flag == 0) {
        // Check the number of existing admin users
        $adminQuery = "SELECT COUNT(*) AS adminCount FROM user_data WHERE role='admin'";
        $adminResult = mysqli_query($conn, $adminQuery);
        $adminData = mysqli_fetch_assoc($adminResult);
        $adminCount = $adminData['adminCount'];

        if ($adminCount >= 2 && $_POST['role'] == 'admin') {
            $errorMessage = "Error: Maximum number of admin users reached.";
        } else {
            // Generate a unique user_id
            $userid = uniqid();

            // Check if the email already exists in the database
            $query = "SELECT * FROM user_data WHERE email='$email'";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) {
                $errorMessage = "Error: Email already exists";
            } else {
                $role = ($_POST['role'] == 'admin' && $adminCount < 2) ? 'admin' : 'user'; // Set role based on admin count
                $hashedPassword = crypt($pass, PASSWORD_DEFAULT);
                $query = "INSERT INTO user_data (fname, lname, email, password, role) VALUES ('$fname', '$lname', '$email', '$pass', '$role')";

                $exequery = mysqli_query($conn, $query);

                if ($exequery) {
                    $_SESSION['success_message'] = "Registration successful!";
                    header("Location: signup.php");
                    exit;
                } else {
                    $errorMessage = "Error: Unable to create user";
                }
            }
        }
    }

    // Store the error message in a session variable
    $_SESSION['error_message'] = $errorMessage;

    // Redirect back to the signup page
    header("Location: signup.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Signup Page</title>
  <link href="../css/style.css" rel="stylesheet" type="text/css" media="all" />
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
        <div class="clear"></div>
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
          <div class="clear"></div>
        </ul>
      </div>
    </div>
  </div>
  <div class="form">
    <ul class="tab-group">
      <li class="tab active"><a href="#signup" style="border-radius: 15px!important;margin-right:8px;">Sign Up</a></li>
      <li class="tab"><a href="#login" style="border-radius: 15px!important;margin-left:8px;">Log In</a></li>
    </ul>
    <div class="tab-content">
      <div id="signup">
        <h1>Register</h1>
        <?php
        if (isset($_SESSION['error_message'])) {
          echo "<p style='color: red;'>".$_SESSION['error_message']."</p>";
          unset($_SESSION['error_message']);
        }
        if (isset($_SESSION['success_message'])) {
          echo "<p style='color: green;'>".$_SESSION['success_message']."</p>";
          unset($_SESSION['success_message']);
        }
        ?>
        <form action="admin_regval.php" method="post">
          <div class="top-row">
            <div class="field-wrap">
              <input type="text" name="fname" required placeholder="First Name" />
            </div>
            <div class="field-wrap">
              <input type="text" name="lname" required placeholder="Last Name" />
            </div>
          </div>
          <div class="field-wrap">
            <input type="email" name="email" required placeholder="Email Address" />
          </div>
          <div class="field-wrap">
            <input type="password" name="password" required placeholder="Password" />
          </div>
          <div class="field-wrap">
            <input type="password" name="repassword" required placeholder="Confirm Password" />
          </div>
          <div class="field-wrap">
            <label for="role" style="color: white;">Role:</label>
            <select name="role" id="role" required>
              <option value="admin">Admin</option>
              <option value="user" selected>User</option>
            </select>
          </div>
          <input type="hidden" name="check" value="1">
          <button type="submit" name="submit" class="button button-block">Sign Up</button>
        </form>
      </div>
      <div id="login">
        <h1>Welcome Back!</h1>
        <form action="php/loginvalidation.php" method="post">
          <div class="field-wrap">
            <input type="email" name="logemail" placeholder="Email" />
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
  <script src="js/login.js"></script>
</body>
</html>

