<?php
session_start(); // Assurez-vous que la session est démarrée

class UserController
{
    private $pdo;
    private $userModel;

    public function __construct()
    {
        $dbConfig = require __DIR__ . '/../../config/database.php';
        $this->pdo = new PDO(
            'mysql:host=' . $dbConfig['host'] . ';dbname=' . $dbConfig['dbname'],
            $dbConfig['user'],
            $dbConfig['pass']
        );
        $this->userModel = new User($this->pdo);
    }

    // Méthode d'inscription
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            // Hachage du mot de passe
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insérer l'utilisateur dans la base de données
            $this->userModel->createUser($username, $hashedPassword);

            // Rediriger vers la page de connexion ou d'accueil
            header('Location: /login.php');
            exit();
        }
        require __DIR__ . '/../../publics/register.php';
    }

    // Méthode de connexion
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $user = $this->userModel->findByUsername($username);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user'] = $user;
                header('Location: /gestion_clients/publics/accueil.php');
                exit();
            } else {
                $error = "Nom d'utilisateur ou mot de passe incorrect.";
            }
        }
        require __DIR__ . '/gestion_clients/publics/accueil.php';
    }

    // Méthode de déconnexion
    public function logout()
    {
        unset($_SESSION['user']);
        header('Location: /login.php');
        exit();
    }
}
