<?php
// Affiche toutes les erreurs PHP pour le debug
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../includes/functions.php';
requireLogin();

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupère les champs texte
    $title       = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $link        = filter_input(INPUT_POST, 'link', FILTER_VALIDATE_URL) ?: null;

    // Validation
    if ($title === '') {
        $errors[] = 'Le titre est obligatoire.';
    }
    if ($description === '') {
        $errors[] = 'La description est obligatoire.';
    }

    // TRAITEMENT DE L'IMAGE
    $imageName = null;
    if (!empty($_FILES['image']['name'])) {
        $file    = $_FILES['image'];
        $allowed = ['image/jpeg','image/png','image/gif'];
        $maxSize = 2 * 1024 * 1024; // 2 Mo

        // Debug : affiche la variable $_FILES
        // var_dump($file);

        if ($file['error'] !== UPLOAD_ERR_OK) {
            $errors[] = 'Erreur upload : code '.$file['error'];
        } elseif (!in_array(mime_content_type($file['tmp_name']), $allowed, true)) {
            $errors[] = 'Format non autorisé, jpg/png/gif uniquement.';
        } elseif ($file['size'] > $maxSize) {
            $errors[] = 'Image trop lourde (>2 Mo).';
        } else {
            // Crée un nom unique
            $ext       = pathinfo($file['name'], PATHINFO_EXTENSION);
            $imageName = uniqid('proj_', true).'.'.$ext;
            $dest      = __DIR__ . '/../uploads/projects/' . $imageName;
            if (!move_uploaded_file($file['tmp_name'], $dest)) {
                $errors[] = 'Impossible de déplacer le fichier uploadé.';
            }
        }
    }

    if (empty($errors)) {
        // Appel à la fonction mise à jour en DB
        createProject($_SESSION['user_id'], $title, $description, $link, $imageName);
        header('Location: projects.php');
        exit;
    }
}

include __DIR__ . '/../includes/header.php';
?>

<h2>Ajouter un projet</h2>

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
    <input type="text" name="title" class="form-control"
           value="<?= htmlspecialchars($_POST['title'] ?? '') ?>">
  </div>
  <div class="mb-3">
    <label class="form-label">Description</label>
    <textarea name="description" class="form-control"><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
  </div>
  <div class="mb-3">
    <label class="form-label">Lien (URL)</label>
    <input type="url" name="link" class="form-control"
           value="<?= htmlspecialchars($_POST['link'] ?? '') ?>">
  </div>
  <div class="mb-3">
    <label class="form-label">Image (jpg, png, gif – max 2 Mo)</label>
    <input type="file" name="image" class="form-control" accept=".jpg,.jpeg,.png,.gif">
  </div>
  <button class="btn btn-success">Enregistrer</button>
  <a href="projects.php" class="btn btn-secondary">Annuler</a>
</form>

<?php include __DIR__ . '/../includes/footer.php'; ?>
