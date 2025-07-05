<?php
// for the logout only
session_start(); 
//gloabal sesion array

$_SESSION = array();


session_destroy();


header('Location: login.php');
exit();
?>
