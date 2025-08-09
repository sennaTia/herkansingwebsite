<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$message = ''; // altijd initialiseren
$boeken = []; // ook altijd initialiseren

try {
    $pdo = new PDO("mysql:host=db;dbname=bibliotheek;charset=utf8mb4", "root", "rootpassword");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_POST['boek_id'])) {
        $boek_id = (int)$_POST['boek_id'];
        $user_id = $_SESSION['user_id'];

        $stmt = $pdo->prepare("SELECT * FROM reserveringen WHERE boek_id = ?");
        $stmt->execute([$boek_id]);
        $reservering = $stmt->fetch();

        if ($reservering) {
            $message = "Dit boek is al gereserveerd.";
        } else {
            $stmt = $pdo->prepare("INSERT INTO reserveringen (boek_id, user_id) VALUES (?, ?)");
            $stmt->execute([$boek_id, $user_id]);
            $message = "Boek succesvol gereserveerd!";
        }

        // Redirect om refresh dubbel post te voorkomen
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }

    $stmt = $pdo->query("SELECT * FROM boeken WHERE id NOT IN (SELECT boek_id FROM reserveringen)");
    $boeken = $stmt->fetchAll();

} catch (PDOException $e) {
    $message = "Er is een fout opgetreden: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Boeken reserveren</title>
</head>
<body>

<h1>Boeken reserveren</h1>

<p><a href="mijn_reserveringen.php">Bekijk mijn reserveringen</a></p>

<?php if ($message): ?>
    <p><strong><?= htmlspecialchars($message) ?></strong></p>
<?php endif; ?>

<?php if (count($boeken) === 0): ?>
    <p>Geen boeken beschikbaar.</p>
<?php else: ?>
    <form method="post">
        <select name="boek_id" required>
            <option value="">-- Kies een boek --</option>
            <?php foreach ($boeken as $boek): ?>
                <option value="<?= $boek['id'] ?>">
                    <?= htmlspecialchars($boek['titel']) ?> (<?= htmlspecialchars($boek['auteur']) ?>)
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Reserveer</button>
    </form>
<?php endif; ?>

<a href="logout.php">Uitloggen</a>

</body>
</html>
