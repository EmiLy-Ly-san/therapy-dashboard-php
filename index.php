<?php
declare(strict_types=1);

require_once __DIR__ . '/config/database.php';

try {
    $pdo = getConnection();
    echo "Connexion";
} catch (PDOException $e) {
    echo "Erreur de connexion : " . htmlspecialchars($e->getMessage());
}