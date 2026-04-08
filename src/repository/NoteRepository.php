<?php

declare(strict_types=1);

namespace App\Repository;

class NoteRepository
{
    public function __construct(private \PDO $pdo) {}

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

    public function save(array $data): int
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO notes (user_id, title, content, is_shared)
             VALUES (:user_id, :title, :content, :is_shared)'
        );

        $stmt->execute([
            'user_id' => $data['user_id'],
            'title' => $data['title'],
            'content' => $data['content'],
            'is_shared' => $data['is_shared'],
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    public function edit(int $id, array $data): void
    {
        $stmt = $this->pdo->prepare(
            'UPDATE notes
             SET title = :title,
                 content = :content,
                 is_shared = :is_shared
             WHERE id = :id'
        );

        $stmt->execute([
            'id' => $id,
            'title' => $data['title'],
            'content' => $data['content'],
            'is_shared' => $data['is_shared'],
        ]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->pdo->prepare('DELETE FROM notes WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }
}