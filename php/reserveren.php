<!DOCTYPE html>
<html lang="nl">
<head>
  <meta charset="UTF-8">
  <title>Boek Reserveren</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
  <header>
    <nav>
      <a href="index.php">← Terug</a>
    </nav>
    <h1>Reserveren</h1>
    <nav></nav>
  </header>

  <main>
    <h2>Reserveer een boek</h2>

    <form method="post">
      <input type="text" name="naam" placeholder="Jouw naam..." required>
      <input type="text" name="boek" placeholder="Titel van het boek..." required>
      <input type="date" name="datum" required>
      <button type="submit">Reserveren</button>
    </form>

    <?php
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $naam = htmlspecialchars($_POST['naam']);
        $boek = htmlspecialchars($_POST['boek']);
        $datum = htmlspecialchars($_POST['datum']);

        // Einddatum = 14 dagen later
        $startDatum = new DateTime($datum);
        $eindDatum = clone $startDatum;
        $eindDatum->modify('+14 days');
        $tot = $eindDatum->format('Y-m-d');

        // Reservering opslaan
        $regel = "$naam | $boek | $datum | $tot\n";
        file_put_contents("reserveringen.txt", $regel, FILE_APPEND);

        echo "<div class='resultaat'>";
        echo "<h3>Reservering ontvangen:</h3>";
        echo "<p><strong>Naam:</strong> $naam</p>";
        echo "<p><strong>Boek:</strong> $boek</p>";
        echo "<p><strong>Van:</strong> $datum</p>";
        echo "<p><strong>Tot:</strong> $tot</p>";
        echo "</div>";
      }
    ?>

    <p style="margin-top: 2rem;"><a href="reserveringen.php"> Bekijk alle reserveringen</a></p>
  </main>
</body>
</html>
