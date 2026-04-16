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

    <?php if (isset($_SESSION['flash'])) { ?>
        <div class="flash">
            <?php echo htmlspecialchars($_SESSION['flash']); ?>
        </div>
        <?php unset($_SESSION['flash']); ?>
    <?php } ?>

    <form method="POST" action="index.php?page=auth&action=register">
        <input
            type="hidden"
            name="csrf_token"
            value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>"
        >

        <label>
            Nom
            <input
                type="text"
                name="name"
                value="<?php echo htmlspecialchars($old['name'] ?? ''); ?>"
            >
            <?php if (isset($errors['name'])) { ?>
                <div class="error"><?php echo htmlspecialchars($errors['name']); ?></div>
            <?php } ?>
        </label>

        <label>
            Email
            <input
                type="email"
                name="email"
                value="<?php echo htmlspecialchars($old['email'] ?? ''); ?>"
            >
            <?php if (isset($errors['email'])) { ?>
                <div class="error"><?php echo htmlspecialchars($errors['email']); ?></div>
            <?php } ?>
        </label>

        <label>
            Mot de passe
            <input
                type="password"
                name="password"
            >
            <?php if (isset($errors['password'])) { ?>
                <div class="error"><?php echo htmlspecialchars($errors['password']); ?></div>
            <?php } ?>
        </label>

        <label>
            Rôle
            <select name="role" id="role-select">
                <option value="patient" <?php echo (($old['role'] ?? 'patient') === 'patient') ? 'selected' : ''; ?>>
                    Patient
                </option>
                <option value="therapist" <?php echo (($old['role'] ?? '') === 'therapist') ? 'selected' : ''; ?>>
                    Thérapeute
                </option>
            </select>
            <?php if (isset($errors['role'])) { ?>
                <div class="error"><?php echo htmlspecialchars($errors['role']); ?></div>
            <?php } ?>
        </label>

        <label id="therapist-field">
            Thérapeute associé
            <select name="therapist_id">
                <option value="">-- Choisir un thérapeute --</option>
                <?php foreach ($therapists as $therapist) { ?>
                    <option
                        value="<?php echo (int) $therapist['id']; ?>"
                        <?php echo (($old['therapist_id'] ?? '') == $therapist['id']) ? 'selected' : ''; ?>
                    >
                        <?php echo htmlspecialchars($therapist['name']); ?>
                    </option>
                <?php } ?>
            </select>
            <?php if (isset($errors['therapist_id'])) { ?>
                <div class="error"><?php echo htmlspecialchars($errors['therapist_id']); ?></div>
            <?php } ?>
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