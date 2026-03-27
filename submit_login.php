<?php
session_start();

require_once(__DIR__ . '/config/mysql.php');
require_once(__DIR__ . '/databaseconnect.php');
require_once(__DIR__ . '/variables.php');
require_once(__DIR__ . '/functions.php');

if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    die('Erreur : token CSRF invalide. Action non autorisée.');
}

$postData = $_POST;

if (isset($postData['email']) && isset($postData['password'])) {
    if (!filter_var($postData['email'], FILTER_VALIDATE_EMAIL)) {
        $_SESSION['LOGIN_ERROR_MESSAGE'] = 'Il faut un email valide pour soumettre le formulaire.';
    } else {
        // cherche l'user dans la bdd
        // je sais pas si c'est optimal mais ça marche
        $stmt = $mysqlClient->prepare('SELECT user_id, email, username, password FROM users WHERE email = :email');
        $stmt->execute(['email' => $postData['email']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // check le mdp
        if ($user && password_verify($postData['password'], $user['password'])) {
            $_SESSION['LOGGED_USER'] = [
                'email'    => $user['email'],
                'username' => $user['username'],
                'user_id'  => $user['user_id'],
            ];
            session_regenerate_id(true);
            redirectToUrl('index.php');
        } else {
            $_SESSION['LOGIN_ERROR_MESSAGE'] = 'Email ou mot de passe incorrect.';
            redirectToUrl('login.php');
        }
    }

    redirectToUrl('login.php');
}
