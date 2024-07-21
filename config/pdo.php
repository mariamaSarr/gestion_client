<?php
$config = require __DIR__ . '/database.php'; 

try {
    $pdo = new PDO(
        "mysql:host={$config['host']};dbname={$config['dbname']}",
        $config['user'],
        $config['pass']
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>
