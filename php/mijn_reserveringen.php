<?php
session_start();


$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 1;

$pdo = new PDO("mysql:host=db;dbname=bibliotheek;charset=utf8mb4", "root", "rootpassword");

if (isset($_POST['boek_id'])) {
    $boek_id = (int)$_POST['boek_id'];
    $stmt = $pdo->prepare("DELETE FROM reserveringen WHERE boek_id = ? AND user_id = ?");
    $stmt->execute(array($boek_id, $user_id));
}

$stmt = $pdo->prepare("SELECT * FROM boeken WHERE id IN (SELECT boek_id FROM reserveringen WHERE user_id = ?)");
$stmt->execute(array($user_id));
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
                        <button class="button button-secondary" type="submit">Annuleren</button>
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
