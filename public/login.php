<?php
// public/login.php
session_start(); 

//for error
$error_message = '';

if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

require_once '../config/dbconn.php';

// Check if the form was submitted using POST method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize user inputs
    $identifier = trim($_POST['identifier'] ?? ''); // Can be username or email
    $password = $_POST['password'] ?? '';

    // --- Backend Validation ---

    // 1. Check if both fields are filled
    if (empty($identifier) || empty($password)) {
        $error_message = 'Both fields are required.';
    } else {
        try {
            // 2. Determine if the identifier is an email or username
            $query = filter_var($identifier, FILTER_VALIDATE_EMAIL) 
                ? "SELECT id, username, password_hash FROM users WHERE email = ?"
                : "SELECT id, username, password_hash FROM users WHERE username = ?";

            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $identifier);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();

            if ($user && password_verify($password, $user['password_hash'])) {
            
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                header('Location: index.php');
                exit();
            } else {
            
                $error_message = 'Invalid username/email or password.';
            }
        } catch (Exception $e) {
            $error_message = 'Login error. Please try again.';
           
    }
}}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form action="login.php" method="POST">
            <div class="form-group">
                <label for="identifier">Username or Email:</label>
                <input type="text" id="identifier" name="identifier" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="signup.php">Sign up here</a>.</p>
    </div>
</body>
</html>