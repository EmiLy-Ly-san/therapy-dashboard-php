<?php

declare(strict_types=1);

namespace App\Helper;

class Auth
{
    public static function requireAuth(): void
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?page=auth&action=login');
            exit;
        }
    }

    public static function currentUser(): ?array
    {
        if (!isset($_SESSION['user_id'])) {
            return null;
        }

        return [
            'id' => (int) $_SESSION['user_id'],
            'name' => $_SESSION['user_name'] ?? '',
            'role' => $_SESSION['role'] ?? '',
        ];
    }

    public static function requireRole(string $role): void
    {
        self::requireAuth();

        if (($_SESSION['role'] ?? '') !== $role) {
            http_response_code(403);
            exit('Accès interdit');
        }
    }
}