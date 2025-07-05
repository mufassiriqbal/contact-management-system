<?php

require_once "../config/dbconn.php";
require_once "../includes/auth.php";

$currentUserId = requireAuth();

//
$name = $conn->real_escape_string($_POST['fName'] ?? '');
$email = $conn->real_escape_string($_POST['email'] ?? '');
$phone = $conn->real_escape_string($_POST['phone'] ?? '');

// Validate
if (empty($name) || empty($phone)) {
    die("Name and phone are required fields");
}


$stmt = $conn->prepare("INSERT INTO contacts (user_id, name, email, phone) VALUES (?, ?, ?, ?)");
$stmt->bind_param("isss", $currentUserId, $name, $email, $phone);

if ($stmt->execute()) {
    header("Location: index.php?success=contact_added");
} else {
    header("Location: index.php?error=insert_failed&message=" . urlencode($conn->error));
}

$stmt->close();
$conn->close();
exit();









// $name = $_POST['fName'];
// $email = $_POST['email'];
// $phone = $_POST['phone'];
// // $id = $_POST['id'];
// $insert_query = "INSERT INTO contacts (name, email,phone) 
// VALUES ('$name', '$email' ,'$phone' )";

// if($conn->query($insert_query) === true){
//     // echo"Data have been inserted successfully";
//        header("Location: index.php");
// }
// else{
//     echo "insertion failed";
// }

// $delete_query = "delete from contact where id = '$id'";
// if($conn->query($delete_query) === true){
//     echo"Data have been DELETED successfully";
// }
// else{
//     echo "insertion failed";
// }



// $conn->close();


?>