<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$db = new Database();
$destinations = $db->getDestinations();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Destinations</title>
    <style>
        .dest-container {
            border: 1px solid black;
            margin: 15px;
            padding: 10px;
            display: flex;
            background-color: white;
            align-items: center;
        }
        .dest-container img {
            margin-right: 20px;
            width: 150px;
            height: 100px;
        }
        .booked-container {
            border: 2px solid green;
            background-color: lightgreen;
            margin: 30px 15px;
            padding: 10px;
            width: fit-content;
        }
        .booked-container img {
            width: 120px;
            height: auto;
        }
    </style>
</head>
<body style="background-color:lightblue">
    <center>
        <h2><b>Available Destinations</b></h2>
    </center>
    <!-- Show All Destinations -->
    <?php foreach ($destinations as $dest): ?>
        <div class="dest-container">
            <img src="<?php echo $dest['image_url']; ?>" alt="">
            <div>
                <h3><?php echo $dest['name']; ?></h3>
                <p><?php echo $dest['description']; ?></p>
                <a href="destination.php?id=<?php echo $dest['id']; ?>">View / Book</a>
            </div>
        </div>
    <?php endforeach; ?>
    <?php if ($_SESSION['user']['role'] === 'user'): ?>
    <a href="my_bookings.php" style="padding: 10px 15px; background: #007bff; color: white; text-decoration: none; border-radius: 5px;">
        View My Booked Packages
    </a>
<?php endif; ?>

   
</body>
</html>
