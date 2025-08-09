<?php
session_start();
if (!($_SESSION['is_admin'] ?? false)) {
    header('Location: login.php');
    exit;
}

$pdo = new PDO("mysql:host=db;dbname=bibliotheek;charset=utf8mb4", "root", "rootpassword");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (isset($_POST['id'])) {
    $stmt = $pdo->prepare("DELETE FROM boeken WHERE id = ?");
    $stmt->execute([$_POST['id']]);
    header('Location: boeken_verwijderen.php');
    exit;
}

$boeken = $pdo->query("SELECT * FROM boeken ORDER BY id DESC")->fetchAll();
?>

<table border="1" cellpadding="5">
    <tr><th>Auteur</th><th>Titel</th><th>Genre</th><th>Verwijderen</th></tr>
    <?php foreach ($boeken as $boek): ?>
    <tr>
        <td><?= htmlspecialchars($boek['auteur']) ?></td>
        <td><?= htmlspecialchars($boek['titel']) ?></td>
        <td><?= htmlspecialchars($boek['genre']) ?></td>
        <td>
            <form method="post" onsubmit="return confirm('Weet je het zeker?');">
                <input type="hidden" name="id" value="<?= $boek['id'] ?>">
                <button>Verwijderen</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<a href="adminpanel.php">Terug</a>
