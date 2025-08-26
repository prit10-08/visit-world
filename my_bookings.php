<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$db = new Database();
$bookings = $db->getBookingsForUser($_SESSION['user']['id']);

// Ensure bookings is always an array
if (!$bookings || !is_array($bookings)) {
    $bookings = [];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Bookings</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .booking-card {
            border: 1px solid #ccc;
            margin: 15px;
            padding: 15px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            background: #f9f9f9;
        }
        .booking-card img {
            margin-right: 20px;
            width: 160px;
            height: auto;
        }
        .booking-info {
            max-width: 600px;
        }
        .delete-btn {
            margin-top: 10px;
            display: inline-block;
            background: #dc3545;
            color: white;
            padding: 8px 12px;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body style="background-color:lightblue">
    <center>
    <h2>My Booked Packages</h2></center>

    <?php if (count($bookings) === 0): ?>
        <p>You have not booked any packages yet.</p>
    <?php else: ?>
        <?php foreach ($bookings as $booking): 
            $dest = $db->getDestinationById($booking['destination_id']);
            $bookingTime = strtotime($booking['booking_time']);
            $canDelete = (time() - $bookingTime) <= 86400; // 86400 seconds = 24 hours
        ?>
            <div class="booking-card">
                <img src="<?php echo $dest['image_url']; ?>" alt="Destination Image">
                <div class="booking-info">
                    <h3><?php echo $dest['name']; ?></h3>
                    <p><?php echo $dest['description']; ?></p>
                    <p><strong>Booked On:</strong> <?php echo date("d M Y, h:i A", $bookingTime); ?></p>

                    <?php if ($canDelete): ?>
                        <form method="GET" action="delete_booking.php" onsubmit="return confirm('Are you sure you want to cancel this booking?');">
                            <input type="hidden" name="id" value="<?php echo $booking['id']; ?>">
                            <button type="submit" class="delete-btn">Cancel Booking</button>
                        </form>
                    <?php else: ?>
                        <p style="color: red;">Cancellation period (24 hours) has expired.</p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>
