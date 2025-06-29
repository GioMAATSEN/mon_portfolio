<?php
// projects/project_delete.php

require_once __DIR__ . '/../includes/functions.php';
requireLogin();

$id      = intval($_GET['id'] ?? 0);
$project = getProject($id);

// Sécurité : supprimer uniquement si c'est bien le projet de l'utilisateur connecté
if ($project && $project['user_id'] === $_SESSION['user_id']) {
    deleteProject($id);
}

header('Location: projects.php');
exit;
