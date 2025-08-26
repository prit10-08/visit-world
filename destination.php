<?php
session_start();
require 'db.php';

if (!isset($_GET['id'])) {
    header("Location: destinations.php");
    exit;
}

$db = new Database();
$destination = $db->getDestinationById($_GET['id']);

if (!$destination) {
    echo "Destination not found.";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo htmlspecialchars($destination['name']); ?> - Visit World</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f2f5;
            padding: 40px;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.15);
            overflow: hidden;
        }

        .image-container {
            width: 100%;
            height: 400px;
            overflow: hidden;
        }

        .image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .details {
            padding: 30px;
        }

        h1 {
            font-size: 36px;
            margin-bottom: 15px;
            color: #333;
            text-align: center;
        }

        p {
            font-size: 18px;
            line-height: 1.6;
            color: #555;
            margin-bottom: 25px;
            text-align: justify;
        }

        .btn-book {
            display: inline-block;
            padding: 12px 25px;
            font-size: 16px;
            font-weight: bold;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .btn-book:hover {
            background-color: #218838;
        }

        .btn-back {
            display: inline-block;
            margin-top: 20px;
            font-size: 14px;
            color: #007bff;
            text-decoration: underline;
        }

        .btn-back:hover {
            color: #0056b3;
        }

        .action-buttons {
            text-align: center;
        }
    </style>
</head>
<body style="background-color:lightgrey">

    <div class="container">
        <div class="image-container">
            <img src="<?php echo $destination['image_url']; ?>" alt="<?php echo htmlspecialchars($destination['name']); ?>">
        </div>

        <div class="details">
            <h1><?php echo htmlspecialchars($destination['name']); ?></h1>
            <p><?php echo htmlspecialchars($destination['description']); ?></p>

            <div class="action-buttons">
                <form method="GET" action="book.php" style="display:inline;">
                    <input type="hidden" name="id" value="<?php echo $destination['id']; ?>">
                    <button class="btn-book" type="submit" onclick="return confirm('Are you sure you want to book this destination?');">Book This Package</button>
                </form>
                <br>
                <a class="btn-back" href="destinations.php" >← Back to all destinations</a>
            </div>
        </div>
    </div>


</body>
</html>
