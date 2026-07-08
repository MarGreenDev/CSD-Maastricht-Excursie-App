<?php
session_start();
include_once 'includes/connection.php';
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Maastricht Excursie App</title>
    <meta
      name="description"
      content="Een moderne, studentvriendelijke gids voor de leukste activiteiten in Maastricht."
    />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
      rel="stylesheet"
    />
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
          <a href="index.php#auth">Doe mee</a>
          <?php if (!empty($_SESSION["naam"])): ?>
            <span class="user-name"><?= htmlspecialchars($_SESSION["naam"]) ?></span>
            <a class="logout-btn" href="logout.php">Uitloggen</a>
          <?php endif; ?>
        </nav>
      </header>

      <main>
        <section class="hero">
          <div class="hero-copy">
            <p class="eyebrow">Studentenescape in het hart van Limburg</p>
            <h1>Ontdek Maastricht op een manier die zowel makkelijk als inspirerend voelt.</h1>
            <p class="hero-text">
              Van verborgen pleintjes tot uitzicht op de rivier: deze app laat vijf onvergetelijke plekken
              zien die elke excursie bijzonder maken.
            </p>
            <div class="hero-actions">
              <a class="btn btn-primary" href="#auth">Begin met ontdekken</a>
              <a class="btn btn-secondary" href="#activities">Bekijk activiteiten</a>
            </div>
          </div>
          <section id="auth" class="auth-section">
          <div class="auth-card">
            <p class="eyebrow">Account</p>
            <h2>Blijf onderweg inloggen</h2>
            <p class="hero-text">Log in of maak een account om je favoriete plekken te bewaren.</p>
            <div class="hero-actions">
              <a class="btn btn-primary" href="login.php">Inloggen</a>
              <a class="btn btn-secondary" href="register.php">Registreren</a>
            </div>
          </div>
        </section>

    </section>
    <div class="hero-card">
      <h2>Waarom studenten het leuk vinden</h2>
      <ul>
        <li>Makkelijk om onderweg te bekijken</li>
        <li>Uitgekozen plekken met lokale sfeer</li>
        <li>Perfect voor dagtripjes en groepsplannen</li>
      </ul>
    </div>

        <section class="highlights" aria-label="Trip highlights">
          <article>
            <strong>5</strong>
            <span>Topkeuzes</span>
          </article>
          <article>
            <strong>100%</strong>
            <span>Studentvriendelijk</span>
          </article>
          <article>
            <strong>24/7</strong>
            <span>Altijd plannen</span>
          </article>
        </section>

        <section id="activities" class="activities-section">
          <div class="section-heading">
            <p class="eyebrow">Topactiviteiten</p>
            <h2>Vijf ervaringen die je reisplanner verdienen</h2>
          </div>

          <div class="activity-grid">
            <article class="activity-card">
              <div class="activity-icon">🏛️</div>
              <h3>Vrijthof en wandeling door de oude binnenstad</h3>
              <p>Loop door historische pleinen, gezellige cafés en levendige straatjes met een echte lokale sfeer.</p>
            </article>

            <article class="activity-card">
              <div class="activity-icon">🕳️</div>
              <h3>Grotten van St. Pietersberg</h3>
              <p>Verken ondergrondse paden en indrukwekkende rotsformaties net buiten het centrum.</p>
            </article>

            <article class="activity-card">
              <div class="activity-icon">🚤</div>
              <h3>Boottocht op de Maas</h3>
              <p>Geniet van een ontspannen tocht over het water en prachtige uitzichten op Maastricht.</p>
            </article>

            <article class="activity-card">
              <div class="activity-icon">📚</div>
              <h3>Ontdekking van de studentenwijk</h3>
              <p>Loop door inspirerende architectuur, studentevenementen en verborgen hofjes.</p>
            </article>

            <article class="activity-card">
              <div class="activity-icon">🌲</div>
              <h3>Uitzichtspunt Hoge Fronten</h3>
              <p>Geniet van een prachtig panorama en een rustige natuurpauze tijdens een korte klim.</p>
            </article>
          </div>
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
