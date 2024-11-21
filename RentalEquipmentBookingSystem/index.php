<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookable Rentals</title>
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
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            position: relative;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(255, 255, 255, 0.7);
            z-index: 1;
        }

        .content {
            position: relative;
            z-index: 2;
            padding: 20px;
            max-width: 800px;
            border-radius: 10px;
            background-color: rgba(255, 255, 255, 0.9);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
            color: #1e90ff;
        }

        p {
            font-size: 1.2em;
            margin-bottom: 20px;
        }

        a {
            display: inline-block;
            background-color: #1e90ff;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
            margin: 5px;
        }

        a:hover {
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
        <h1>Welcome to Bookable Rentals</h1>
        <p>Your trusted source for renting high-quality equipment. Choose from cameras, projectors, laptops, and more!</p>
        <a href="available_equipment.php">View Available Equipment</a>
        <a href="company_contact.php">Contact Us</a>
        <footer>
            <p>&copy; 2024 Bookable Rentals. All rights reserved.</p>
        </footer>
    </div>
</body>
</html>
