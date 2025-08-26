<?php
session_start();
require 'db.php';
$db = new Database();

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $user = $db->getUserByUsername($username); 

    if ($user) 
    {
        if (password_verify($password, $user['password'])) 
        {
            $_SESSION['user'] = [
                'id' => $user['id'],
                'username' => $user['username'],
                'role' => $user['role']
            ];

            
            if ($user['role'] === 'developer') 
            {
                header("Location: home.php");
            }
            elseif ($user['role'] === 'user') 
            {
                header("Location: dashboard.php");
            } 
            else 
            {
                $error = "Invalid role assigned.";
            }
            exit;
        } 
        else 
        {
            $error = "Incorrect password.";
        }
    } 
    else 
    {
        $error = "User not found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - Visit World</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Login</h2>
    <?php if (!empty($error)) echo "<p style='color: red;'>".htmlspecialchars($error)."</p>"; ?>
    <form method="POST" action="">
        <label>Username:</label><br>
        <input type="text" name="username" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>

        <input type="submit" value="Login">
    </form>
    <p>Don't have an account? <a href="register.php">Register here</a></p>
</div>
</body>
</html>
