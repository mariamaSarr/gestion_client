<?php
require_once __DIR__ . '/../../config/pdo.php'; // Inclure la connexion PDO

// Récupérer tous les utilisateurs et leurs mots de passe
$stmt = $pdo->query("SELECT id, username, password FROM users");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($users as $user) {
    $id = $user['id'];
    $plainPassword = $user['password'];
    $hashedPassword = password_hash($plainPassword, PASSWORD_BCRYPT);
    
    // Mettre à jour le mot de passe haché dans la base de données
    $updateStmt = $pdo->prepare("UPDATE users SET password = :password WHERE id = :id");
    $updateStmt->execute(['password' => $hashedPassword, 'id' => $id]);
}

echo "Mots de passe hachés et mis à jour avec succès.";
