<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détail de la note</title>
</head>
<body>
    <h1>Détail de la note</h1>

    <p><strong>Titre :</strong> <?php echo htmlspecialchars($note['title']); ?></p>
    <p><strong>Contenu :</strong><br><?php echo nl2br(htmlspecialchars($note['content'])); ?></p>
    <p><strong>Partagée :</strong> <?php echo $note['is_shared'] ? 'Oui' : 'Non'; ?></p>
    <p><strong>Date :</strong> <?php echo htmlspecialchars($note['created_at']); ?></p>

    <p>
        <a href="?page=notes&action=list">Retour à la liste</a>
    </p>
</body>
</html>