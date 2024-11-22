<?php

include 'security.php';


ini_set('display_errors', 1);
error_reporting(E_ALL);


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   
    if (!isset($_POST['csrf_token']) || !validate_csrf_token($_POST['csrf_token'])) {
        die("Invalid CSRF token.");
    }


    $equipmentId = sanitize_input($_POST['equipmentId']);
    $name = sanitize_input($_POST['name']);
    $email = sanitize_input($_POST['email']);
    $message = sanitize_input($_POST['message']);

  
    $confirmationMessage = "Thank you, $name! We have received your rental request for the equipment (ID: $equipmentId).";
    $confirmationMessage .= "<br>Your message: <strong>$message</strong>";
    $confirmationMessage .= "<br>We will respond to your email at <strong>$email</strong> shortly.";
} else {
    $confirmationMessage = "Invalid request. Please go back and submit the form again.";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rental Request Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            background-image: url('images/rental-background.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            position: relative;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(255, 255, 255, 0.7);
        }

        .content {
            position: relative;
            z-index: 2;
            padding: 20px;
            max-width: 600px;
            border-radius: 10px;
            background-color: rgba(255, 255, 255, 0.9);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        h1 {
            font-size: 2.5em;
            margin-bottom: 20px;
            color: #1e90ff;
        }

        p {
            font-size: 1.2em;
            margin-bottom: 20px;
        }

        footer {
            margin-top: 20px;
            font-size: 0.9em;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="overlay"></div>
    <div class="content">
        <h1>Rental Request Confirmation</h1>

        <?php
        echo $confirmationMessage;
        ?>

        <footer>
            <p>&copy; 2024 Smiller & Joshua Rentals. All rights reserved.</p>
        </footer>
    </div>
</body>
</html>
