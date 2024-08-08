<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Create a new line of data
    $feedbackData = "Name: $name\nEmail: $email\nMessage: $message\n\n";

    // Append the data to the feedback.txt file
    $file = fopen('feedback.txt', 'a');
    fwrite($file, $feedbackData);
    fclose($file);

    // Redirect to a thank you page
    header('Location: thank.html');
    exit();
}
?>
