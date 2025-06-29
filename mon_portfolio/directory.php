<?php
// directory.php
require_once __DIR__ . '/includes/functions.php';
requireLogin();

// Récupère tous les users
$users = getAllUsers();

// Récupère la requête de recherche (GET)
$q = trim($_GET['q'] ?? '');

// Si une recherche est en cours, filtre le tableau
if ($q !== '') {
    $users = array_filter($users, function($u) use ($q) {
        return stripos($u['name'] . ' ' . $u['email'], $q) !== false;
    });
}

include __DIR__ . '/includes/header.php';
?>

<h2>Annuaire des portfolios</h2>

<!-- Barre de recherche -->
<form method="get" class="mb-4">
  <div class="input-group">
    <input
      type="search"
      name="q"
      class="form-control"
      placeholder="Rechercher un utilisateur par nom ou email…"
      value="<?= htmlspecialchars($q) ?>"
    >
    <button class="btn btn-outline-secondary" type="submit">Rechercher</button>
  </div>
</form>

<?php if (empty($users)): ?>
  <p>Aucun utilisateur trouvé<?php if ($q !== '') echo " pour « " . htmlspecialchars($q) . " »"; ?>.</p>
<?php else: ?>
  <ul class="list-group">
    <?php foreach ($users as $u): ?>
      <li class="list-group-item d-flex justify-content-between align-items-center">
        <span>
          <?= $u['name'] !== ''
               ? htmlspecialchars($u['name']) . " (" . htmlspecialchars($u['email']) . ")"
               : htmlspecialchars($u['email']) ?>
        </span>
        <a href="/view_user.php?id=<?= $u['id'] ?>"
           class="btn btn-sm btn-outline-primary">
          Voir le portfolio
        </a>
      </li>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>

<?php include __DIR__ . '/includes/footer.php'; ?>
