<?php
function requireAuth() {
    session_start();
    
    if (empty($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }
    
    return $_SESSION['user_id'];
}

function redirectIfLoggedIn() {
    session_start();
    if (!empty($_SESSION['user_id'])) {
        header("Location: index.php");
        exit();
    }
}
?>