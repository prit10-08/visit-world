<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'developer') {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    echo "Invalid request.";
    exit;
}

$db = new Database();

// Delete related bookings first (optional if using ON DELETE CASCADE)
$db->pdo->prepare("DELETE FROM bookings WHERE destination_id = ?")->execute([$_GET['id']]);

// Now delete the destination
$stmt = $db->pdo->prepare("DELETE FROM destinations WHERE id = ?");
if ($stmt->execute([$_GET['id']])) {
    header("Location: delete_destination.php?deleted=1");
} else {
    echo "Failed to delete destination.";
}
exit;
?>
