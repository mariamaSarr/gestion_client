<?php
session_start(); // Assurez-vous de démarrer la session au début

require_once __DIR__ . '/../../config/pdo.php'; // Inclure la connexion PDO

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (!empty($username) && !empty($password)) {
        // Préparer et exécuter la requête SQL
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Connexion réussie
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            header('Location: /gestion_clients/views/ClientsView/accueil.php'); // Rediriger vers une page après connexion réussie
            exit();
        } else {
            $error = 'Nom d\'utilisateur ou mot de passe incorrect.';
        }
    } else {
        $error = 'Veuillez entrer un nom d\'utilisateur et un mot de passe.';
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="/gestion_clients/publics/css/loging.css">


</head>
<body>
    <div class="container">
        <div class="login-box">
            <h2>Connexion</h2>
            <?php if (isset($error)): ?>
                <p class="error"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>
            <form method="POST" action="">
                <div class="textbox">
                    <label for="username">Nom d'utilisateur:</label>
                    <input type="text" name="username" id="username" required>
                </div>
                <div class="textbox">
                    <label for="password">Mot de passe:</label>
                    <input type="password" name="password" id="password" required>
                </div>
                <button type="submit" class="btn">Se connecter</button>
            </form>
        </div>
    </div>
</body>
</html>
