<?php
session_start();

$dbConfig = require __DIR__ . '/../config/database.php';
include_once __DIR__ . '/../app/models/User.php';


$pdo = new PDO(
    'mysql:host=' . $dbConfig['host'] . ';dbname=' . $dbConfig['dbname'],
    $dbConfig['user'],
    $dbConfig['pass']
);
$userModel = new User($pdo);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $userModel->createUser($username, $hashedPassword);

    echo"admin inscrit avec succes";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link rel="stylesheet" href="/gestion_clients/publics/css/register.css">
</head>
<body>
    <div class="container">
        <h1>Inscription</h1>
        <form action="register.php" method="post">
            <label for="username">Nom d'utilisateur:</label>
            <input type="text" id="username" name="username" required>
            
            <label for="password">Mot de passe:</label>
            <input type="password" id="password" name="password" required>
            
            <button type="submit">Inscrire</button>
        </form>
    </div>
    
</body>
</html>

