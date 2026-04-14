<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            max-width: 700px;
        }

        label {
            display: block;
            margin-top: 14px;
        }

        input, select {
            margin-top: 6px;
            padding: 8px;
            width: 100%;
            max-width: 420px;
        }

        .error {
            color: #b91c1c;
            font-size: 14px;
            margin-top: 4px;
        }

        .flash {
            background: #ecfdf5;
            border: 1px solid #10b981;
            padding: 10px;
            margin-bottom: 20px;
        }

        button {
            margin-top: 20px;
            padding: 10px 14px;
        }
    </style>
</head>
<body>
    <h1>Inscription</h1>

    <?php if (isset($_SESSION['flash'])): ?>
        <div class="flash">
            <?= htmlspecialchars($_SESSION['flash']) ?>
        </div>
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>

    <form method="POST" action="index.php?page=auth&action=register">
        <input
            type="hidden"
            name="csrf_token"
            value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>"
        >

        <label>
            Nom
            <input
                type="text"
                name="name"
                value="<?= htmlspecialchars($old['name'] ?? '') ?>"
            >
            <?php if (isset($errors['name'])): ?>
                <div class="error"><?= htmlspecialchars($errors['name']) ?></div>
            <?php endif; ?>
        </label>

        <label>
            Email
            <input
                type="email"
                name="email"
                value="<?= htmlspecialchars($old['email'] ?? '') ?>"
            >
            <?php if (isset($errors['email'])): ?>
                <div class="error"><?= htmlspecialchars($errors['email']) ?></div>
            <?php endif; ?>
        </label>

        <label>
            Mot de passe
            <input
                type="password"
                name="password"
            >
            <?php if (isset($errors['password'])): ?>
                <div class="error"><?= htmlspecialchars($errors['password']) ?></div>
            <?php endif; ?>
        </label>

        <label>
            Rôle
            <select name="role" id="role-select">
                <option value="patient" <?= (($old['role'] ?? 'patient') === 'patient') ? 'selected' : '' ?>>
                    Patient
                </option>
                <option value="therapist" <?= (($old['role'] ?? '') === 'therapist') ? 'selected' : '' ?>>
                    Thérapeute
                </option>
            </select>
            <?php if (isset($errors['role'])): ?>
                <div class="error"><?= htmlspecialchars($errors['role']) ?></div>
            <?php endif; ?>
        </label>

        <label id="therapist-field">
            Thérapeute associé
            <select name="therapist_id">
                <option value="">-- Choisir un thérapeute --</option>
                <?php foreach ($therapists as $therapist): ?>
                    <option
                        value="<?= (int) $therapist['id'] ?>"
                        <?= (($old['therapist_id'] ?? '') == $therapist['id']) ? 'selected' : '' ?>
                    >
                        <?= htmlspecialchars($therapist['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <?php if (isset($errors['therapist_id'])): ?>
                <div class="error"><?= htmlspecialchars($errors['therapist_id']) ?></div>
            <?php endif; ?>
        </label>

        <button type="submit">S'inscrire</button>
    </form>

    <p>
        Déjà un compte ?
        <a href="index.php?page=auth&action=login">Se connecter</a>
    </p>

    <script>
        const roleSelect = document.getElementById('role-select');
        const therapistField = document.getElementById('therapist-field');

        function toggleTherapistField() {
            therapistField.style.display = roleSelect.value === 'patient' ? 'block' : 'none';
        }

        roleSelect.addEventListener('change', toggleTherapistField);
        toggleTherapistField();
    </script>
</body>
</html>