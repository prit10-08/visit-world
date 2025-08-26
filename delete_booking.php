<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user']) || !isset($_GET['id'])) {
    header("Location: login.php");
    exit;
}

$userId = $_SESSION['user']['id'];
$bookingId = $_GET['id'];

$db = new Database();
$booking = $db->getBookingById($bookingId);

// Check if booking exists and belongs to the current user
if ($booking && $booking['user_id'] == $userId) {
    $bookingTime = strtotime($booking['booking_time']);

    if (time() - $bookingTime <= 86400) { // 24 hours = 86400 seconds
        $db->deleteBooking($bookingId);
        header("Location: my_bookings.php?deleted=1");
        exit;
    } else {
        echo " Sorry, you can only cancel bookings within 24 hours.";
    }
} else {
    echo " Invalid booking or unauthorized action.";
}
?>
