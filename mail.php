<?php
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Collect and sanitize input data
    $name = htmlspecialchars(trim($_POST['name']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $subject = htmlspecialchars(trim($_POST['subject']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Validate required fields
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        die("All fields are required. Please go back and fill out the form.");
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format. Please go back and provide a valid email address.");
    }

    // Email headers
    $mailheader = "From: " . $name . " <" . $email . ">\r\n";
    $mailheader .= "Reply-To: " . $email . "\r\n";
    $mailheader .= "Content-type: text/html; charset=UTF-8\r\n";

    // Recipient email
    $recipient = "edogola4@gmail.com"; // Replace with your email address

    // Send email and check if successful
    if (mail($recipient, $subject, nl2br($message), $mailheader)) {
        echo '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Thank You</title>
            <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Poppins&display=swap" rel="stylesheet">
            <link rel="stylesheet" href="style.css">
        </head>
        <body>
            <div class="container">
                <h1>Thank you for contacting me, ' . htmlspecialchars($name) . '!</h1>
                <p>I will get back to you as soon as possible at ' . htmlspecialchars($email) . '.</p>
                <p class="back">Go back to the <a href="index.html">homepage</a>.</p>
            </div>
        </body>
        </html>
        ';
    } else {
        echo '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Error</title>
            <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Poppins&display=swap" rel="stylesheet">
            <link rel="stylesheet" href="style.css">
        </head>
        <body>
            <div class="container">
                <h1>Oops! Something went wrong.</h1>
                <p>We couldn\'t send your message. Please try again later.</p>
                <p class="back">Go back to the <a href="index.html">homepage</a>.</p>
            </div>
        </body>
        </html>
        ';
    }
} else {
    // Redirect if not POST
    header("Location: index.html");
    exit();
}
?>
