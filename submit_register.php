<?php
session_start();
require_once(__DIR__ . '/config/mysql.php');
require_once(__DIR__ . '/databaseconnect.php');
require_once(__DIR__ . '/functions.php');

if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    die('Erreur : token CSRF invalide. Action non autorisée.');
}

$postData = $_POST;

// vérifie que tous les champs sont remplis
if (
    empty($postData['first_name'])
    || empty($postData['last_name'])
    || empty($postData['username'])
    || empty($postData['email'])
    || empty($postData['password'])
    || !filter_var($postData['email'], FILTER_VALIDATE_EMAIL)
) {
    $_SESSION['REGISTER_ERROR_MESSAGE'] = 'Tous les champs sont obligatoires et doivent être valides.';
    redirectToUrl('register.php');
}

$prenom   = trim(strip_tags($postData['first_name']));
$nom      = trim(strip_tags($postData['last_name']));
$username = trim(strip_tags($postData['username']));
$email    = $postData['email'];
$password = $postData['password'];

// check si l'email ou le pseudo existe déjà
$checkStatement = $mysqlClient->prepare('SELECT user_id FROM users WHERE email = :email OR username = :username');
$checkStatement->execute(['email' => $email, 'username' => $username]);

if ($checkStatement->fetch()) {
    $_SESSION['REGISTER_ERROR_MESSAGE'] = 'Cet email ou ce nom d\'utilisateur est déjà utilisé.';
    redirectToUrl('register.php');
}

// inscription de l'utilisateur (mdp hashé)
$insertStatement = $mysqlClient->prepare(
    'INSERT INTO users(first_name, last_name, username, email, password) VALUES (:first_name, :last_name, :username, :email, :password)'
);
$insertStatement->execute([
    'first_name' => $prenom,
    'last_name'  => $nom,
    'username'   => $username,
    'email'      => $email,
    'password'   => password_hash($password, PASSWORD_BCRYPT),
]);

// connecte l'user direct après inscription
$_SESSION['LOGGED_USER'] = [
    'email'    => $email,
    'username' => $username,
    'user_id'  => $mysqlClient->lastInsertId(),
];

redirectToUrl('index.php');
