<?php

declare(strict_types=1);

namespace App\Controller;

use App\Helper\Auth;
use App\Repository\NoteRepository;
use App\Repository\UserRepository;

class TherapistController
{
    private UserRepository $userRepository;
    private NoteRepository $noteRepository;

    public function __construct(\PDO $pdo)
    {
        $this->userRepository = new UserRepository($pdo);
        $this->noteRepository = new NoteRepository($pdo);
    }

    /** Dashboard therapist = liste de ses patients */
    public function dashboard(): void
    {
        Auth::requireRole('therapist');

        $user = Auth::currentUser();
        $patients = $this->userRepository->findPatientsByTherapistId((int) $user['id']);

        require __DIR__.'/../../view/therapist/dashboard.php';
    }

    /** voir les notes partagées d'un patient */
    public function patientNotes(int $patientId): void
    {
        Auth::requireRole('therapist');

        $user = Auth::currentUser();

        $patient = $this->userRepository->findPatientByIdAndTherapistId(
            $patientId,
            (int) $user['id']
        );

        if (!$patient) {
            http_response_code(404);
            echo 'Patient non trouvé';

            return;
        }

        $notes = $this->noteRepository->findSharedNotesByPatientId($patientId);

        require __DIR__.'/../../view/therapist/patient-notes.php';
    }
}
