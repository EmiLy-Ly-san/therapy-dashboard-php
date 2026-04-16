<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier une note</title>
</head>
<body>
    <h1>Modifier une note</h1>

    <form method="POST">
        <div>
            <label for="title">Titre</label><br>
            <input
                type="text"
                id="title"
                name="title"
                value="<?php echo htmlspecialchars($note['title']); ?>"
                required
            >
        </div>

        <br>

        <div>
            <label for="content">Contenu</label><br>
            <textarea
                id="content"
                name="content"
                rows="8"
                cols="60"
                required
            ><?php echo htmlspecialchars($note['content']); ?></textarea>
        </div>

        <br>

        <div>
            <label>
                <input
                    type="checkbox"
                    name="is_shared"
                    <?php echo $note['is_shared'] ? 'checked' : ''; ?>
                >
                Partager avec le thérapeute
            </label>
        </div>

        <br>

        <button type="submit">Mettre à jour</button>
    </form>

    <p>
        <a href="?page=notes&action=list">Retour à la liste</a>
    </p>
</body>
</html>