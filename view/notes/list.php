<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes notes</title>
</head>
<body>
  <p>
    Bonjour <?= htmlspecialchars($_SESSION['user_name'] ?? '') ?> |
    <a href="index.php?page=auth&action=logout">Déconnexion</a>
  </p>
    <h1>Mes notes (<?= count($notes) ?>)</h1>

    <p>
        <a href="?page=notes&action=create">Ajouter une note</a>
    </p>

    <table cellpadding="8">
        <tr>
            <th>Titre</th>
            <th>Partagée</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>

        <?php foreach ($notes as $note): ?>
            <tr>
                <td><?= htmlspecialchars($note['title']) ?></td>
                <td><?= $note['is_shared'] ? 'Oui' : 'Non' ?></td>
                <td><?= htmlspecialchars($note['created_at']) ?></td>
                <td>
                    <a href="?page=notes&action=show&id=<?= $note['id'] ?>">Voir</a>
                    <a href="?page=notes&action=update&id=<?= $note['id'] ?>">Modifier</a>
                    <a href="?page=notes&action=delete&id=<?= $note['id'] ?>" onclick="return confirm('Supprimer cette note ?')">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>