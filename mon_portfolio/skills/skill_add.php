<?php
// skills/skill_add.php

require_once __DIR__ . '/../includes/functions.php';
requireLogin();

// Noms textuels pour chaque niveau
$levelNames = [
    1 => 'Débutant',
    2 => 'Notions',
    3 => 'Intermédiaire',
    4 => 'Confirmé',
    5 => 'Expert',
];

$types  = getSkillTypes();  // liste des skill_types (avec difficulty)
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type_id = intval($_POST['skill_type_id'] ?? 0);
    $level   = intval($_POST['level'] ?? 0);

    if ($type_id < 1) {
        $errors[] = 'Choisissez une compétence.';
    }
    if ($level < 1 || $level > 5) {
        $errors[] = 'Donnez un niveau entre 1 et 5 via les étoiles.';
    }

    if (empty($errors)) {
        createUserSkill($_SESSION['user_id'], $type_id, $level);
        header('Location: skills.php');
        exit;
    }
}

include __DIR__ . '/../includes/header.php';
?>

<h2>Ajouter une compétence</h2>

<?php if (!empty($errors)): ?>
  <div class="alert alert-danger">
    <ul>
      <?php foreach ($errors as $e): ?>
        <li><?= htmlspecialchars($e) ?></li>
      <?php endforeach; ?>
    </ul>
  </div>
<?php endif; ?>

<form method="post" novalidate>
  <!-- Sélection du type -->
  <div class="mb-3">
    <label class="form-label">Compétence</label>
    <select name="skill_type_id" class="form-select" required>
      <option value="">— Choisissez —</option>
      <?php foreach ($types as $t): ?>
        <option value="<?= $t['id'] ?>"
          <?= (($_POST['skill_type_id'] ?? '') == $t['id']) ? 'selected' : '' ?>>
          <?= htmlspecialchars($t['name']) ?> (Diff. <?= $t['difficulty'] ?>/5)
        </option>
      <?php endforeach; ?>
    </select>
  </div>

  <!-- Widget étoiles pour le niveau avec tooltip -->
  <div class="mb-3">
    <label class="form-label">Niveau (cliquez sur les étoiles)</label>
    <div class="star-rating">
      <?php for ($i = 5; $i >= 1; $i--): ?>
        <input
          type="radio"
          id="star-add-<?= $i ?>"
          name="level"
          value="<?= $i ?>"
          <?= ((int)($_POST['level'] ?? 0) === $i) ? 'checked' : '' ?>
        >
        <label
          for="star-add-<?= $i ?>"
          title="<?= htmlspecialchars($levelNames[$i]) ?>"
        >★</label>
      <?php endfor; ?>
    </div>
  </div>

  <button class="btn btn-success">Enregistrer</button>
  <a href="skills.php" class="btn btn-secondary">Annuler</a>
</form>

<?php include __DIR__ . '/../includes/footer.php'; ?>
