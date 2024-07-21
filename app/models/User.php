<?php

class User
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Trouver un utilisateur par nom d'utilisateur
    public function findByUsername($username)
    {
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Créer un nouvel utilisateur
    public function createUser($username, $password)
    {
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$username, $password]);
    }
}
