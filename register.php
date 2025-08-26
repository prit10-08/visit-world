<?php
session_start();
require 'db.php';
require 'vendor/autoload.php'; // PHPMailer + dotenv

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

// Load environment variables
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$db = new Database();
$step = isset($_POST['step']) ? $_POST['step'] : '1';
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if ($step === '1') {
        $username = trim($_POST['username']);
        $email    = trim($_POST['email']);
        $password = $_POST['password'];

        // Simple validation
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "Invalid email format.";
        } elseif (strlen($password) < 6) {
            $error = "Password must be at least 6 characters.";
        } else {
            $otp = rand(100000, 999999);
            $_SESSION['otp'] = $otp;
            $_SESSION['reg_data'] = [
                'username' => htmlspecialchars($username, ENT_QUOTES, 'UTF-8'),
                'email'    => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT)
            ];

            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = $_ENV['MAIL_USERNAME']; 
                $mail->Password   = $_ENV['MAIL_PASSWORD']; 
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = 587;

                $mail->setFrom($_ENV['MAIL_USERNAME'], 'Visit World');
                $mail->addAddress($email);

                $mail->isHTML(true);
                $mail->Subject = 'Your OTP Code';
                $mail->Body    = "Your OTP for Visit World registration is <strong>$otp</strong>. It is valid for 10 minutes.";

                $mail->send();
                $step = '2';
            } catch (Exception $e) {
                error_log("Mailer Error: " . $mail->ErrorInfo);
                $error = "OTP could not be sent. Please try again.";
            }
        }

    } elseif ($step === '2') {
        $enteredOtp = $_POST['otp'];
        if (isset($_SESSION['otp']) && $_SESSION['otp'] == $enteredOtp) {
            $user = $_SESSION['reg_data'];

            if ($db->insertUser($user['username'], $user['email'], $user['password'])) {
                unset($_SESSION['otp'], $_SESSION['reg_data']);
                header("Location: login.php");
                exit;
            } else {
                $error = "Registration failed. Email might already exist.";
            }
        } else {
            $error = "Invalid OTP. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register - Visit World</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>User Registration</h2>

    <?php if (!empty($error)) echo "<p style='color: red;'>$error</p>"; ?>

    <?php if ($step === '1'): ?>
        <form method="POST">
            <input type="hidden" name="step" value="1">
            Username: <input type="text" name="username" required><br>
            Email: <input type="email" name="email" required><br>
            Password: <input type="password" name="password" required><br>
            <input type="submit" value="Get OTP">
        </form>
    <?php elseif ($step === '2'): ?>
        <form method="POST">
            <input type="hidden" name="step" value="2">
            Enter OTP sent to your email: <input type="number" name="otp" required><br>
            <input type="submit" value="Verify & Register">
        </form>
    <?php endif; ?>

    <p>Already have an account? <a href="login.php">Login here</a></p>
</div>
</body>
</html>
