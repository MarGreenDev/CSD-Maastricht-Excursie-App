<?php
session_start();
include_once 'includes/connection.php';

$message = '';

if (isset($_POST["register"])) {
    $registerName = trim($_POST["registerName"]);
    $registerEmail = $_POST["registerEmail"];
    $registerPassword = $_POST["registerPassword"];

    if (empty($registerName) || empty($registerEmail) || empty($registerPassword)) {
        $message = "Vul alle velden in.";
    } else {
        $checkSql = "SELECT id FROM users WHERE naam = ? OR email = ?";
        $checkStmt = $conn->prepare($checkSql);
        $checkStmt->bind_param("ss", $registerName, $registerEmail);
        $checkStmt->execute();
        $result = $checkStmt->get_result();

        if ($result->num_rows > 0) {
            $message = "Gebruikersnaam of email bestaat al.";
        } else {
            $hashedPassword = password_hash($registerPassword, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (naam, email, wachtwoord) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $registerName, $registerEmail, $hashedPassword);

            if (!$stmt) {
                die("Prepare error: " . $conn->error);
            }

            if ($stmt->execute()) {
                $_SESSION["naam"] = $registerName;
                header("Location: index.php");
                exit();
            } else {
                die("Execute error: " . $stmt->error);
            }

            $stmt->close();
        }
        $checkStmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Registreren • Maastricht Excursie App</title>
    <link rel="stylesheet" href="assets/css/style.css" />
  </head>
  <body>
    <div class="page-shell">
      <header class="topbar">
        <a class="brand" href="index.php">Maastricht<span>Trip</span></a>
        <button class="menu-toggle" type="button" aria-expanded="false" aria-label="Menu openen">
          <span></span>
          <span></span>
          <span></span>
        </button>
        <nav class="topnav" id="site-nav">
          <a href="index.php#activities">Activiteiten</a>
          <a href="login.php">Inloggen</a>
          <?php if (!empty($_SESSION["naam"])): ?>
            <span class="user-name"><?= htmlspecialchars($_SESSION["naam"]) ?></span>
            <a class="logout-btn" href="logout.php">Uitloggen</a>
          <?php endif; ?>
        </nav>
      </header>

      <main class="auth-page">
        <section class="auth-hero">
          <p class="eyebrow">Nieuw bij Maastricht</p>
          <h1>Maak een account voor je volgende avontuur.</h1>
          <p class="hero-text">Sla je favoriete activiteiten op en plan je dagtripjes op een makkelijke manier.</p>
        </section>

        <section class="auth-card auth-stack">
          <h2>Registreren</h2>
          <?php if (!empty($message)): ?>
            <p class="message"><?= htmlspecialchars($message) ?></p>
          <?php endif; ?>
          <form class="auth-form" action="register.php" method="post">
            <label for="registerName">Volledige naam</label>
            <input name="registerName" id="registerName" type="text" placeholder="Jouw naam" />

            <label for="registerEmail">Email</label>
            <input name="registerEmail" id="registerEmail" type="email" placeholder="you@example.com" />

            <label for="registerPassword">Wachtwoord</label>
            <input name="registerPassword" id="registerPassword" type="password" placeholder="Maak een wachtwoord" />

            <button name="register" class="btn btn-primary full-width" type="submit">Registreren</button>
          </form>
          <p class="alt-link">Heb je al een account? <a href="login.php">Log in</a></p>
        </section>
      </main>

      <footer class="footer">
        <p>Maastricht Excursie App • Gemaakt voor nieuwsgierige studenten</p>
      </footer>
    </div>

    <script>
      const menuToggle = document.querySelector('.menu-toggle');
      const siteNav = document.getElementById('site-nav');

      if (menuToggle && siteNav) {
        menuToggle.addEventListener('click', () => {
          const isOpen = siteNav.classList.toggle('open');
          menuToggle.setAttribute('aria-expanded', String(isOpen));
        });
      }
    </script>
  </body>
</html>
