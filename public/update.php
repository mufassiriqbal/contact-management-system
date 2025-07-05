<?php


require_once "../config/dbconn.php";

// Basic input validation
if (!isset($_POST['id'], $_POST['name'], $_POST['email'], $_POST['phone'])) {
    die("Missing required fields");
}

//not working so use this
$id = (int)$_POST['id'];
$name = $conn->real_escape_string($_POST['name']);
$email = $conn->real_escape_string($_POST['email']);
$phone = $conn->real_escape_string($_POST['phone']);


$update_query = "UPDATE contacts SET 
                name = '$name', 
                email = '$email', 
                phone = '$phone' 
                WHERE id = $id"; 

if ($conn->query($update_query) ){
   
    header("Location: index.php");
} else {
 
    header("Location: index.php?error=" . $conn->error);
}

$conn->close();
exit(); 
?>