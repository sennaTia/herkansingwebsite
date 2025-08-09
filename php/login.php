<?php
session_start();
require 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM gebruikers WHERE username = ? AND password = ?");
    $stmt->execute([$username, $password]);
    $gebruiker = $stmt->fetch();

    if ($gebruiker) {
        $_SESSION['username'] = $gebruiker['username'];

        if ($gebruiker['username'] === 'admin') {
            $_SESSION['is_admin'] = true;
            header('Location: admin_menu.php');
        } else {
            header('Location: menu.php');
        }
        exit;
    } else {
        header('Location: inlog.php?error=1');
        exit;
    }
}
?>

<!-- Inlogformulier -->
<form method="POST">
    <input name="username" placeholder="Gebruikersnaam" required>
    <input type="password" name="password" placeholder="Wachtwoord" required>
    <button type="submit">Inloggen</button>
</form>
