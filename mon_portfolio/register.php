<?php
// register.php
require_once __DIR__ . '/includes/functions.php';
// plus de session_start() ici non plus

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $pass  = $_POST['password']         ?? '';
    $pass2 = $_POST['password_confirm'] ?? '';

    if (!$email) {
        $errors[] = 'Email invalide.';
    }
    if (strlen($pass) < 6) {
        $errors[] = 'Le mot de passe doit contenir au moins 6 caractères.';
    }
    if ($pass !== $pass2) {
        $errors[] = 'Les mots de passe ne correspondent pas.';
    }
    if (getUserByEmail($email)) {
        $errors[] = 'Cet email est déjà utilisé.';
    }

    if (empty($errors)) {
        createUser($email, $pass);
        header('Location: login.php?registered=1');
        exit;
    }
}

include __DIR__ . '/includes/header.php';
?>

<h2>Créer un compte</h2>

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
  <div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <input
      id="email"
      type="email"
      name="email"
      class="form-control"
      value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
      required
    >
  </div>

  <div class="mb-3">
    <label for="password" class="form-label">Mot de passe</label>
    <div class="input-group">
      <input
        id="password"
        type="password"
        name="password"
        class="form-control"
        required
      >
      <button
        class="btn btn-outline-secondary toggle-password"
        type="button"
        aria-label="Afficher/masquer le mot de passe"
      >
        <i class="fa-solid fa-eye"></i>
      </button>
    </div>
  </div>

  <div class="mb-3">
    <label for="password_confirm" class="form-label">Confirmer le mot de passe</label>
    <div class="input-group">
      <input
        id="password_confirm"
        type="password"
        name="password_confirm"
        class="form-control"
        required
      >
      <button
        class="btn btn-outline-secondary toggle-password"
        type="button"
        aria-label="Afficher/masquer le mot de passe"
      >
        <i class="fa-solid fa-eye"></i>
      </button>
    </div>
  </div>

  <button type="submit" class="btn btn-primary">S'inscrire</button>
</form>

<script>
  document.querySelectorAll('.toggle-password').forEach(function(btn) {
    btn.addEventListener('click', function() {
      const input = this.parentNode.querySelector('input');
      const isPwd = input.type === 'password';
      input.type = isPwd ? 'text' : 'password';
      const icon = this.querySelector('i');
      icon.classList.toggle('fa-eye');
      icon.classList.toggle('fa-eye-slash');
    });
  });
</script>

<?php include __DIR__ . '/includes/footer.php'; ?>
