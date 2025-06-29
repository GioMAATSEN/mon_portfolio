<?php
// profile_edit.php
require_once __DIR__ . '/includes/functions.php';
requireLogin();

$user_id = $_SESSION['user_id'];
$profile = getProfile($user_id);
$errors  = [];

// Valeurs par défaut pour le formulaire
$name  = $profile['name'] ?? '';
$bio   = $profile['bio'] ?? '';
$photo = $profile['photo'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $bio  = trim($_POST['bio']  ?? '');

    // Gestion de l’upload d’image
    if (!empty($_FILES['photo']['name']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $tmp = $_FILES['photo']['tmp_name'];
        $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
        $allowed = ['jpg','jpeg','png','gif'];
        if (!in_array(strtolower($ext), $allowed, true)) {
            $errors[] = 'Format d’image non supporté (jpg, png, gif).';
        } else {
            // Crée le dossier uploads si nécessaire
            $uploadDir = __DIR__ . '/uploads';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $filename = 'user_'.$user_id.'_'.time().'.'.$ext;
            move_uploaded_file($tmp, "$uploadDir/$filename");
            $photo = $filename;
        }
    }

    // Validation des champs
    if ($name === '') {
        $errors[] = 'Le nom est obligatoire.';
    }
    if ($bio === '') {
        $errors[] = 'La bio est obligatoire.';
    }

    // Enregistrement si pas d’erreur
    if (empty($errors)) {
        saveProfile($user_id, $name, $bio, $photo);
        header('Location: profile.php');
        exit;
    }
}

include __DIR__ . '/includes/header.php';
?>

<h2>Modifier mon profil</h2>

<?php if ($errors): ?>
  <div class="alert alert-danger">
    <ul>
      <?php foreach ($errors as $e): ?>
        <li><?= htmlspecialchars($e) ?></li>
      <?php endforeach; ?>
    </ul>
  </div>
<?php endif; ?>

<form method="post" enctype="multipart/form-data" novalidate>
  <div class="mb-3">
    <label class="form-label">Nom</label>
    <input type="text" name="name" class="form-control" required
           value="<?= htmlspecialchars($name) ?>">
  </div>

  <div class="mb-3">
    <label class="form-label">Bio</label>
    <textarea name="bio" class="form-control" rows="5" required>
      <?= htmlspecialchars($bio) ?>
    </textarea>
  </div>

  <div class="mb-3">
    <label class="form-label">Photo de profil</label>
    <?php if ($photo): ?>
      <div class="mb-2">
        <img src="uploads/<?= htmlspecialchars($photo) ?>"
             style="max-width:100px;" alt="Photo actuelle">
      </div>
    <?php endif; ?>
    <input type="file" name="photo" accept="image/*" class="form-control">
  </div>

  <button type="submit" class="btn btn-success">Enregistrer</button>
  <a href="profile.php" class="btn btn-secondary">Annuler</a>
</form>

<?php include __DIR__ . '/includes/footer.php'; ?>
