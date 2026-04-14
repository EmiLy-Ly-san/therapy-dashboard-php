<?php
// public/index.php = point d'entrée (Front Controller)

declare(strict_types=1);

session_start();

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/database.php';

use App\Controller\AuthController;
use App\Controller\NoteController;
use App\Controller\TherapistController;

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
$page = $_GET['page'] ?? 'auth';
$action = $_GET['action'] ?? 'login';
$id = (int) ($_GET['id'] ?? 0);

// Connexion BDD
$pdo = getConnection();

// Routage
match ($page . '/' . $action) {
    'notes/list'               => (new NoteController($pdo))->list(),
    'notes/show'               => (new NoteController($pdo))->show($id),
    'notes/create'             => (new NoteController($pdo))->create(),
    'notes/update'             => (new NoteController($pdo))->update($id),
    'notes/delete'             => (new NoteController($pdo))->delete($id),

    'auth/register'            => (new AuthController($pdo))->register(),
    'auth/login'               => (new AuthController($pdo))->login(),
    'auth/logout'              => (new AuthController($pdo))->logout(),

    'therapist/dashboard'      => (new TherapistController($pdo))->dashboard(),
    'therapist/patient-notes'  => (new TherapistController($pdo))->patientNotes($id),

    default                    => http_response_code(404) && print('Page non trouvée'),
};