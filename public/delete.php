<?php
require_once "../config/dbconn.php";

$id = $_GET['id']; // use post from index php 

$delete_query = "DELETE FROM contacts WHERE id = '$id'";

if ($conn->query($delete_query) === TRUE) {
    echo "Contact deleted successfully.";
} else {
    echo "failed: " . $conn->error;
}

$conn->close();

//redirect back
header("Location: index.php");
exit();
?>
