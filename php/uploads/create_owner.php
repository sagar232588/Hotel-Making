<?php require 'connection.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Hotel Owner Account</title>
    <link href="../css/admin.css" rel="stylesheet" type="text/css" media="all" />
    <link href="../css/style.css" rel="stylesheet" type="text/css" media="all" />
    <style>
        .form-container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: 50px auto;
        }

        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-container input[type="text"],
        .form-container input[type="email"],
        .form-container input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .form-container input[type="submit"] {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }

        .form-container input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Create Hotel Owner Account</h2>
    <form method="post" action="create_owner.php">
        <input type="text" name="owner_name" placeholder="Owner Name" required><br/>
        <input type="email" name="owner_email" placeholder="Owner Email" required><br/>
        <input type="text" name="hotel_name" placeholder="Hotel Name" required><br/>
        <input type="password" name="password" placeholder="Password" required><br/>
        <input type="password" name="confirm_password" placeholder="Confirm Password" required><br/>
        <input type="submit" name="submit" value="Create Account"><br/>
    </form>
</div>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $owner_name = mysqli_real_escape_string($conn, $_POST['owner_name']);
    $owner_email = mysqli_real_escape_string($conn, $_POST['owner_email']);
    $hotel_name = mysqli_real_escape_string($conn, $_POST['hotel_name']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    // Check if passwords match
    if ($password != $confirm_password) {
        echo "<p style='color: red; text-align: center;'>Passwords do not match. Please try again.</p>";
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // SQL query to insert owner data
        $query = "INSERT INTO hotel_owners (owner_name, owner_email, hotel_name, password) 
                  VALUES ('$owner_name', '$owner_email', '$hotel_name', '$hashed_password')";

        if (mysqli_query($conn, $query)) {
            echo "<p style='color: green; text-align: center;'>Account created successfully!</p>";
        } else {
            echo "<p style='color: red; text-align: center;'>Error: " . mysqli_error($conn) . "</p>";
        }
    }
}
mysqli_close($conn);
?>
</body>
</html>
