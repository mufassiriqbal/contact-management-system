<?php
// public/signup.php
session_start(); // Start the session at the very beginning of the script

// open index
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

require_once '../config/dbconn.php';

$error_message = '';   // Variable to store error messages
$success_message = ''; // Variable to store success messages

// Check if the form was submitted using POST method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // --- Backend Validation ---

    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $error_message = 'All fields are required.';
    }
    // Validate email format
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = 'Invalid email format.';
    }
    // Check password length
    elseif (strlen($password) < 8) {
        $error_message = 'Password must be at least 8 characters long.';
    }

    elseif ($password !== $confirm_password) {
        $error_message = 'Passwords do not match.';
    }

    else {
        try {
            // Check if username or email already exists in the database
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = ? OR email = ?");
            $stmt->execute([$username, $email]);
            $count = $stmt->fetchColumn(); 

            if ($count > 0) {
                $error_message = 'Username or Email already exists. Please choose another.';
            } else {
                
                // PASSWORD_DEFAULT uses the strongest algorithm available (currently bcrypt)
                $password_hash = password_hash($password, PASSWORD_DEFAULT);

                $stmt = $pdo->prepare("INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)");
                if ($stmt->execute([$username, $email, $password_hash])) {
                    $success_message = 'Registration successful! You can now <a href="login.php">login</a>.';
                   //clear
                    $username = $email = $password = $confirm_password = '';
                } else {
                   
                    $error_message = 'Something went wrong during registration. Please try again.';
                }
            }
        } catch (\PDOException $e) {
     
            $error_message = 'Database error: ' . $e->getMessage();
         
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Simple Blog Hub</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h2>Sign Up</h2>
        <form action="signup.php" method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email"required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            <button type="submit">Sign Up</button>
        </form>
        <p>Already have an account? <a href="login.php">Login here</a>.</p>
    </div>
</body>
</html>
