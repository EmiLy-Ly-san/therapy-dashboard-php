<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Note;

class NoteRepository
{
    public function __construct(private \PDO $pdo)
    {
    }

    public function findAll(): array
    {
        $sql = 'SELECT * FROM notes ORDER BY created_at DESC';
        return $this->pdo->query($sql)->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM notes WHERE id = :id');
        $stmt->execute(['id' => $id]);

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
             WHERE id = :id'
        );

        $stmt->execute([
            'id' => $note->getId(),
            'title' => $note->getTitle(),
            'content' => $note->getContent(),
            'is_shared' => $note->isShared() ? 1 : 0,
        ]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->pdo->prepare('DELETE FROM notes WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }
}