<?php
// profile.php
require_once __DIR__ . '/includes/functions.php';
requireLogin();

$user_id  = $_SESSION['user_id'];
$profile  = getProfile($user_id);
$skills   = getUserSkills($user_id);
$projects = getProjectsByUser($user_id);

include __DIR__ . '/includes/header.php';
?>

<h2>Mon profil</h2>

<?php if (!empty($profile['photo'])): ?>
  <div class="mb-3">
    <img
      src="uploads/<?= htmlspecialchars($profile['photo']) ?>"
      style="max-width:150px; height:auto;"
      alt="Photo de profil"
    >
  </div>
<?php endif; ?>

<p><strong>Nom :</strong>
   <?= htmlspecialchars($profile['name'] ?? 'Non renseigné') ?></p>
<p><strong>Bio :</strong>
   <?= nl2br(htmlspecialchars($profile['bio'] ?? 'Non renseignée')) ?></p>

<p>
  <a href="profile_edit.php" class="btn btn-primary">
    Modifier mon profil
  </a>
</p>

<hr>

<h3>Mes compétences</h3>
<?php if ($skills): ?>
  <?php foreach ($skills as $skill): ?>
    <div class="mb-2">
      <strong><?= htmlspecialchars($skill['skill']) ?></strong>
      <?php for ($i = 1; $i <= 5; $i++): ?>
        <?php if ($i <= $skill['level']): ?>
          <span class="text-warning">&#9733;</span>
        <?php else: ?>
          <span class="text-muted">&#9734;</span>
        <?php endif; ?>
      <?php endfor; ?>
    </div>
  <?php endforeach; ?>
<?php else: ?>
  <p>Aucune compétence renseignée.</p>
<?php endif; ?>

<hr>

<h3>Mes projets</h3>
<?php if ($projects): ?>
  <?php foreach ($projects as $project): ?>
    <div class="card mb-4">
      <?php if (!empty($project['image'])): ?>
        <img
          src="uploads/projects/<?= htmlspecialchars($project['image']) ?>"
          class="card-img-top"
          alt="Image du projet"
          style="max-width:150px; height:auto; display:block; margin:0 auto;"
        >
      <?php endif; ?>
      <div class="card-body">
        <h5 class="card-title"><?= htmlspecialchars($project['title']) ?></h5>
        <p class="card-text">
          <?= nl2br(htmlspecialchars($project['description'])) ?>
        </p>
        <?php if (!empty($project['link'])): ?>
          <a
            href="<?= htmlspecialchars($project['link']) ?>"
            class="btn btn-outline-primary"
            target="_blank"
          >Voir le projet</a>
        <?php endif; ?>
      </div>
    </div>
  <?php endforeach; ?>
<?php else: ?>
  <p>Aucun projet ajouté pour l’instant.</p>
<?php endif; ?>

<?php include __DIR__ . '/includes/footer.php'; ?>
