<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Note;
use App\Helper\Auth;
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
        Auth::requireRole('patient');

        $user = Auth::currentUser();
        $notes = $this->repository->findAllByUserId((int) $user['id']);

        require __DIR__.'/../../view/notes/list.php';
    }

    public function show(int $id): void
    {
        Auth::requireRole('patient');

        $user = Auth::currentUser();
        $note = $this->repository->findByIdAndUserId($id, (int) $user['id']);

        if (!$note) {
            http_response_code(404);
            echo 'Note non trouvée';

            return;
        }

        require __DIR__.'/../../view/notes/show.php';
    }

    public function create(): void
    {
        Auth::requireRole('patient');

        $user = Auth::currentUser();

        if ('POST' === $_SERVER['REQUEST_METHOD']) {
            checkCsrf();

            $title = trim($_POST['title'] ?? '');
            $content = trim($_POST['content'] ?? '');
            $isShared = isset($_POST['is_shared']);

            if ('' !== $title && '' !== $content) {
                $note = new Note(
                    null,
                    (int) $user['id'],
                    $title,
                    $content,
                    $isShared
                );

                $this->repository->save($note);

                header('Location: index.php?page=notes&action=list');

                exit;
            }
        }

        require __DIR__.'/../../view/notes/create.php';
    }

    public function update(int $id): void
    {
        Auth::requireRole('patient');

        $user = Auth::currentUser();
        $note = $this->repository->findByIdAndUserId($id, (int) $user['id']);

        if (!$note) {
            http_response_code(404);
            echo 'Note non trouvée';

            return;
        }

        if ('POST' === $_SERVER['REQUEST_METHOD']) {
            checkCsrf();

            $title = trim($_POST['title'] ?? '');
            $content = trim($_POST['content'] ?? '');
            $isShared = isset($_POST['is_shared']);

            if ('' !== $title && '' !== $content) {
                $updatedNote = new Note(
                    $id,
                    (int) $user['id'],
                    $title,
                    $content,
                    $isShared
                );

                $this->repository->update($updatedNote);

                header('Location: index.php?page=notes&action=list');

                exit;
            }
        }

        require __DIR__.'/../../view/notes/edit.php';
    }

    public function delete(int $id): void
    {
        Auth::requireRole('patient');

        $user = Auth::currentUser();
        $note = $this->repository->findByIdAndUserId($id, (int) $user['id']);

        if (!$note) {
            http_response_code(404);
            echo 'Note non trouvée';

            return;
        }

        $this->repository->delete($id, (int) $user['id']);

        header('Location: index.php?page=notes&action=list');

        exit;
    }
}
