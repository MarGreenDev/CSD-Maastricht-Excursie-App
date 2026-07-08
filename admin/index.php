<?php
session_start();
include_once '../includes/connection.php';

$sql = "SELECT * FROM activiteiten";
$activiteiten = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="nl">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin • Nieuwe activiteit</title>
    <link rel="stylesheet" href="../assets/css/style.css" />
  </head>
  <body>
    <div class="page-shell">
      <header class="topbar">
        <a class="brand" href="../index.php">Maastricht<span>Trip</span></a>
      </header>

      <main class="admin-page">
        <section class="admin-card">
          <?php if (!isset($_SESSION["user_id"])): ?>
            <p class="eyebrow">Toegang</p>
            <h1>Log in om activiteiten toe te voegen.</h1>
            <p class="hero-text">Deze pagina is alleen beschikbaar voor beheerders.</p>
          <?php elseif ((int)$_SESSION["user_id"] !== 1): ?>
            <p class="eyebrow">Toegang geweigerd</p>
            <h1>Jij bent hier niet welkom.</h1>
          <?php else: ?>
            <p class="eyebrow">Admin paneel</p>
            <h1>Nieuwe activiteit toevoegen</h1>
            <p class="hero-text">Vul hieronder de details in voor een nieuwe excursie.</p>

            <form class="admin-form" action="../add-activiteit.php" method="post">
              <label class="admin-field">
                <span>Naam activiteit</span>
                <input type="text" name="activiteit" placeholder="Bijv. Wandeltocht door de binnenstad" />
              </label>

              <label class="admin-field">
                <span>Omschrijving</span>
                <textarea name="activiteitOmschrijving" rows="4" placeholder="Beschrijf wat studenten kunnen verwachten..."></textarea>
              </label>

              <div class="admin-grid">
                <label class="admin-field">
                  <span>Datum</span>
                  <input type="date" name="datum" />
                </label>

                <label class="admin-field">
                  <span>Tijd</span>
                  <input type="time" name="tijd" />
                </label>
              </div>

              <button class="btn btn-primary full-width" type="submit">Activiteit toevoegen</button>
            </form>

            <div class="table-section">
              <div class="table-heading">
                <h2>Bestaande activiteiten</h2>
                <p>Hier verschijnen je toegevoegde activiteiten.</p>
              </div>

              <div class="table-wrap">
                <table class="activity-table">
                  <thead>
                    <tr>
                      <th>Activiteit</th>
                      <th>Datum</th>
                      <th>Tijd</th>
                      <th>Acties</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($activiteiten as $activiteit): ?>
                    <tr>
                      <td>
                        <?= $activiteit['naam'] ?>
                      </td>
                      <td>
                        <?= $activiteit['datum'] ?>
                      </td>
                      <td>
                        <?= $activiteit['tijd'] ?>
                      </td>
                      <td>
                        <div class="table-actions">
                          <button class="table-btn edit" type="button">Bewerken</button>
                          <button class="table-btn remove" type="button">Verwijderen</button>
                        </div>
                      </td>
                    </tr>
                      <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>
          <?php endif; ?>
        </section>
      </main>
    </div>
  </body>
</html>
