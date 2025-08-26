<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'developer') {
    header("Location: login.php");
    exit;
}

$error = '';
$success = '';
$db = new Database();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $image_url = $_POST['image_url'];

    if ($db->addDestination($name, $description, $image_url)) {
        $success = "Destination added successfully!";
    } else {
        $error = "Failed to add destination.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Destination</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2 style="text-align: center; color: #333;">Add New Destination</h2>

    <?php if ($error) echo "<p style='color:red; text-align:center;'>$error</p>"; ?>
    <?php if ($success) echo "<p style='color:green; text-align:center;'>$success</p>"; ?>

    <form method="POST" style="max-width: 500px; margin: auto; background: #f9f9f9; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
        <label for="name">Name:</label><br>
        <input type="text" name="name" id="name" required style="width:100%; padding:10px; margin-bottom:15px;"><br>

        <label for="description">Description:</label><br>
        <textarea name="description" id="description" required rows="4" style="width:100%; padding:10px; margin-bottom:15px;"></textarea><br>

        <label for="image_url">Image URL:</label><br>
        <input type="text" name="image_url" id="image_url" required style="width:100%; padding:10px; margin-bottom:20px;"><br>

        <input type="submit" value="Add Destination" style="width:100%; padding:12px; background-color:#28a745; border:none; color:white; font-size:16px; cursor:pointer; border-radius:5px;">
    </form>
</div>

</body>
</html>
