<!DOCTYPE html>
<html lang="nl">
<head>
  <meta charset="UTF-8">
  <title>Reserveringen</title>
  <link rel="stylesheet" href="../css/style3.css">
</head>
<body>
  <header>
    <nav>
      <a href="index.php">← Terug</a>
    </nav>
    <h1>Reserveringen</h1>
  </header>

  <main>
    <h2>Overzicht van reserveringen</h2>

    <div class="resultaat">
      <?php
        // Bestandsnaam
        $bestand = "reserveringen.txt";

        // Check of bestand bestaat en niet leeg is
        if (file_exists($bestand) && filesize($bestand) > 0) {
          // Haal elke regel op
          $regels = file($bestand, FILE_IGNORE_NEW_LINES);

          // Begin lijst
          echo "<ul>";

          $teller = 0;

          // Loop door elke regel
          foreach ($regels as $regel) {
            $delen = explode(" | ", $regel);

            // Sla over als er iets mist
            if (count($delen) !== 4) continue;

            $naam = $delen[0];
            $boek = $delen[1];
            $van  = $delen[2];
            $tot  = $delen[3];

            echo "<li><strong>$naam</strong> reserveerde <em>$boek</em> van <strong>$van</strong> tot <strong>$tot</strong>.</li>";
            $teller++;
          }

          echo "</ul>";
          echo "<p><strong>Totaal: $teller reservering(en)</strong></p>";
        } else {
          echo "<p>Er zijn nog geen reserveringen.</p>";
        }
      ?>
    </div>
  </main>
</body>
</html>
