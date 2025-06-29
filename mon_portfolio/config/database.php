<?php
// config/database.php

define('DB_HOST', '127.0.0.1');
define('DB_PORT', 3306);
define('DB_USER', 'root');
define('DB_NAME', 'projet_web');
define('DB_PASS', '');  


/**
 * Renvoie une instance PDO configurée.
 */
function getPDO(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        $dsn  = sprintf(
          'mysql:host=%s;port=%d;dbname=%s;charset=utf8mb4',
          DB_HOST, DB_PORT, DB_NAME
        );
        $opts = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        $pdo = new PDO($dsn, DB_USER, DB_PASS, $opts);
    }
    return $pdo;
}
