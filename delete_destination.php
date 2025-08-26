<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'developer') {
    header("Location: login.php");
    exit;
}

$db = new Database();
$destinations = $db->getDestinations();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete Destinations</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
        }

        .container {
            width: 80%;
            margin: 40px auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 12px rgba(0,0,0,0.15);
        }

        .destination {
            border: 1px solid #ccc;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            background-color: #fafafa;
        }

        .destination img {
            width: 120px;
            height: auto;
            margin-right: 20px;
            border-radius: 8px;
        }

        .delete-btn {
            background: #dc3545;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 6px;
            cursor: pointer;
        }

        .delete-btn:hover {
            background: #c82333;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Manage & Delete Destinations</h2>

    <?php if (isset($_GET['deleted'])): ?>
        <p style="color: green;">Destination deleted successfully.</p>
    <?php endif; ?>

    <?php foreach ($destinations as $dest): ?>
        <div class="destination">
            <img src="<?php echo htmlspecialchars($dest['image_url']); ?>" alt="Image">
            <div style="flex: 1;">
                <h3><?php echo htmlspecialchars($dest['name']); ?></h3>
                <p><?php echo htmlspecialchars($dest['description']); ?></p>
                <form method="GET" action="delete_single.php" onsubmit="return confirm('Are you sure you want to delete this destination?');">
                    <input type="hidden" name="id" value="<?php echo $dest['id']; ?>">
                    <button class="delete-btn" type="submit">Delete</button>
                </form>
            </div>
        </div>
    <?php endforeach; ?>
</div>
</body>
</html>
