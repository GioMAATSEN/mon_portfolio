<?php
// view_user.php
require_once __DIR__ . '/includes/functions.php';
requireLogin();

$id = intval($_GET['id'] ?? 0);
if ($id < 1) {
    header('Location: directory.php');
    exit;
}

$profile  = getProfile($id);
$projects = getProjectsByUser($id);
$skills   = getUserSkills($id);
$name     = trim($profile['name'] ?? '') ?: "Utilisateur #{$id}";

include __DIR__ . '/includes/header.php';
?>

<h2>Portfolio de <?= htmlspecialchars($name) ?></h2>

<?php if (!empty($profile['photo'])): ?>
  <img
    src="/uploads/<?= htmlspecialchars($profile['photo']) ?>"
    alt="Photo de <?= htmlspecialchars($name) ?>"
    class="img-thumbnail mb-3"
    style="max-width:150px;"
  >
<?php endif; ?>

<?php if (!empty($profile['bio'])): ?>
  <p><?= nl2br(htmlspecialchars($profile['bio'])) ?></p>
<?php endif; ?>

<h3 class="mt-4">Compétences</h3>
<?php if (empty($skills)): ?>
  <p>Aucune compétence renseignée.</p>
<?php else: ?>
  <ul class="list-group mb-4">
    <?php foreach ($skills as $s): ?>
      <li class="list-group-item d-flex justify-content-between align-items-center">
        <?= htmlspecialchars($s['skill']) ?>
        <div class="star-display" aria-label="Niveau <?= $s['level'] ?>/5">
          <?php for ($i = 1; $i <= 5; $i++): ?>
            <span class="<?= $i <= $s['level'] ? 'filled' : '' ?>">★</span>
          <?php endfor; ?>
        </div>
      </li>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>

<h3>Projets</h3>
<?php if (empty($projects)): ?>
  <p>Aucun projet pour le moment.</p>
<?php else: ?>
  <div class="row row-cols-1 row-cols-md-2 g-4">
    <?php foreach ($projects as $p): ?>
      <div class="col">
        <div class="card h-100">
          <?php if (!empty($p['image'])): ?>
            <img
              src="/uploads/projects/<?= htmlspecialchars($p['image']) ?>"
              class="card-img-top"
              alt="<?= htmlspecialchars($p['title']) ?>"
              style="max-width:150px; max-height:150px; object-fit:cover; margin:0.75rem auto 0;"
            >
          <?php endif; ?>
          <div class="card-body text-center">
            <h5 class="card-title"><?= htmlspecialchars($p['title']) ?></h5>
            <p class="card-text"><?= nl2br(htmlspecialchars($p['description'])) ?></p>
          </div>
          <div class="card-footer">
            <?php if (!empty($p['link'])): ?>
              <a href="<?= htmlspecialchars($p['link']) ?>"
                 target="_blank"
                 class="btn btn-outline-primary btn-sm">
                Voir en ligne
              </a>
            <?php endif; ?>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>

<p class="mt-4">
  <a href="directory.php" class="btn btn-secondary">
    <i class="bi bi-arrow-left-circle me-1"></i>Retour à l'annuaire
  </a>
</p>

<?php include __DIR__ . '/includes/footer.php'; ?>
