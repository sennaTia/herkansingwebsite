<?php
session_start();

// Voorbeeld: stel dat je ingelogd bent en user_id in de session staat
$user_id = $_SESSION['user_id'] ?? 1; // tijdelijk 1 als test

// Connectie maken met database
$pdo = new PDO("mysql:host=db;dbname=bibliotheek;charset=utf8mb4", "root", "rootpassword");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Annuleren van reservering (als er een boek_id wordt meegegeven via POST)
if (isset($_POST['boek_id'])) {
    $boek_id = (int)$_POST['boek_id'];
    $stmt = $pdo->prepare("DELETE FROM reserveringen WHERE boek_id = ? AND user_id = ?");
    $stmt->execute([$boek_id, $user_id]);
}

// Haal alle reserveringen van deze gebruiker op
$stmt = $pdo->prepare("SELECT b.id, b.titel, b.auteur, b.genre 
                       FROM boeken b 
                       JOIN reserveringen r ON b.id = r.boek_id 
                       WHERE r.user_id = ?");
$stmt->execute([$user_id]);
$reserveringen = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Mijn reserveringen</title>
    <link rel="stylesheet" href="../css/style3.css">
</head>
<body>
    <h1>Mijn reserveringen</h1>

    <?php if (count($reserveringen) === 0): ?>
        <p>Je hebt geen reserveringen.</p>
    <?php else: ?>
        <table border="1" cellpadding="5">
            <tr>
                <th>Auteur</th>
                <th>Titel</th>
                <th>Genre</th>
                <th>Annuleren</th>
            </tr>
            <?php foreach ($reserveringen as $boek): ?>
            <tr>
                <td><?= htmlspecialchars($boek['auteur']) ?></td>
                <td><?= htmlspecialchars($boek['titel']) ?></td>
                <td><?= htmlspecialchars($boek['genre']) ?></td>
                <td>
                    <div class="formmargin">
                    <form method="post" >
                        <input type="hidden" name="boek_id" value="<?= $boek['id'] ?>">
                        <button1 type="submit">Annuleren</button1>
                    </form>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>

    <p><a href="reserveren.php">Terug naar boeken reserveren</a></p>
</body>
</html>
