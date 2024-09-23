<?php
session_start();
include "connection.php";

if (isset($_POST['submit'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $repass = $_POST['repassword'];

    $errorMessage = "";

    // Validate first name and last name
    if (empty($fname) || empty($lname)) {
        $errorMessage = "First name and last name are required.";
    } elseif (!ctype_alpha($fname[0]) || !ctype_alpha($lname[0])) {
        $errorMessage = "First name and last name must start with an alphabetic character.";
    } elseif (strlen($pass) < 8) {
        // Check if password length is less than 8 characters
        $errorMessage = "Password must be at least 8 characters long.";
    } elseif ($pass != $repass) {
        $errorMessage = "Password and confirm password must be the same.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMessage = "Invalid email format."; 
    } else {
        // Check the number of existing admin users
        $adminQuery = "SELECT COUNT(*) AS adminCount FROM user_data WHERE role='admin'";
        $adminResult = mysqli_query($conn, $adminQuery);
        $adminData = mysqli_fetch_assoc($adminResult);
        $adminCount = $adminData['adminCount'];

        if ($adminCount >= 2 && $_POST['role'] == 'admin') {
            $errorMessage = "Error: Maximum number of admin users reached.";
        } else {
            // Check if the email already exists in the database
            $query = "SELECT * FROM user_data WHERE email='$email'";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) {
                $errorMessage = "Error: Email already exists";
            } else {
                $role = ($_POST['role'] == 'admin' && $adminCount < 2) ? 'admin' : 'user'; // Set role based on admin count
                $query = "INSERT INTO user_data (fname, lname, email, password, role) VALUES ('$fname', '$lname', '$email', '$pass', '$role')";

                if (mysqli_query($conn, $query)) {
                    $_SESSION['success_message'] = "Registration successful!";
                    header("Location: signup.php");
                    exit;
                } else {
                    $errorMessage = "Error: Unable to create user";
                }
            }
        }
    }

    // Store the error message in a session variable and redirect back
    $_SESSION['error_message'] = $errorMessage;
    header("Location: signup.php");
    exit;
}
?>
