<?php
session_start();
include_once '../includes/connection.php';

$sql = "SELECT * FROM activiteiten";
$activiteiten = $conn->query($sql);

$userSql = "SELECT id, naam, email, is_admin FROM users ORDER BY naam";
$users = $conn->query($userSql);

$currentUserIsAdmin = false;
if (isset($_SESSION['user_id'])) {
    $currentUserId = (int) $_SESSION['user_id'];
    $stmt = $conn->prepare('SELECT is_admin FROM users WHERE id = ? LIMIT 1');
    if ($stmt) {
        $stmt->bind_param('i', $currentUserId);
        $stmt->execute();
        $stmt->bind_result($isAdmin);
        if ($stmt->fetch()) {
            $currentUserIsAdmin = intval($isAdmin) === 1;
        }
        $stmt->close();
    }
}
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
          <?php elseif ((int)$_SESSION["user_id"] !== 1 && !$currentUserIsAdmin): ?>
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
                        <?= htmlspecialchars($activiteit['tijd']) ?>
                      </td>
                      <td>
                        <div class="table-actions">
                          <form action="../verwijder-activiteit.php" method="post" onsubmit="return confirm('Weet je zeker dat je deze activiteit wilt verwijderen?');">
                            <input type="hidden" name="activiteit_id" value="<?= htmlspecialchars($activiteit['id']) ?>" />
                            <button class="table-btn remove" type="submit">Verwijderen</button>
                          </form>
                        </div>
                      </td>
                    </tr>
                      <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>

            <div class="table-section">
              <div class="table-heading">
                <h2>Gebruikers</h2>
                <p>Alle geregistreerde gebruikers in de database.</p>
              </div>

              <label class="admin-field">
                <span>Zoeken</span>
                <input id="userSearch" type="search" placeholder="Zoek op naam of email" />
              </label>

              <div class="table-wrap">
                <table class="activity-table" id="userTable">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Naam</th>
                      <th>Email</th>
                      <th>Is admin</th>
                      <th>Acties</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($users as $user): ?>
                    <tr>
                      <td><?= htmlspecialchars($user['id']) ?></td>
                      <td><?= htmlspecialchars($user['naam']) ?></td>
                      <td><?= htmlspecialchars($user['email']) ?></td>
                      <td><?= intval($user['is_admin']) === 1 ? 'Ja' : 'Nee' ?></td>
                      <td>
                        <div class="table-actions">
                          <?php if (intval($user['is_admin']) === 1): ?>
                            <button class="table-btn edit" type="button" disabled>Admin</button>
                          <?php else: ?>
                            <form action="promote-user.php" method="post">
                              <input type="hidden" name="user_id" value="<?= htmlspecialchars($user['id']) ?>" />
                              <button class="table-btn edit" type="submit">Maak admin</button>
                            </form>
                          <?php endif; ?>
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

    <script>
      const userSearch = document.getElementById('userSearch');
      const userTable = document.getElementById('userTable');

      if (userSearch && userTable) {
        userSearch.addEventListener('input', () => {
          const term = userSearch.value.toLowerCase();
          userTable.querySelectorAll('tbody tr').forEach((row) => {
            const rowText = row.textContent.toLowerCase();
            row.style.display = rowText.includes(term) ? '' : 'none';
          });
        });
      }
    </script>
  </body>
</html>
