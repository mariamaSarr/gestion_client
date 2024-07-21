<!DOCTYPE html>
<html>
<head>
    <title>Modifier un Client</title>
    <link rel="stylesheet" href="/gestion_clients/publics/css/add_client.css">
</head>
<body>
    <div class="container">
        <h1>Modifier un Client</h1>
        <form action="?action=update&id=<?= $client['id'] ?>" method="post">
            <label for="name">Nom:</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($client['name']) ?>"><br>
            <label for="address">Adresse:</label>
            <input type="text" id="address" name="address" value="<?= htmlspecialchars($client['address']) ?>"><br>
            <label for="phone">Téléphone:</label>
            <input type="text" id="phone" name="phone" value="<?= htmlspecialchars($client['phone']) ?>"><br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($client['email']) ?>"><br>
            <label for="gender">Sexe:</label>
            <select id="gender" name="gender">
                <option value="male" <?= $client['gender'] == 'male' ? 'selected' : '' ?>>Masculin</option>
                <option value="female" <?= $client['gender'] == 'female' ? 'selected' : '' ?>>Féminin</option>
            </select><br>
            <label for="status">Statut:</label>
            <select id="status" name="status">
                <option value="active" <?= $client['status'] == 'active' ? 'selected' : '' ?>>Actif</option>
                <option value="inactive" <?= $client['status'] == 'inactive' ? 'selected' : '' ?>>Inactif</option>
            </select><br>
            <input type="submit" value="Modifier">
        </form>
    </div>
</body>
</html>
