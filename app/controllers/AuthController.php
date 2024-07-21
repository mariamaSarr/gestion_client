<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../config/pdo.php';
require_once __DIR__ . '/../../app/models/User.php';

class AuthController {
    private $userModel;

    public function __construct() {
        global $pdo; // Utilisation de la connexion PDO globale
        if (!$pdo) {
            throw new Exception('La connexion à la base de données a échoué.');
        }
        $this->userModel = new User($pdo);
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
            
            $user = $this->userModel->findUserByUsername($username);
            
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                header('Location: /gestion_clients/publics/accueil.php');
                exit;
            } else {
                $error = 'Nom d\'utilisateur ou mot de passe incorrect';
                require __DIR__ . '/../../views/auth/login.php'; // Assurez-vous que le chemin est correct
            }
        } else {
            require_once __DIR__ . '/gestion_clients/publics/accueil.php'; // Assurez-vous que le chemin est correct
        }
    }
    
}
?>
