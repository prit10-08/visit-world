<?php
require 'vendor/autoload.php';

use Dotenv\Dotenv;

class Database {
    private $pdo;

    public function __construct() 
    {
        // Load .env file
        $dotenv = Dotenv::createImmutable(__DIR__);
        $dotenv->load();

        try {
            $this->pdo = new PDO(
                "mysql:host=" . $_ENV['DB_HOST'] . ";dbname=" . $_ENV['DB_NAME'],
                $_ENV['DB_USER'],
                $_ENV['DB_PASS']
            );
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {           
            echo "Connection failed: " . $e->getMessage();
            exit;
        }
    }

    // Method to add a new destination
    public function addDestination($name, $description, $image_url) {
        try 
        {
            $query = "INSERT INTO destinations (name, description, image_url) VALUES (:name, :description, :image_url)";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':image_url', $image_url);

            return $stmt->execute();
        } 
        catch (PDOException $e) 
        {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // Example of fetching a user by ID
    // public function getUser($id) {
    //     try {
    //         $query = "SELECT * FROM users WHERE id = :id";
    //         $stmt = $this->pdo->prepare($query);
    //         $stmt->bindParam(':id', $id);
    //         $stmt->execute();
    //         return $stmt->fetch(PDO::FETCH_ASSOC);
    //     } catch (PDOException $e) {
    //         echo "Error: " . $e->getMessage();
    //         return false;
    //     }
    // }

    public function getUserByUsername($username) {
        try {
            $query = "SELECT * FROM users WHERE username = :username";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("DB Error (getUserByUsername): " . $e->getMessage());
            return false;
        }
    }
    
    public function getDestinationById($id) 
    {
        $stmt = $this->pdo->prepare("SELECT * FROM destinations WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function bookDestination($userId, $destinationId) {
        date_default_timezone_set('Asia/Kolkata');
        $datetime = date('Y-m-d H:i:s'); //date and time
        $stmt = $this->pdo->prepare("INSERT INTO bookings (user_id, destination_id, booking_time) VALUES (?, ?, ?)");
        return $stmt->execute([$userId, $destinationId, $datetime]);
    }
    
    public function getBookingById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM bookings WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllBookingsDetailed() {
        $stmt = $this->pdo->prepare("SELECT b.id AS booking_id,b.booking_time,u.username AS booked_by,d.name AS destination_name,d.image_url
            FROM bookings b
            JOIN users u ON b.user_id = u.id
            JOIN destinations d ON b.destination_id = d.id
            ORDER BY b.booking_time DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function deleteBooking($id) {
        $stmt = $this->pdo->prepare("DELETE FROM bookings WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // public function getLatestBookingForUser($userId, $destinationId) {
    //     $stmt = $this->pdo->prepare("SELECT * FROM bookings WHERE user_id = ? AND destination_id = ? ORDER BY booking_time DESC LIMIT 1");
    //     $stmt->execute([$userId, $destinationId]);
    //     return $stmt->fetch(PDO::FETCH_ASSOC);
    // }

    public function getBookingsForUser($userId) {
        $stmt = $this->pdo->prepare("SELECT * FROM bookings WHERE user_id = :user_id ORDER BY booking_time DESC");
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    
        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return [];
        }
    }
    
    
    public function insertUser($username, $email, $password, $role = 'user') {
        $stmt = $this->pdo->prepare("INSERT INTO users (username, email, password, role) VALUES (:username, :email, :password, :role)");
        return $stmt->execute([
            ':username' => $username,
            ':email'    => $email,
            ':password' => $password, // make sure it's plain or hashed based on your logic
            ':role'     => $role
        ]);
    }
    
  
    
    
    
}
?>
