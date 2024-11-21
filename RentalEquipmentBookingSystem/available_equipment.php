<?php
include 'db_config.php';


$sql = "SELECT * FROM Equipment WHERE AvailabilityStatus = 'Available'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Equipment for Rent</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff;
            color: #333;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }

        h1 {
            color: #1e90ff;
            margin-bottom: 30px;
        }

        .equipment-list {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            max-width: 1000px;
            width: 100%;
        }

        .equipment-item {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
        }

        .equipment-item img {
            width: 100%;
            height: auto;
            border-radius: 10px;
        }

        .equipment-item h2 {
            margin: 15px 0 10px;
            color: #333;
        }

        .equipment-item p {
            margin: 10px 0;
        }

        .equipment-item a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #1e90ff;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .equipment-item a:hover {
            background-color: #4682b4;
        }
    </style>
</head>
<body>
    <h1>Available Equipment for Rent</h1>

    <div class="equipment-list">
        <?php
        if ($result->num_rows > 0) {

            while($row = $result->fetch_assoc()) {
              
                $imageName = strtolower(str_replace(" ", "_", $row['Name']));
                echo "<div class='equipment-item'>";
                echo "<img src='images/{$imageName}.jpg' alt='{$row['Name']}'>";
                echo "<h2>{$row['Name']}</h2>";
                echo "<p>Category: {$row['Category']}</p>";
                echo "<p>Price per day: \${$row['RentalRate']}</p>";
                echo "<a href='rent.php?equipmentId={$row['EquipmentID']}&csrf_token=" . generate_csrf_token() . "'>Rent Now</a>";
                echo "</div>";
            }
        } else {
            echo "<p>No equipment available at the moment.</p>";
        }

        $conn->close();
        ?>
    </div>
</body>
</html>
