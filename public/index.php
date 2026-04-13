<?php
// public/index.php = point d'entrée (Front Controller)

declare(strict_types=1);

session_start();

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/database.php';

use App\Controller\NoteController;


// CSRF TOKEN

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

function checkCsrf(): void
{
    $sessionToken = $_SESSION['csrf_token'] ?? '';
    $postToken = $_POST['csrf_token'] ?? '';

    if (!hash_equals($sessionToken, $postToken)) {
        http_response_code(403);
        exit('Token CSRF invalide');
    }
}

// paramètres de route
$page = $_GET['page'] ?? 'notes';
$action = $_GET['action'] ?? 'list';
$id = (int) ($_GET['id'] ?? 0);

// Connexion BDD
$pdo = getConnection();

// Instanciation du controller
$controller = new NoteController($pdo);

// Routage
match ($page . '/' . $action) {
    'notes/list'   => $controller->list(),
    'notes/show'   => $controller->show($id),
    'notes/create' => $controller->create(),
    'notes/update' => $controller->update($id),
    'notes/delete' => $controller->delete($id),
    default        => http_response_code(404) && print('Page non trouvée'),
};