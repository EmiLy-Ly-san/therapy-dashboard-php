<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
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

        input {
            margin-top: 6px;
            padding: 8px;
            width: 100%;
            max-width: 420px;
        }

        .error {
            color: #b91c1c;
            font-size: 14px;
            margin-top: 10px;
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
    <h1>Connexion</h1>

    <?php if (isset($_SESSION['flash'])) { ?>
        <div class="flash">
            <?php echo htmlspecialchars($_SESSION['flash']); ?>
        </div>
        <?php unset($_SESSION['flash']); ?>
    <?php } ?>

    <?php if (!empty($error)) { ?>
        <p class="error"><?php echo htmlspecialchars($error); ?></p>
    <?php } ?>

    <form method="POST" action="index.php?page=auth&action=login">
        <input
            type="hidden"
            name="csrf_token"
            value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>"
        >

        <label>
            Email
            <input
                type="email"
                name="email"
                value="<?php echo htmlspecialchars($old['email'] ?? ''); ?>"
            >
        </label>

        <label>
            Mot de passe
            <input
                type="password"
                name="password"
            >
        </label>

        <button type="submit">Se connecter</button>
    </form>

    <p>
        Pas encore de compte ?
        <a href="index.php?page=auth&action=register">S'inscrire</a>
    </p>
</body>
</html>