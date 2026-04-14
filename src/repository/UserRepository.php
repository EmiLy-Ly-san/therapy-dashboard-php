<?php
declare(strict_types=1);

namespace App\Repository;

use PDO;

class UserRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /** Trouver un utilisateur par email (login) */
    public function findByEmail(string $email): ?array
    {
        $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['email' => $email]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user ?: null;
    }

    /** Trouver un utilisateur par ID */
    public function findById(int $id): ?array
    {
        $sql = "SELECT * FROM users WHERE id = :id LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user ?: null;
    }

    /** Créer un utilisateur */
    public function create(array $data): void
    {
        $sql = "
            INSERT INTO users (name, email, password, role, therapist_id)
            VALUES (:name, :email, :password, :role, :therapist_id)
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role' => $data['role'],
            'therapist_id' => $data['therapist_id'] ?? null,
        ]);
    }

    /** Récupérer tous les therapists */
    public function findTherapists(): array
    {
        $sql = "SELECT id, name FROM users WHERE role = 'therapist' ORDER BY name";
        $stmt = $this->pdo->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupérer les patients d'un therapist
     */
    public function findPatientsByTherapistId(int $therapistId): array
    {
        $sql = "
            SELECT id, name, email
            FROM users
            WHERE role = 'patient' AND therapist_id = :therapist_id
            ORDER BY name
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['therapist_id' => $therapistId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /** Trouver un patient appartenant à un therapist */
    public function findPatientByIdAndTherapistId(int $patientId, int $therapistId): ?array
    {
        $sql = "
            SELECT id, name, email, therapist_id
            FROM users
            WHERE id = :patient_id
              AND role = 'patient'
              AND therapist_id = :therapist_id
            LIMIT 1
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'patient_id' => $patientId,
            'therapist_id' => $therapistId,
        ]);

        $patient = $stmt->fetch(PDO::FETCH_ASSOC);

        return $patient ?: null;
    }
}