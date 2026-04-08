<?php
// public/index.php = point d'entrée (Front Controller)

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/database.php';

use App\Controller\NoteController;

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