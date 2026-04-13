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

        // Affichage initial du formulaire
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $errors = [];
            $old = [];
            require __DIR__ . '/../../view/auth/register.php';
            return;
        }

        checkCsrf();

        // Validation
        $errors = [];
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $role = $_POST['role'] ?? 'patient';
        $therapistId = $_POST['therapist_id'] ?? '';

        if ($name === '') {
            $errors['name'] = 'Le nom est requis';
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email invalide';
        }

        if (mb_strlen($password) < 8) {
            $errors['password'] = 'Minimum 8 caractères';
        }

        if (!in_array($role, ['patient', 'therapist'], true)) {
            $errors['role'] = 'Rôle invalide';
        }

        // Si l'utilisateur est patient, il doit choisir un therapist
        if ($role === 'patient') {
            if ($therapistId === '') {
                $errors['therapist_id'] = 'Veuillez choisir un thérapeute';
            } elseif (!$this->userRepo->findById((int) $therapistId)) {
                $errors['therapist_id'] = 'Thérapeute invalide';
            }
        }

        // Vérifier email déjà utilisé
        if (empty($errors) && $this->userRepo->findByEmail($email)) {
            $errors['email'] = 'Cet email est déjà utilisé';
        }

        // Sticky form
        $old = [
            'name' => $name,
            'email' => $email,
            'role' => $role,
            'therapist_id' => $therapistId,
        ];

        if (!empty($errors)) {
            require __DIR__ . '/../../view/auth/register.php';
            return;
        }

        // Hash mot de passe
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $this->userRepo->create([
            'name' => $name,
            'email' => $email,
            'password' => $hash,
            'role' => $role,
            'therapist_id' => $role === 'patient' ? (int) $therapistId : null,
        ]);

        $_SESSION['flash'] = 'Inscription réussie ! Connectez-vous.';
        header('Location: index.php?page=auth&action=login');
        exit;
    }
}