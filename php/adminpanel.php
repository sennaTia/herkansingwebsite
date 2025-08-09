<?php
session_start();

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header('Location: login.php');
    exit;
}
?>

<h1>Boeken beheren</h1>
<a href="boeken_toevoegen.php">Boeken Toevoegen</a><br>
<a href="boeken_verwijderen.php">Boeken Verwijderen</a><br>
<a href="boeken_wijzigen.php">Boeken Wijzigen</a><br>
<a href="logout.php">Uitloggen</a>
