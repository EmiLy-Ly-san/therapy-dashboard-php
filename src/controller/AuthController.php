<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\UserRepository;

class AuthController
{
    private UserRepository $userRepo;

    public function __construct(\PDO $pdo)
    {
        $this->userRepo = new UserRepository($pdo);
    }

    public function register(): void
    {
        $therapists = $this->userRepo->findTherapists();

        if ('GET' === $_SERVER['REQUEST_METHOD']) {
            $errors = [];
            $old = [];

            require __DIR__.'/../../view/auth/register.php';

            return;
        }

        checkCsrf();

        $errors = [];
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $role = $_POST['role'] ?? 'patient';
        $therapistId = $_POST['therapist_id'] ?? '';

        if ('' === $name) {
            $errors['name'] = 'Le nom est requis';
        }

        // filter_var : fonction PHP pour valider, filtrer des données
        // FILTER_VALIDATE_EMAIL: constante PHP utilisée avec filter_var pour vérifier format d’un email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email invalide';
        }

        // vérifie longueur de la chaîne
        if (mb_strlen($password) < 8) {
            $errors['password'] = 'Minimum 8 caractères';
        }

        if (!in_array($role, ['patient', 'therapist'], true)) {
            $errors['role'] = 'Rôle invalide';
        }

        if ('patient' === $role) {
            if ('' === $therapistId) {
                $errors['therapist_id'] = 'Veuillez choisir un thérapeute';
            } elseif (!$this->userRepo->findById((int) $therapistId)) {
                $errors['therapist_id'] = 'Thérapeute invalide';
            }
        }

        if (empty($errors) && $this->userRepo->findByEmail($email)) {
            $errors['email'] = 'Erreur lors de l’inscription';
        }

        $old = [
            'name' => $name,
            'email' => $email,
            'role' => $role,
            'therapist_id' => $therapistId,
        ];

        if (!empty($errors)) {
            require __DIR__.'/../../view/auth/register.php';

            return;
        }

        $hash = password_hash($password, PASSWORD_DEFAULT);

        $this->userRepo->create([
            'name' => $name,
            'email' => $email,
            'password' => $hash,
            'role' => $role,
            'therapist_id' => 'patient' === $role ? (int) $therapistId : null,
        ]);

        $_SESSION['flash'] = 'Inscription réussie ! Connectez-vous.';
        header('Location: index.php?page=auth&action=login');

        exit;
    }

    public function login(): void
    {
        // Si la requête est GET, on affiche le formulaire
        if ('GET' === $_SERVER['REQUEST_METHOD']) {
            $error = null;
            $old = [];

            require __DIR__.'/../../view/auth/login.php';

            return;
        }

        // Vérification du token CSRF pour sécuriser le formulaire
        checkCsrf();

        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        $user = $this->userRepo->findByEmail($email);

        if (!$user || !password_verify($password, $user['password'])) {
            $error = 'Email ou mot de passe incorrect';
            $old = ['email' => $email];

            require __DIR__.'/../../view/auth/login.php';

            return;
        }

        session_regenerate_id(true);

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['role'] = $user['role'];

        // Redirection selon rôle
        if ('therapist' === $user['role']) {
            header('Location: index.php?page=therapist&action=dashboard');

            exit;
        }

        header('Location: index.php?page=notes&action=list');

        exit;
    }

    public function logout(): void
    {
        $_SESSION = [];

        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();

            setcookie(
                session_name(),
                '',
                time() - 3600,
                $params['path'],
                $params['domain'],
                (bool) $params['secure'],
                (bool) $params['httponly']
            );
        }

        session_destroy();

        header('Location: index.php?page=auth&action=login');

        exit;
    }
}
