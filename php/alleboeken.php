<?php
try {
    $pdo = new PDO("mysql:host=db;dbname=bibliotheek;charset=utf8mb4", "root", "rootpassword");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $genre = $_GET['genre'] ?? '';
    $auteur = $_GET['auteur'] ?? '';

    $boeken = [];

    // Alleen zoeken als genre of auteur ingevuld is
    if ($genre !== '' || $auteur !== '') {
        $sql = "SELECT * FROM boeken WHERE 1=1";
        $params = [];

        if ($genre !== '') {
            $sql .= " AND genre LIKE ?";
            $params[] = "%$genre%";
        }
        if ($auteur !== '') {
            $sql .= " AND auteur LIKE ?";
            $params[] = "%$auteur%";
        }

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $boeken = $stmt->fetchAll();
    }

} catch (PDOException $e) {
    die("Database fout: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
  <meta charset="UTF-8" />
  <title>Alle Boeken</title>
  <link rel="stylesheet" href="../css/style3.css" />
</head>
<body>

<header>
  <nav><a href="index.php">← Terug</a></nav>
  <h1>Alle Boeken</h1>
</header>

<main>
  <form method="get" class="zoek-formulier">
    <input type="text" name="genre" placeholder="Genre..." value="<?= htmlspecialchars($genre) ?>" />
    <input type="text" name="auteur" placeholder="Auteur..." value="<?= htmlspecialchars($auteur) ?>" />
    <button type="submit">Zoeken</button>
  </form>

  <?php if ($boeken): ?>
  <table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse; width: 100%; max-width: 600px; margin-top: 1rem;">
    <thead style="background-color: #f2f2f2;">
      <tr>
        <th style="text-align: left;">Auteur</th>
        <th style="text-align: left;">Titel</th>
        <th style="text-align: left;">Genre</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($boeken as $boek): ?>
        <tr>
          <td><?= htmlspecialchars($boek['auteur']) ?></td>
          <td><?= htmlspecialchars($boek['titel']) ?></td>
          <td><?= htmlspecialchars($boek['genre']) ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
<?php else: ?>
  <p>Geen boeken gevonden voor deze zoekopdracht.</p>
<?php endif; ?>

</main>

</body>
</html>
