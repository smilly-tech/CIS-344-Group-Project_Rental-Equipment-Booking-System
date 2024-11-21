<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rent Equipment</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
            text-align: center;
        }

        h1 {
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
            width: 100%;
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
    </style>
</head>
<body>
    <div class="container">
        <h1>Rent Equipment</h1>

        <?php

        if (isset($_GET['equipmentId'])) {
            $equipmentId = $_GET['equipmentId'];


            $equipment = [
                1 => ["name" => "Canon EOS Camera", "type" => "Camera"],
                2 => ["name" => "Sony PlayStation 5", "type" => "Video Game Console"],
                3 => ["name" => "Apple MacBook Pro", "type" => "Laptop"],
                4 => ["name" => "Samsung 65\" TV", "type" => "Television"],
                5 => ["name" => "Epson Projector", "type" => "Projector"],
            ];

            if (array_key_exists($equipmentId, $equipment)) {
                $equipmentItem = $equipment[$equipmentId];
                echo "<p>You're renting <strong>" . $equipmentItem['name'] . "</strong> (Type: " . $equipmentItem['type'] . ")</p>";
            } else {
                echo "<p>Equipment not found.</p>";
            }
        } else {
            echo "<p>No equipment selected.</p>";
        }
        ?>

        <form action="process_equipment.php" method="POST">
            <input type="hidden" name="equipmentId" value="<?php echo $equipmentId; ?>">
            <input type="text" name="name" placeholder="Your Name" required>
            <input type="email" name="email" placeholder="Your Email" required>
            <textarea name="message" placeholder="Why do you want to rent this equipment?" required></textarea>
            <input type="submit" value="Submit Rental Request">
        </form>
    </div>
</body>
</html>
