<?php
try {
    $pdo = new PDO("mysql:host=db;dbname=bibliotheek;charset=utf8mb4", "root", "rootpassword");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $auteur = ''; 
    if (isset($_GET["auteur"])) {
        $auteur = $_GET["auteur"];
    }

    $genre = ''; 
    if (isset($_GET["genre"])) {
        $genre = $_GET["genre"];
    }

    $boeken = [];

    $sql = "SELECT * FROM boeken";

    if ($genre != '' && $auteur != '') {
        $sql .= " WHERE genre LIKE '%$genre%' AND auteur LIKE '%$auteur%'";
    } elseif ($genre != '') {
        $sql .= " WHERE genre LIKE '%$genre%'";
    } elseif ($auteur != '') {
        $sql .= " WHERE auteur LIKE '%$auteur%'";
    }

    $boeken = $pdo->query($sql)->fetchAll();

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
    <input type="text" name="genre" placeholder="Genre..." value="<?php echo $genre; ?>" />
    <input type="text" name="auteur" placeholder="Auteur..." value="<?php echo $auteur; ?>" />
    <button type="submit">Zoeken</button>
  </form>

  <?php if ($boeken): ?>
  <table class="boeken-tabel">
    <thead>
      <tr>
        <th>Auteur</th>
        <th>Titel</th>
        <th>Genre</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($boeken as $boek): ?>
        <tr>
          <td><?php echo $boek['auteur']; ?></td>
          <td><?php echo $boek['titel']; ?></td>
          <td><?php echo $boek['genre']; ?></td>
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
