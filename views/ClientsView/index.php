<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Clients</title>
    <link rel="stylesheet" href="/gestion_clients/publics/css/index2.css">
    <style>
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="container">

        <!-- Formulaire de filtrage -->
        <form method="GET" action="">
            <input type="hidden" name="action" value="index">
            <label for="name">Nom:</label>
            <input type="text" name="name" id="name" value="<?= htmlspecialchars($_GET['name'] ?? '') ?>">
            <label for="address">Adresse:</label>
            <input type="text" name="address" id="address" value="<?= htmlspecialchars($_GET['address'] ?? '') ?>">
            <label for="phone">Téléphone:</label>
            <input type="text" name="phone" id="phone" value="<?= htmlspecialchars($_GET['phone'] ?? '') ?>">
            <button type="submit">Filtrer</button>
        </form>

        <!-- Formulaire de tri 
         ce formulaire permet de ranges les clients selon le attribut choisit par ordre croissant 
         du plus grand au plus petit-->
         
        <form method="GET" action="">
            <input type="hidden" name="action" value="index">
            <label for="sort">Trier par:</label>
            <select name="sort" id="sort" onchange="this.form.submit()">
                <option value="">-- Sélectionnez --</option>
                <option value="id" <?= ($_GET['sort'] ?? '') == 'id' ? 'selected' : '' ?>>ID</option>
                <option value="name" <?= ($_GET['sort'] ?? '') == 'name' ? 'selected' : '' ?>>Nom</option>
                <option value="address" <?= ($_GET['sort'] ?? '') == 'address' ? 'selected' : '' ?>>Adresse</option>
                <option value="phone" <?= ($_GET['sort'] ?? '') == 'phone' ? 'selected' : '' ?>>Téléphone</option>
                <option value="status" <?= ($_GET['sort'] ?? '') == 'status' ? 'selected' : '' ?>>Statut</option>
            </select>
        </form>

         <!-- Liste des clients -->
         <h1>Liste des Clients</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Adresse</th>
                    <th>Téléphone</th>
                    <th>Email</th>
                    <th>Sexe</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($clients)): ?>
                    <?php foreach ($clients as $client): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($client['id']); ?></td>
                            <td><?php echo htmlspecialchars($client['name']); ?></td>
                            <td><?php echo htmlspecialchars($client['address']); ?></td>
                            <td><?php echo htmlspecialchars($client['phone']); ?></td>
                            <td><?php echo htmlspecialchars($client['email']); ?></td>
                            <td><?php echo htmlspecialchars($client['gender']); ?></td>
                            <td><?php echo htmlspecialchars($client['status']); ?></td>
                            <td>
                                <a href="?action=edit&id=<?= $client['id'] ?>">Modifier</a>
                                <form method="POST" action="?action=delete&id=<?= $client['id'] ?>" style="display:inline;">
                                    <input type="hidden" name="id" value="<?= htmlspecialchars($client['id']) ?>">
                                    <input type="submit" name="supprimer" value="Supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce client ?');">
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8">Aucun client trouvé</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <!-- Boutons d'export et impression -->
        <button onclick="window.print()" class="no-print">Imprimer</button>
        
        <a href="?action=export&format=csv" class="no-print">Exporter en CSV</a> |
        <a href="?action=export&format=pdf" class="no-print">Exporter en PDF</a>
        <br><br>

       
    </div>
</body>
</html>
