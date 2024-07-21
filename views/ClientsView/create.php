<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un Client</title>
    <link rel="stylesheet" href="/gestion_clients/publics/css/add_client.css">
</head>
<body>
    <div class="container">
        <h1>Ajouter un Client</h1>
        <form action="?action=store" method="post">
            <label for="name">Nom:</label>
            <input type="text" id="name" name="name" required><br>
            
            <label for="address">Adresse:</label>
            <input type="text" id="address" name="address" required><br>
            
            <label for="phone">Téléphone:</label>
            <input type="text" id="phone" name="phone" required><br>
            
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br>
            
            <label for="gender">Sexe:</label>
            <select id="gender" name="gender" required>
                <option value="male">Masculin</option>
                <option value="female">Féminin</option>
            </select><br>
            
            <label for="status">Statut:</label>
            <select id="status" name="status" required>
                <option value="active">Actif</option>
                <option value="inactive">Inactif</option>
            </select><br>
            
            <input type="submit" value="Ajouter">
        </form>
    </div>
</body>
</html>
