<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détail de la note</title>
</head>
<body>
    <h1>Détail de la note</h1>

    <p><strong>Titre :</strong> <?= htmlspecialchars($note['title']) ?></p>
    <p><strong>Contenu :</strong><br><?= nl2br(htmlspecialchars($note['content'])) ?></p>
    <p><strong>Partagée :</strong> <?= $note['is_shared'] ? 'Oui' : 'Non' ?></p>
    <p><strong>Date :</strong> <?= htmlspecialchars($note['created_at']) ?></p>

    <p>
        <a href="?page=notes&action=list">Retour à la liste</a>
    </p>
</body>
</html>