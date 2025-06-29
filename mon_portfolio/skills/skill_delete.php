<?php
// skills/skill_delete.php

require_once __DIR__ . '/../includes/functions.php';
requireLogin();

$id    = intval($_GET['id'] ?? 0);
$skill = getUserSkill($id);

// Sécurité : on supprime seulement si c’est bien à l’utilisateur
if ($skill && $skill['user_id'] === $_SESSION['user_id']) {
    deleteUserSkill($id);
}

header('Location: skills.php');
exit;
