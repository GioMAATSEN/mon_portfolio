<?php
// includes/functions.php

session_start();
require_once __DIR__ . '/../config/database.php';

//
// === AUTH & SESSIONS ===
//

function isLoggedIn(): bool {
    return isset($_SESSION['user_id']);
}

function requireLogin(): void {
    if (!isLoggedIn()) {
        header('Location: /login.php');
        exit;
    }
}

function isAdmin(): bool {
    return isLoggedIn() && ($_SESSION['role'] ?? '') === 'admin';
}

function requireAdmin(): void {
    if (!isAdmin()) {
        header('Location: /index.php');
        exit;
    }
}

function loginUser(array $user): void {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['role']    = $user['role'];
}

function getUserByEmail(string $email): ?array {
    $pdo  = getPDO();
    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
    $stmt->execute([$email]);
    return $stmt->fetch() ?: null;
}

function createUser(string $email, string $password): bool {
    $pdo  = getPDO();
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare('INSERT INTO users (email, password) VALUES (?, ?)');
    return $stmt->execute([$email, $hash]);
}

//
// === PROJETS ===
//

function getProjectsByUser(int $user_id): array {
    $pdo  = getPDO();
    $stmt = $pdo->prepare(
        'SELECT * FROM projects WHERE user_id = ? ORDER BY created_at DESC'
    );
    $stmt->execute([$user_id]);
    return $stmt->fetchAll();
}

function getProject(int $id): ?array {
    $pdo  = getPDO();
    $stmt = $pdo->prepare('SELECT * FROM projects WHERE id = ?');
    $stmt->execute([$id]);
    return $stmt->fetch() ?: null;
}

function createProject(int $user_id, string $title, string $description, ?string $link, ?string $image): bool {
    $pdo  = getPDO();
    $stmt = $pdo->prepare('
        INSERT INTO projects (user_id, title, description, link, image)
        VALUES (?, ?, ?, ?, ?)
    ');
    return $stmt->execute([$user_id, $title, $description, $link, $image]);
}

function updateProject(int $id, string $title, string $description, ?string $link, ?string $image): bool {
    $pdo = getPDO();
    if ($image !== null) {
        $sql    = 'UPDATE projects SET title = ?, description = ?, link = ?, image = ? WHERE id = ?';
        $params = [$title, $description, $link, $image, $id];
    } else {
        $sql    = 'UPDATE projects SET title = ?, description = ?, link = ? WHERE id = ?';
        $params = [$title, $description, $link, $id];
    }
    $stmt = $pdo->prepare($sql);
    return $stmt->execute($params);
}

function deleteProject(int $id): bool {
    $pdo  = getPDO();
    $stmt = $pdo->prepare('DELETE FROM projects WHERE id = ?');
    return $stmt->execute([$id]);
}

//
// === TYPES DE COMPÉTENCES (ADMIN) ===
//

function getSkillTypes(): array {
    $pdo  = getPDO();
    $stmt = $pdo->query('SELECT id, name, difficulty FROM skill_types ORDER BY name');
    return $stmt->fetchAll();
}

function getSkillType(int $id): ?array {
    $pdo  = getPDO();
    $stmt = $pdo->prepare('SELECT id, name, difficulty FROM skill_types WHERE id = ?');
    $stmt->execute([$id]);
    return $stmt->fetch() ?: null;
}

function createSkillType(string $name, int $difficulty): bool {
    $pdo  = getPDO();
    $stmt = $pdo->prepare('INSERT INTO skill_types (name, difficulty) VALUES (?, ?)');
    return $stmt->execute([$name, $difficulty]);
}

function updateSkillType(int $id, string $name, int $difficulty): bool {
    $pdo  = getPDO();
    $stmt = $pdo->prepare('UPDATE skill_types SET name = ?, difficulty = ? WHERE id = ?');
    return $stmt->execute([$name, $difficulty, $id]);
}

function deleteSkillType(int $id): bool {
    $pdo  = getPDO();
    $stmt = $pdo->prepare('DELETE FROM skill_types WHERE id = ?');
    return $stmt->execute([$id]);
}

//
// === COMPÉTENCES UTILISATEUR ===
//

function getUserSkills(int $user_id): array {
    $pdo  = getPDO();
    $stmt = $pdo->prepare(<<<'SQL'
        SELECT 
          us.id,
          st.name       AS skill,
          st.difficulty,
          us.level
        FROM user_skills us
        JOIN skill_types st ON st.id = us.skill_type_id
        WHERE us.user_id = ?
        ORDER BY st.name
    SQL);
    $stmt->execute([$user_id]);
    return $stmt->fetchAll();
}

function getUserSkill(int $id): ?array {
    $pdo  = getPDO();
    $stmt = $pdo->prepare('SELECT * FROM user_skills WHERE id = ?');
    $stmt->execute([$id]);
    return $stmt->fetch() ?: null;
}

function createUserSkill(int $user_id, int $skill_type_id, int $level): bool {
    $pdo  = getPDO();
    $stmt = $pdo->prepare('INSERT INTO user_skills (user_id, skill_type_id, level) VALUES (?, ?, ?)');
    return $stmt->execute([$user_id, $skill_type_id, $level]);
}

function updateUserSkill(int $id, int $skill_type_id, int $level): bool {
    $pdo  = getPDO();
    $stmt = $pdo->prepare('UPDATE user_skills SET skill_type_id = ?, level = ? WHERE id = ?');
    return $stmt->execute([$skill_type_id, $level, $id]);
}

function deleteUserSkill(int $id): bool {
    $pdo  = getPDO();
    $stmt = $pdo->prepare('DELETE FROM user_skills WHERE id = ?');
    return $stmt->execute([$id]);
}

//
// === PROFILS UTILISATEUR ===
//

function getProfile(int $user_id): array {
    $pdo  = getPDO();
    $stmt = $pdo->prepare('SELECT * FROM profiles WHERE user_id = ?');
    $stmt->execute([$user_id]);
    return $stmt->fetch() ?: [];
}

function saveProfile(int $user_id, string $name, string $bio, ?string $photo): bool {
    $pdo  = getPDO();
    $stmt = $pdo->prepare(<<<'SQL'
        INSERT INTO profiles (user_id, name, bio, photo)
        VALUES (?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE
          name  = VALUES(name),
          bio   = VALUES(bio),
          photo = VALUES(photo)
    SQL);
    return $stmt->execute([$user_id, $name, $bio, $photo]);
}

//
// === ANNuaire UTILISATEURS ===
//

function getAllUsers(): array {
    $pdo  = getPDO();
    $stmt = $pdo->query(<<<'SQL'
        SELECT 
          u.id,
          u.email,
          COALESCE(p.name, '') AS name
        FROM users u
        LEFT JOIN profiles p ON p.user_id = u.id
        ORDER BY p.name, u.email
    SQL);
    return $stmt->fetchAll();
}
