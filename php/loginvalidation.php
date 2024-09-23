<?php


// include "connection.php";

// // Check if email and password are provided
// if (empty($_POST['logemail']) || empty($_POST['logpass'])) {
//   echo "Please enter both email and password";
// } else {
//   $email = mysqli_real_escape_string($conn, $_POST['logemail']);
//   $password = mysqli_real_escape_string($conn, $_POST['logpass']);

//   // Query to fetch user details
//   $query = "SELECT * FROM user_data WHERE email='$email' AND password='$password'";
//   $result = mysqli_query($conn, $query);

//   // Check for query execution error
//   if (!$result) {
//     die("Query failed: " . mysqli_error($conn));
//   }

//   // Check if user exists
//   if (mysqli_num_rows($result) > 0) {
//     $row = mysqli_fetch_assoc($result);
//     $userid = $row['userid'];
//     $role = $row['role'];

//     // Start the session and store user_id and role
//     session_start();
//     $_SESSION['userid'] = $userid;
//     $_SESSION['role'] = $role;

//     // Redirect based on the role
//     if ($role == 'admin') {
//       header("Location: admin_profile.php");
//     } else {
//       header("Location: user_profile.php");
//     }
//     exit;
//   } else {
//     echo "Invalid email or password";
//   }
// }

// Close the database connection
// mysqli_close($conn);







include "connection.php";

// Check if email and password are provided
if (empty($_POST['logemail']) || empty($_POST['logpass'])) {
    echo "Please enter both email and password";
} else {
    $email = mysqli_real_escape_string($conn, $_POST['logemail']);
    $password = mysqli_real_escape_string($conn, $_POST['logpass']);

    // Check in the user_data table first
    $query = "SELECT userid, role, password FROM user_data WHERE email = '$email' AND password = '$password'";
    $result = mysqli_query($conn, $query);

    // Debugging
    if (!$result) {
        die("Query Error: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($result) > 0) {
        // Fetch the user data
        $row = mysqli_fetch_assoc($result);

        // Start the session and store user_id and role
        session_start();
        $_SESSION['userid'] = $row['userid'];
        $_SESSION['role'] = $row['role'];

        // Redirect based on the role
        if ($row['role'] == 'admin') {
            header("Location: all-hotel.php");
        } else {
            header("Location: user_profile.php");
        }
        exit;
    } else {
        // Check if user_data table is being queried correctly
        echo "User not found in user_data table. Checking hotel_owners table.";

        // If not found in user_data, check in hotel_owners table
        $query = "SELECT id AS owner_id, password FROM hotel_owners WHERE owner_email = '$email' AND password = '$password'";
        $result = mysqli_query($conn, $query);

        // Debugging
        if (!$result) {
            die("Query Error: " . mysqli_error($conn));
        }

        if (mysqli_num_rows($result) > 0) {
            // Fetch the owner data
            $row = mysqli_fetch_assoc($result);

            // Start the session and store user_id and role
            session_start();
            $_SESSION['userid'] = $row['owner_id'];
            $_SESSION['role'] = 'owner';

            // Redirect to owner's profile
            header("Location: owner_profile.php");
            exit;
        } else {
            echo "Invalid email or password";
        }
    }
}

// Close the database connection
mysqli_close($conn);



