<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Note;

class NoteRepository
{
    public function __construct(private \PDO $pdo) {}

    public function findAllByUserId(int $userId): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM notes WHERE user_id = :user_id ORDER BY created_at DESC'
        );
        $stmt->execute(['user_id' => $userId]);

        return $stmt->fetchAll() ?: [];
    }

    public function findByIdAndUserId(int $id, int $userId): ?array
    {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM notes WHERE id = :id AND user_id = :user_id'
        );
        $stmt->execute([
            'id' => $id,
            'user_id' => $userId,
        ]);

        return $stmt->fetch() ?: null;
    }

    public function save(Note $note): int
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO notes (user_id, title, content, is_shared)
             VALUES (:user_id, :title, :content, :is_shared)'
        );

        $stmt->execute([
            'user_id' => $note->getUserId(),
            'title' => $note->getTitle(),
            'content' => $note->getContent(),
            'is_shared' => $note->isShared() ? 1 : 0,
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    public function update(Note $note): void
    {
        $stmt = $this->pdo->prepare(
            'UPDATE notes
             SET title = :title,
                 content = :content,
                 is_shared = :is_shared
             WHERE id = :id AND user_id = :user_id'
        );

        $stmt->execute([
            'id' => $note->getId(),
            'user_id' => $note->getUserId(),
            'title' => $note->getTitle(),
            'content' => $note->getContent(),
            'is_shared' => $note->isShared() ? 1 : 0,
        ]);
    }

    public function delete(int $id, int $userId): void
    {
        $stmt = $this->pdo->prepare(
            'DELETE FROM notes WHERE id = :id AND user_id = :user_id'
        );
        $stmt->execute([
            'id' => $id,
            'user_id' => $userId,
        ]);
    }

    public function findSharedNotesByPatientId(int $patientId): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM notes
             WHERE user_id = :user_id AND is_shared = 1
             ORDER BY created_at DESC'
        );
        $stmt->execute(['user_id' => $patientId]);

        return $stmt->fetchAll() ?: [];
    }
}
