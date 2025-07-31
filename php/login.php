<?php
session_start();
require 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM gebruikers WHERE username = ? AND password = ?");
    $stmt->execute([$username, $password]);
    $gebruiker = $stmt->fetch();
wo
  
}
?>