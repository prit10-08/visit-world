<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - Visit World</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background-color: lightgray;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            max-width: 500px;
            margin: 60px auto;
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
            text-align: center;
        }

        h2 {
            font-size: 26px;
            margin-bottom: 25px;
            color: navy;
        }

        .btn {
            display: inline-block;
            padding: 12px 25px;
            margin: 10px;
            font-size: 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            color: white;
        }

        .view {
            background-color: #007bff;
        }

        .view:hover {
            background-color: #0056b3;
        }

        .logout {
            background-color: #dc3545;
        }

        .logout:hover {
            background-color: #c82333;
        }

        .add {
            background-color: #28a745;
            font-weight: bold;
        }

        .add:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['user']['username']); ?>!</h2>

    <a href="destinations.php" class="btn view">🌍 View Destinations</a>
    <a href="logout.php" class="btn logout">🚪 Logout</a>
</div>

</body>
</html>
