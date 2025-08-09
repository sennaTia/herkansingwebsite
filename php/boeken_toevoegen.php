<?php
session_start();
if (!($_SESSION['is_admin'] ?? false)) {
    header('Location: login.php');
    exit;
}

$pdo = new PDO("mysql:host=db;dbname=bibliotheek;charset=utf8mb4", "root", "rootpassword");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $auteur = $_POST['auteur'] ?? '';
    $titel = $_POST['titel'] ?? '';
    $genre = $_POST['genre'] ?? '';

    if ($auteur && $titel) {
        $stmt = $pdo->prepare("INSERT INTO boeken (auteur, titel, genre) VALUES (?, ?, ?)");
        $stmt->execute([$auteur, $titel, $genre]);
        header('Location: adminpanel.php');
        exit;
    } else {
        echo "Auteur en titel zijn verplicht.";
    }
}
?>

<form method="post">
    Auteur: <input name="auteur" required><br>
    Titel: <input name="titel" required><br>
    Genre: <input name="genre"><br>
    <button>Toevoegen</button>
</form>
<a href="adminpanel.php">Terug</a>
