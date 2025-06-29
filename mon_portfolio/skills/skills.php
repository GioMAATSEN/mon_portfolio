<?php
// skills/skills.php

require_once __DIR__ . '/../includes/functions.php';
requireLogin();

$user_id = $_SESSION['user_id'];
$skills  = getUserSkills($user_id);

include __DIR__ . '/../includes/header.php';
?>

<h2 class="mb-4">Mes compétences</h2>
<a href="skill_add.php" class="btn btn-success mb-4">Ajouter une compétence</a>

<?php if (empty($skills)): ?>
  <p>Aucune compétence pour le moment.</p>
<?php else: ?>
  <ul class="list-group">
    <?php foreach ($skills as $s): ?>
      <li class="list-group-item d-flex justify-content-between align-items-center">
        <div>
          <strong><?= htmlspecialchars($s['skill']) ?></strong>
        </div>
        <div class="star-display" aria-label="Niveau <?= $s['level'] ?> sur 5">
          <?php for ($i = 1; $i <= 5; $i++): ?>
            <span class="<?= $i <= $s['level'] ? 'filled' : '' ?>">★</span>
          <?php endfor; ?>
        </div>
      </li>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>

<?php include __DIR__ . '/../includes/footer.php'; ?>
