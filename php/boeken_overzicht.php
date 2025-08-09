<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$pdo = new PDO("mysql:host=db;dbname=bibliotheek;charset=utf8mb4", "root", "rootpassword");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Boek reserveren (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['boek_id'])) {
    $boek_id = (int)$_POST['boek_id'];
    $user_id = $_SESSION['user_id'];

    // Check of boek nog beschikbaar is
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM reserveringen WHERE boek_id = ?");
    $stmt->execute([$boek_id]);
    if ($stmt->fetchColumn() > 0) {
        echo "<p>Dit boek is helaas al gereserveerd.</p>";
    } else {
        // Boek reserveren
        $stmt = $pdo->prepare("INSERT INTO reserveringen (boek_id, user_id) VALUES (?, ?)");
        $stmt->execute([$boek_id, $user_id]);
        echo "<p>Boek succesvol gereserveerd!</p>";
    }
}

// Alle boeken ophalen die nog niet gereserveerd zijn
$stmt = $pdo->query("
    SELECT * FROM boeken 
    WHERE id NOT IN (SELECT boek_id FROM reserveringen)
    ORDER BY id DESC
");
$boeken = $stmt->fetchAll();
?>

<h1>Beschikbare Boeken</h1>
<?php if (count($boeken) === 0): ?>
    <p>Geen boeken beschikbaar om te reserveren.</p>
<?php else: ?>
<table border="1" cellpadding="5">
    <tr><th>Auteur</th><th>Titel</th><th>Genre</th><th>Reserveer</th></tr>
    <?php foreach ($boeken as $boek): ?>
    <tr>
        <td><?= htmlspecialchars($boek['auteur']) ?></td>
        <td><?= htmlspecialchars($boek['titel']) ?></td>
        <td><?= htmlspecialchars($boek['genre']) ?></td>
        <td>
            <form method="post" onsubmit="return confirm('Weet je zeker dat je dit boek wilt reserveren?');">
                <input type="hidden" name="boek_id" value="<?= $boek['id'] ?>">
                <button type="submit">Reserveer</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<?php endif; ?>

<a href="logout.php">Uitloggen</a>
