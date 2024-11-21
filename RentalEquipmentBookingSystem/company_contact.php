<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Bookable Rentals</title>
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

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-top: 20px;
        }

        input, textarea {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1em;
        }

        input[type="submit"] {
            background-color: #1e90ff;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #4682b4;
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
        <h1>Contact Us</h1>

        <?php
        // Check if the form was submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $message = $_POST['message'];

            // Process the form (e.g., send an email, save to a file, etc.)
            echo "<p>Thank you, $name! We have received your message:</p>";
            echo "<p><strong>Your Message:</strong> $message</p>";
            echo "<p>We will respond to your email at <strong>$email</strong> shortly.</p>";
        }
        ?>

        <!-- Contact Form -->
        <form action="company_contact.php" method="POST">
            <input type="text" name="name" placeholder="Your Name" required>
            <input type="email" name="email" placeholder="Your Email" required>
            <textarea name="message" placeholder="Your Message" rows="5" required></textarea>
            <input type="submit" value="Send Message">
        </form>

        <footer>
            <p>&copy; 2024 Bookable Rentals. All rights reserved.</p>
        </footer>
    </div>
</body>
</html>
