<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Notes partagées du patient</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            max-width: 900px;
        }

        .note-card {
            border: 1px solid #dddddd;
            padding: 16px;
            margin-bottom: 16px;
            border-radius: 8px;
        }

        .meta {
            color: #555555;
            font-size: 14px;
        }

        .topbar {
            margin-bottom: 24px;
        }
    </style>
</head>
<body>
    <div class="topbar">
        <p>
            Bonjour <?php echo htmlspecialchars($_SESSION['user_name'] ?? ''); ?> |
            <a href="index.php?page=auth&action=logout">Déconnexion</a>
        </p>

        <p>
            <a href="index.php?page=therapist&action=dashboard">← Retour à mes patients</a>
        </p>
    </div>

    <h1>Notes partagées de <?php echo htmlspecialchars($patient['name']); ?></h1>

    <?php if (empty($notes)) { ?>
        <p>Aucune note partagée pour ce patient.</p>
    <?php } else { ?>
        <?php foreach ($notes as $note) { ?>
            <div class="note-card">
                <h2><?php echo htmlspecialchars($note['title']); ?></h2>
                <p><?php echo nl2br(htmlspecialchars($note['content'])); ?></p>
                <p class="meta">
                    Partagée : <?php echo $note['is_shared'] ? 'Oui' : 'Non'; ?> |
                    Créée le : <?php echo htmlspecialchars($note['created_at']); ?>
                </p>
            </div>
        <?php } ?>
    <?php } ?>
</body>
</html>