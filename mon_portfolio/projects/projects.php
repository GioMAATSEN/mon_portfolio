<?php
// projects/projects.php
require_once __DIR__ . '/../includes/functions.php';
requireLogin();

// Récupère les projets de l’utilisateur
$projects = getProjectsByUser($_SESSION['user_id']);

include __DIR__ . '/../includes/header.php';
?>

<h2 class="mb-4">Mes projets</h2>
<a href="project_add.php" class="btn btn-success mb-4">
  <i class="bi bi-plus-lg me-1"></i>Ajouter un projet
</a>

<?php if (empty($projects)): ?>
  <p>Aucun projet pour le moment.</p>
<?php else: ?>
  <div class="row row-cols-1 row-cols-md-2 g-4">
    <?php foreach ($projects as $p): ?>
      <div class="col">
        <div class="card h-100">
          <?php if (!empty($p['image'])): ?>
            <img
              src="/uploads/projects/<?= htmlspecialchars($p['image']) ?>"
              alt="<?= htmlspecialchars($p['title']) ?>"
              class="img-fluid"
              style="
                max-width:150px;
                max-height:150px;
                object-fit:cover;
                display:block;
                margin: 0.75rem auto 0;
              "
            >
          <?php endif; ?>
          <div class="card-body">
            <h5 class="card-title"><?= htmlspecialchars($p['title']) ?></h5>
            <p class="card-text"><?= nl2br(htmlspecialchars($p['description'])) ?></p>
          </div>
          <div class="card-footer d-flex justify-content-between align-items-center">
            <div>
              <?php if (!empty($p['link'])): ?>
                <a
                  href="<?= htmlspecialchars($p['link']) ?>"
                  target="_blank"
                  class="btn btn-outline-primary btn-sm me-2"
                >
                  <i class="bi bi-box-arrow-up-right me-1"></i>Voir en ligne
                </a>
              <?php endif; ?>
            </div>
            <div>
              <a
                href="project_edit.php?id=<?= $p['id'] ?>"
                class="btn btn-sm btn-primary me-1"
              ><i class="bi bi-pencil-fill"></i></a>
              <a
                href="project_delete.php?id=<?= $p['id'] ?>"
                onclick="return confirm('Supprimer ce projet ?')"
                class="btn btn-sm btn-danger"
              ><i class="bi bi-trash-fill"></i></a>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>

<?php include __DIR__ . '/../includes/footer.php'; ?>
