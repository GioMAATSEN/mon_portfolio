<?php
// admin/skill_types/add.php
require_once __DIR__ . '/../../includes/functions.php';
requireAdmin();

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name       = trim($_POST['name'] ?? '');
    $difficulty = intval($_POST['difficulty'] ?? 3);

    if ($name === '') {
        $errors[] = 'Le nom du type est obligatoire.';
    }
    if ($difficulty < 1 || $difficulty > 5) {
        $errors[] = 'La difficulté doit être entre 1 et 5.';
    }

    if (empty($errors)) {
        createSkillType($name, $difficulty);
        header('Location: index.php');
        exit;
    }
}

include __DIR__ . '/../../includes/header.php';
?>

<h2>Ajouter un type de compétence</h2>

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
           value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
  </div>
  <div class="mb-3">
    <label class="form-label">Difficulté (1 à 5)</label>
    <select name="difficulty" class="form-select" required>
      <?php for ($i = 1; $i <= 5; $i++): ?>
        <option value="<?= $i ?>"
          <?= ((int)($_POST['difficulty'] ?? 3) === $i) ? 'selected' : '' ?>>
          <?= $i ?>
        </option>
      <?php endfor; ?>
    </select>
  </div>
  <button class="btn btn-success">Enregistrer</button>
  <a href="index.php" class="btn btn-secondary">Annuler</a>
</form>

<?php include __DIR__ . '/../../includes/footer.php'; ?>
