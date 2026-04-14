<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard thérapeute</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            max-width: 900px;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        tr {
            border-bottom: 1px solid #dddddd;
        }

        tr:hover {
            background-color: #f7f7f7;
        }

        .topbar {
            margin-bottom: 24px;
        }
    </style>
</head>
<body>
    <div class="topbar">
        <p>
            Bonjour <?= htmlspecialchars($_SESSION['user_name'] ?? '') ?> |
            <a href="index.php?page=auth&action=logout">Déconnexion</a>
        </p>
    </div>

    <h1>Mes patients</h1>

    <?php if (empty($patients)): ?>
        <p>Aucun patient associé pour le moment.</p>
    <?php else: ?>
        <table>
            <tr>
                <th>Nom</th>
                <th>Email</th>
                <th>Action</th>
            </tr>

            <?php foreach ($patients as $patient): ?>
                <tr>
                    <td><?= htmlspecialchars($patient['name']) ?></td>
                    <td><?= htmlspecialchars($patient['email']) ?></td>
                    <td>
                        <a href="index.php?page=therapist&action=patient-notes&id=<?= (int) $patient['id'] ?>">
                            Voir les notes partagées
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</body>
</html>