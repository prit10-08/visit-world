<?php
session_start();
if (isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

require 'db.php';
$db = new Database();
$destinations = $db->getDestinations();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Visit World</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .destination-box {
            display: flex;
            background-color: whitesmoke;
            margin-bottom: 20px;
            padding: 15px;
            border-radius: 10px;
            align-items: center;
            box-shadow: 0 0 8px gray;
        }

        .destination-box img {
            width: 200px;
            height: 150px;
            object-fit: cover;
            margin-right: 20px;
            border-radius: 10px;
        }

        .destination-details {
            flex-grow: 1;
        }
    </style>
</head>
<body style="background-image: url('new_york.jpg'); background-size: cover; background-repeat: no-repeat; background-position: center;">
    <div class="container">
        <h1>Welcome to Visit World</h1>
        <p>Plan your next dream vacation today!</p>
        <a href="register.php">Register</a> |
        <a href="login.php">Login</a>

        <?php foreach ($destinations as $dest): ?>
            <div class="destination-box">
                <img src="<?php echo htmlspecialchars($dest['image_url']); ?>" alt="Image for <?php echo htmlspecialchars($dest['name']); ?>">
                <div class="destination-details">
                    <h3><?php echo htmlspecialchars($dest['name']); ?></h3>
                    <p><?php echo htmlspecialchars($dest['description']); ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
