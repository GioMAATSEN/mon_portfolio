<?php
// admin/skill_types/delete.php
require_once __DIR__ . '/../../includes/functions.php';
requireAdmin();

$id = intval($_GET['id'] ?? 0);
deleteSkillType($id);

header('Location: index.php');
exit;
