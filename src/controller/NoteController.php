<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Note;
use App\Repository\NoteRepository;

class NoteController
{
    private NoteRepository $repository;

    public function __construct(\PDO $pdo)
    {
        $this->repository = new NoteRepository($pdo);
    }

    public function list(): void
    {
        $notes = $this->repository->findAll();
        require __DIR__ . '/../../view/notes/list.php';
    }

    public function show(int $id): void
    {
        $note = $this->repository->find($id);

        if (!$note) {
            http_response_code(404);
            echo 'Note non trouvée';
            return;
        }

        require __DIR__ . '/../../view/notes/show.php';
    }

    public function create(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = trim($_POST['title'] ?? '');
            $content = trim($_POST['content'] ?? '');
            $isShared = isset($_POST['is_shared']);

            if ($title !== '' && $content !== '') {
                $note = new Note(
                    null,
                    1,
                    $title,
                    $content,
                    $isShared
                );

                $this->repository->save($note);

                header('Location: index.php?page=notes&action=list');
                exit;
            }
        }

        require __DIR__ . '/../../view/notes/create.php';
    }

    public function update(int $id): void
    {
        $note = $this->repository->find($id);

        if (!$note) {
            http_response_code(404);
            echo 'Note non trouvée';
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = trim($_POST['title'] ?? '');
            $content = trim($_POST['content'] ?? '');
            $isShared = isset($_POST['is_shared']);

            if ($title !== '' && $content !== '') {
                $updatedNote = new Note(
                    $id,
                    (int) $note['user_id'],
                    $title,
                    $content,
                    $isShared
                );

                $this->repository->update($updatedNote);

                header('Location: index.php?page=notes&action=list');
                exit;
            }
        }

        require __DIR__ . '/../../view/notes/edit.php';
    }

    public function delete(int $id): void
    {
        $note = $this->repository->find($id);

        if (!$note) {
            http_response_code(404);
            echo 'Note non trouvée';
            return;
        }

        $this->repository->delete($id);

        header('Location: index.php?page=notes&action=list');
        exit;
    }
}