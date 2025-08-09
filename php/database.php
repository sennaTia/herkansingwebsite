<?php
$host = 'db'; // <== naam van de MySQL service in docker-compose.yml
$db   = 'bibliotheek';
$user = 'root';
$pass = 'rootpassword';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database verbinding mislukt: " . $e->getMessage());
}
?>
