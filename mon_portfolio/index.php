<?php
// index.php
require_once __DIR__ . '/includes/functions.php';
include __DIR__ . '/includes/header.php';
?>

<div class="hero">
  <h1>Bienvenue sur votre portfolio</h1>
  <p class="lead">Créez, gérez et exposez vos projets et compétences en ligne.</p>
  <?php if (!isLoggedIn()): ?>
    <a href="/register.php" class="btn btn-primary btn-lg me-2">S'inscrire</a>
    <a href="/login.php" class="btn btn-outline-primary btn-lg">Se connecter</a>
  <?php else: ?>
    <a href="/projects/projects.php" class="btn btn-success btn-lg me-2">Mes projets</a>
    <a href="/skills/skills.php" class="btn btn-info btn-lg">Compétences</a>
  <?php endif; ?>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
