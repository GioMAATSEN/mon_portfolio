<?php
// admin/skill_types/edit.php
require_once __DIR__ . '/../../includes/functions.php';
requireAdmin();

$id   = intval($_GET['id'] ?? 0);
$type = getSkillType($id);
if (!$type) {
    header('Location: index.php');
    exit;
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name       = trim($_POST['name'] ?? '');
    $difficulty = intval($_POST['difficulty'] ?? $type['difficulty']);

    if ($name === '') {
        $errors[] = 'Le nom du type est obligatoire.';
    }
    if ($difficulty < 1 || $difficulty > 5) {
        $errors[] = 'La difficulté doit être entre 1 et 5.';
    }

    if (empty($errors)) {
        updateSkillType($id, $name, $difficulty);
        header('Location: index.php');
        exit;
    }
}

include __DIR__ . '/../../includes/header.php';
?>

<h2>Modifier un type de compétence</h2>

<?php if ($errors): ?>
  <div class="alert alert-danger">
    <ul>
      <?php foreach ($errors as $e): ?>
        <li><?= htmlspecialchars($e) ?></li>
      <?php endforeach; ?>
    </ul>
  </div>
<?php endif; ?>

<form method="post" novalidate>
  <div class="mb-3">
    <label class="form-label">Nom du type</label>
    <input type="text" name="name" class="form-control" required
           value="<?= htmlspecialchars($_POST['name'] ?? $type['name']) ?>">
  </div>
  <div class="mb-3">
    <label class="form-label">Difficulté (1 à 5)</label>
    <select name="difficulty" class="form-select" required>
      <?php for ($i = 1; $i <= 5; $i++): ?>
        <option value="<?= $i ?>"
          <?= ((int)($_POST['difficulty'] ?? $type['difficulty']) === $i) ? 'selected' : '' ?>>
          <?= $i ?>
        </option>
      <?php endfor; ?>
    </select>
  </div>
  <button class="btn btn-primary">Mettre à jour</button>
  <a href="index.php" class="btn btn-secondary">Annuler</a>
</form>

<?php include __DIR__ . '/../../includes/footer.php'; ?>
