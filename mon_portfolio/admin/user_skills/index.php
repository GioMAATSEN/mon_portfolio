<?php
// admin/skill_types/index.php
require_once __DIR__ . '/../../includes/functions.php';
requireAdmin();

$types = getSkillTypes();

include __DIR__ . '/../../includes/header.php';
?>

<h2>Admin : Types de compétences</h2>
<a href="add.php" class="btn btn-success mb-3">Ajouter un type</a>

<?php if (empty($types)): ?>
  <p>Aucun type de compétence défini.</p>
<?php else: ?>
  <ul class="list-group">
    <?php foreach ($types as $t): ?>
      <li class="list-group-item d-flex justify-content-between align-items-center">
        <div>
          <strong><?= htmlspecialchars($t['name']) ?></strong>
          <span class="badge bg-secondary ms-2">Diff. <?= $t['difficulty'] ?>/5</span>
        </div>
        <div>
          <a href="edit.php?id=<?= $t['id'] ?>" class="btn btn-sm btn-primary">Modifier</a>
          <a href="delete.php?id=<?= $t['id'] ?>"
             onclick="return confirm('Supprimer ce type ?')"
             class="btn btn-sm btn-danger">Supprimer</a>
        </div>
      </li>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>

<?php include __DIR__ . '/../../includes/footer.php'; ?>
