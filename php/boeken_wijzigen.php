<?php
session_start();
if (!($_SESSION['is_admin'] ?? false)) {
    header('Location: login.php');
    exit;
}

$pdo = new PDO("mysql:host=db;dbname=bibliotheek;charset=utf8mb4", "root", "rootpassword");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $stmt = $pdo->prepare("UPDATE boeken SET auteur = ?, titel = ?, genre = ? WHERE id = ?");
    $stmt->execute([$_POST['auteur'], $_POST['titel'], $_POST['genre'], $_POST['id']]);
    header('Location: boeken_wijzigen.php');
    exit;
}


$editId = $_GET['edit_id'] ?? null;

if ($editId) {
    $stmt = $pdo->prepare("SELECT * FROM boeken WHERE id = ?");
    $stmt->execute([$editId]);
    $boek = $stmt->fetch();
    if (!$boek) {
        echo "Boek niet gevonden.<br><a href='boeken_wijzigen.php'>Terug</a>";
        exit;
    }
}
?>

<?php if ($editId && $boek): ?>
    <form method="post">
        <input type="hidden" name="id" value="<?= $boek['id'] ?>">
        Auteur: <input name="auteur" value="<?= htmlspecialchars($boek['auteur']) ?>" required><br>
        Titel: <input name="titel" value="<?= htmlspecialchars($boek['titel']) ?>" required><br>
        Genre: <input name="genre" value="<?= htmlspecialchars($boek['genre']) ?>"><br>
        <button>Opslaan</button>
    </form>
    <a href="boeken_wijzigen.php">Annuleren</a>
<?php else: ?>
    <table border="1" cellpadding="5">
        <tr>
            <th>Auteur</th>
            <th>Titel</th>
            <th>Genre</th>
            <th>Wijzigen</th>
        </tr>
        <?php
        $boeken = $pdo->query("SELECT * FROM boeken ORDER BY id DESC")->fetchAll();
        foreach ($boeken as $boek) {
            echo "<tr>";
            echo "<td>" . $boek['auteur'] . "</td>";
            echo "<td>" . $boek['titel'] . "</td>";
            echo "<td>" . $boek['genre'] . "</td>";
            echo "<td><a href='?edit_id=" . $boek['id'] . "'>Wijzigen</a></td>";
            echo "</tr>";
        }
        ?>

    </table>
    <a href="adminpanel.php">Terug</a>
<?php endif; ?>