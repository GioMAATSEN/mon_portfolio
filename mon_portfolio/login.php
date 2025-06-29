<?php
// login.php
require_once __DIR__ . '/includes/functions.php';
// plus de session_start() ici, il est déjà dans functions.php

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $pass  = $_POST['password'] ?? '';

    if (!$email) {
        $errors[] = 'Email invalide.';
    }

    if (empty($errors)) {
        $user = getUserByEmail($email);
        if (!$user || !password_verify($pass, $user['password'])) {
            $errors[] = 'Email ou mot de passe incorrect.';
        } else {
            $_SESSION['user_id'] = $user['id'];
            header('Location: index.php');
            exit;
        }
    }
}

include __DIR__ . '/includes/header.php';
?>

<h2>Connexion</h2>

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

  <button type="submit" class="btn btn-primary">Se connecter</button>
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
