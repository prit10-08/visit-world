<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user']) || !isset($_GET['id'])) {
    echo "<pre>";
print_r($_SESSION);
echo "</pre>";
exit;

    header("Location: login.php");
    exit;
}

$userId = $_SESSION['user']['id'];
$destinationId = $_GET['id'];

$db = new Database();
$db->bookDestination($userId, $destinationId);





// Save last booked ID in session to show on destinations.php
$_SESSION['just_booked'] = $destinationId;

header("Location: destinations.php");
exit;
?>
