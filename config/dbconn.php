<!-- <?php
$serverName = "localhost";
$username = "root";
$password = "";
$databaseName = "contactlist";

$conn = new mysqli($serverName, $username, $password, $databaseName);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?> -->

<?php
try {
    $pdo = new PDO(
        "mysql:host=localhost;dbname=contactlist;charset=utf8mb4",
        "root",
        "",
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>