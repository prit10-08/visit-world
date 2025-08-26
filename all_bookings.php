<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'developer') {
    header("Location: login.php");
    exit;
}

$db = new Database();
$bookings = $db->getAllBookingsDetailed();
?>

<!DOCTYPE html>
<html>
<head>
    <title>All Bookings - Developer Panel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #eef2f3;
        }

        .container {
            width: 90%;
            margin: 40px auto;
            background-color: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 12px rgba(0,0,0,0.15);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ccc;
            text-align: left;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        img {
            width: 100px;
            height: auto;
            border-radius: 8px;
        }

        .back-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            border-radius: 8px;
            text-decoration: none;
        }

        .back-btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

<div class="container">
    <h2> All Bookings</h2>

    <?php if (count($bookings) === 0): ?>
        <p>No bookings found.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Destination</th>
                    <th>Booked By</th>
                    <th>Image</th>
                    <th>Booking Time</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bookings as $index => $b): ?>
                    <tr>
                        <td><?php echo $index + 1; ?></td>
                        <td><?php echo htmlspecialchars($b['destination_name']); ?></td>
                        <td><?php echo htmlspecialchars($b['booked_by']); ?></td>
                        <td><img src="<?php echo $b['image_url']; ?>" alt="Image"></td>
                        <td><?php echo date("d M Y, h:i A", strtotime($b['booking_time'])); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <a class="back-btn" href="home.php">← Back to Developer Dashboard</a>
</div>

</body>
</html>
