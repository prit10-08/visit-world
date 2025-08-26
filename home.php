<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'developer') {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Developer Home - Visit World</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background-color: #f5f5f5;
            font-family: Arial, sans-serif;
        }

        .container {
            width: 80%;
            max-width: 600px;
            margin: 60px auto;
            background-color: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
            text-align: center;
        }

        h2 {
            color: #2c3e50;
        }

        .btn {
            display: block;
            width: 100%;
            margin: 15px 0;
            padding: 15px;
            font-size: 16px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            transition: 0.3s;
        }

        .btn:hover {
            background-color: #2980b9;
        }

        .logout-btn {
            background-color: #e74c3c;
        }

        .logout-btn:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Welcome Developer, <?php echo htmlspecialchars($_SESSION['user']['username']); ?> 👋</h2>

    <a class="btn" href="add_destination.php"> Add Destination</a>
    <a class="btn" href="all_bookings.php"> View All Bookings</a>

    <a class="btn" href="destinations.php"> View Packages</a>
    <a class="btn" href="delete_destination.php"> Delete Destination</a>

    <a class="btn logout-btn" href="logout.php"> Logout</a>
</div>

</body>
</html>
