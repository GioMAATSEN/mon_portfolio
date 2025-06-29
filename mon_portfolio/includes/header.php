<?php
// includes/header.php
require_once __DIR__ . '/functions.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Mon Portfolio</title>

  <!-- 1) Bootstrap CSS -->
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
    rel="stylesheet"
  >

  <!-- 2) Bootstrap Icons -->
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"
    rel="stylesheet"
  >

  <link href="/assets/css/style.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container">
    <a class="navbar-brand" href="/index.php">
      <i class="bi bi-journal-richtext me-1"></i>
      Portfolio
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navBar" aria-controls="navBar" aria-expanded="false"
            aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navBar">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <?php if (isLoggedIn()): ?>
          <li class="nav-item">
            <a class="nav-link" href="/projects/projects.php">
              <i class="bi bi-folder2-open me-1"></i>
              Mes projets
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/skills/skills.php">
              <i class="bi bi-stars me-1"></i>
              Compétences
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/profile.php">
              <i class="bi bi-person-circle me-1"></i>
              Profil
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/directory.php">
              <i class="bi bi-people me-1"></i>
              Annuaire
            </a>
          </li>
          <?php if (isAdmin()): ?>
            <li class="nav-item">
              <a class="nav-link" href="/admin/skill_types/index.php">
                <i class="bi bi-gear-fill me-1"></i>
                Admin : types
              </a>
            </li>
          <?php endif; ?>
        <?php endif; ?>
      </ul>
      <div class="d-flex">
        <?php if (isLoggedIn()): ?>
          <a href="/logout.php" class="btn btn-outline-danger">Se déconnecter</a>
        <?php else: ?>
          <a href="/register.php" class="btn btn-outline-primary me-2">S'inscrire</a>
          <a href="/login.php" class="btn btn-primary">Se connecter</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>


<div class="container mt-4">
