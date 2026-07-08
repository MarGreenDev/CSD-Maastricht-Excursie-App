<?php
session_start();
include_once "includes/connection.php";

$message = '';

if (isset($_POST["login"])) {
    $email = trim($_POST["loginEmail"]);
    $password = $_POST["loginPassword"];

    if (empty($email) || empty($password)) {
        $message = "Vul alle velden in.";
    } else {
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['wachtwoord'])) {
                $_SESSION["user_id"] = $user["id"];
                $_SESSION["user_email"] = $user["email"];
                $_SESSION["naam"] = $user["naam"];

                header("location: index.php");
                exit();
            } else {
                $message = "Wachtwoord is onjuist.";
            }
        } else {
            $message = "Gebruiker niet gevonden.";
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
    <title>Inloggen • Maastricht Excursie App</title>
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
          <a href="register.php">Registreren</a>
          <?php if (!empty($_SESSION["naam"])): ?>
            <span class="user-name"><?= htmlspecialchars($_SESSION["naam"]) ?></span>
            <a class="logout-btn" href="logout.php">Uitloggen</a>
          <?php endif; ?>
        </nav>
      </header>

      <main class="auth-page">
        <section class="auth-hero">
          <p class="eyebrow">Welkom terug</p>
          <h1>Log in op je persoonlijke reisplanner.</h1>
          <p class="hero-text">Bekijk je favorieten en plan je volgende uitstap in Maastricht.</p>
        </section>

        <section class="auth-card auth-stack">
          <h2>Inloggen</h2>
          <?php if (!empty($message)): ?>
            <p class="message"><?= htmlspecialchars($message) ?></p>
          <?php endif; ?>
          <form class="auth-form" action="login.php" method="post">
            <label for="loginEmail">Email</label>
            <input name="loginEmail" id="loginEmail" type="email" placeholder="student@maastricht.nl" />

            <label for="loginPassword">Wachtwoord</label>
            <input name="loginPassword" id="loginPassword" type="password" placeholder="••••••••" />

            <button name="login" class="btn btn-primary full-width" type="submit">Inloggen</button>
          </form>
          <p class="alt-link">Nog geen account? <a href="register.php">Maak er een aan</a></p>
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
