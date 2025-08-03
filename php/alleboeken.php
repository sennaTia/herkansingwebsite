<!DOCTYPE html>
<html lang="nl">
<head>
  <meta charset="UTF-8">
  <title>Alle Boeken</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
 <header>
  <nav>
    <a href="index.php">← Terug</a>
  </nav>
  <h1>Alle Boeken</h1>
</header>

  <main>
    <h2>Zoek op genre of auteur</h2>

    <form method="get">
      <input type="text" name="genre" placeholder="Genre...">
      <input type="text" name="auteur" placeholder="Auteur...">
      <button type="submit">Zoeken</button>
    </form>

    <?php
      if (!empty($_GET['genre']) || !empty($_GET['auteur'])) {
        $genre = htmlspecialchars($_GET['genre']);
        $auteur = htmlspecialchars($_GET['auteur']);

        echo "<h3>Je zoekt naar:</h3>";
        if ($genre) echo "<p>Genre: <strong>$genre</strong></p>";
        if ($auteur) echo "<p>Auteur: <strong>$auteur</strong></p>";
        echo "<p><em>Resultaten komen hier...</em></p>";
      }
    ?>
  </main>
</body>
</html>
