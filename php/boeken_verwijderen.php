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

<table border="1">
    <tr>
        <th>Auteur</th>
        <th>Titel</th>
        <th>Genre</th>
        <th>Verwijderen</th>
    </tr>
    <?php foreach ($boeken as $boek) { ?>
    <tr>
        <td><?php echo $boek['auteur']; ?></td>
        <td><?php echo $boek['titel']; ?></td>
        <td><?php echo $boek['genre']; ?></td>
        <td>
            <form method="post">
                <input type="hidden" name="id" value="<?php echo $boek['id']; ?>">
                <button type="submit">Verwijderen</button>
            </form>
        </td>
    </tr>
    <?php } ?>
</table>

<a href="adminpanel.php">Terug</a>
