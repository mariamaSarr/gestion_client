<?php
session_start(); // Assurez-vous que la session est démarrée

// Inclure les fichiers nécessaires
$dbConfig = require __DIR__ . '/../config/database.php';
include_once __DIR__ . '/../app/models/User.php';

// Vérifiez que $dbConfig contient les informations nécessaires
if (!isset($dbConfig['host'], $dbConfig['dbname'], $dbConfig['user'], $dbConfig['pass'])) {
    die('Configuration de la base de données manquante.');
}

try {
    $pdo = new PDO(
        'mysql:host=' . $dbConfig['host'] . ';dbname=' . $dbConfig['dbname'],
        $dbConfig['user'],
        $dbConfig['pass']
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Échec de la connexion à la base de données : ' . $e->getMessage());
}

$userModel = new User($pdo);

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $user = $userModel->findByUsername($username);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user;
        header('Location: /gestion_clients/publics/accueil.php');
        exit();
    } else {
        $error = "Nom d'utilisateur ou mot de passe incorrect.";
    }
}
?>
    
    <!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="/../publics/css/loging.css">
</head>
<body>
    <?php if ($error): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
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

