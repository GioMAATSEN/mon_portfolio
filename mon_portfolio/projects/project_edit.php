<?php
// projects/project_edit.php

// Affiche les erreurs pour aider au debug
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../includes/functions.php';
requireLogin();

// 1) Récupérer l’ID et le projet
$id      = intval($_GET['id'] ?? 0);
$project = getProject($id);
if (!$project || $project['user_id'] !== $_SESSION['user_id']) {
    // Projet introuvable ou accès non autorisé
    header('Location: projects.php');
    exit;
}

$errors   = [];
// Pré‐remplissage des champs : POST prend le pas, sinon on utilise les valeurs existantes
$title       = $_POST['title']       ?? $project['title'];
$description = $_POST['description'] ?? $project['description'];
$link        = $_POST['link']        ?? $project['link'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 2) Nettoyage / validation
    $title       = trim($title);
    $description = trim($description);
    $link        = trim($link);
    $link        = $link !== '' ? filter_var($link, FILTER_VALIDATE_URL) : null;

    if ($title === '') {
        $errors[] = 'Le titre est obligatoire.';
    }
    if ($description === '') {
        $errors[] = 'La description est obligatoire.';
    }

    // 3) Traitement de l’upload d’image (optionnel)
    $newImage = null;
    if (!empty($_FILES['image']['name'])) {
        $file    = $_FILES['image'];
        $allowed = ['image/jpeg','image/png','image/gif'];
        $maxSize = 2 * 1024 * 1024; // 2 Mo

        if ($file['error'] !== UPLOAD_ERR_OK) {
            $errors[] = 'Erreur durant l’upload (code '.$file['error'].').';
        } elseif (!in_array(mime_content_type($file['tmp_name']), $allowed, true)) {
            $errors[] = 'Format non autorisé (jpg, png, gif uniquement).';
        } elseif ($file['size'] > $maxSize) {
            $errors[] = 'Image trop lourde (>2 Mo).';
        } else {
            $ext      = pathinfo($file['name'], PATHINFO_EXTENSION);
            $newImage = uniqid('proj_', true).'.'.$ext;
            $dest     = __DIR__ . '/../uploads/projects/' . $newImage;
            if (!move_uploaded_file($file['tmp_name'], $dest)) {
                $errors[] = 'Impossible de déplacer l’image uploadée.';
                $newImage = null;
            } else {
                // Supprime l’ancienne image si existante
                if ($project['image']) {
                    @unlink(__DIR__ . '/../uploads/projects/' . $project['image']);
                }
            }
        }
    }

    // 4) Si tout est OK, on met à jour en base
    if (empty($errors)) {
        updateProject(
            $id,
            $title,
            $description,
            $link,
            $newImage // null si pas de nouvelle image
        );
        header('Location: projects.php');
        exit;
    }
}

// 5) Affichage du formulaire
include __DIR__ . '/../includes/header.php';
?>

<h2>Modifier le projet</h2>

<?php if ($errors): ?>
  <div class="alert alert-danger">
    <ul>
      <?php foreach ($errors as $e): ?>
        <li><?= htmlspecialchars($e) ?></li>
      <?php endforeach; ?>
    </ul>
  </div>
<?php endif; ?>

<form method="post" enctype="multipart/form-data">
  <div class="mb-3">
    <label class="form-label">Titre</label>
    <input
      type="text"
      name="title"
      class="form-control"
      value="<?= htmlspecialchars($title) ?>"
      required
    >
  </div>

  <div class="mb-3">
    <label class="form-label">Description</label>
    <textarea
      name="description"
      class="form-control"
      required
    ><?= htmlspecialchars($description) ?></textarea>
  </div>

  <div class="mb-3">
    <label class="form-label">Lien (URL)</label>
    <input
      type="url"
      name="link"
      class="form-control"
      value="<?= htmlspecialchars($link) ?>"
    >
  </div>

  <?php if (!empty($project['image'])): ?>
    <div class="mb-3">
      <label class="form-label">Image actuelle</label><br>
      <img
        src="/uploads/projects/<?= htmlspecialchars($project['image']) ?>"
        alt="Image du projet"
        class="img-thumbnail mb-2"
        style="max-width:200px;"
      >
    </div>
  <?php endif; ?>

  <div class="mb-3">
    <label class="form-label">Remplacer l’image (jpg, png, gif – max 2 Mo)</label>
    <input
      type="file"
      name="image"
      class="form-control"
      accept=".jpg,.jpeg,.png,.gif"
    >
  </div>

  <button class="btn btn-primary">Mettre à jour</button>
  <a href="projects.php" class="btn btn-secondary">Annuler</a>
</form>

<?php include __DIR__ . '/../includes/footer.php'; ?>
