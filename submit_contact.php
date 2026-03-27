<?php
session_start();

if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    die('Erreur : token CSRF invalide. Action non autorisée.');
}

$postData = $_POST;

// si l'user est connecté on prend son email
if (isset($_SESSION['LOGGED_USER'])) {
    $postData['email'] = $_SESSION['LOGGED_USER']['email'];
}

if (
    !isset($postData['email'])
    || !filter_var($postData['email'], FILTER_VALIDATE_EMAIL)
    || empty($postData['message'])
    || trim($postData['message']) === ''
) {
    echo('Il faut un email et un message valides pour soumettre le formulaire.');
    return;
}

// upload de la capture d'écran si y'en a une
if (isset($_FILES['screenshot']) && $_FILES['screenshot']['error'] === 0) {
    if ($_FILES['screenshot']['size'] > 1000000) {
        echo "L'envoi n'a pas pu être effectué, image trop volumineuse (max 1 Mo).";
        return;
    }
    $fileInfo  = pathinfo($_FILES['screenshot']['name']);
    $extension = $fileInfo['extension'];
    if (!in_array($extension, ['jpg', 'jpeg', 'gif', 'png'])) {
        echo "L'envoi n'a pas pu être effectué, l'extension {$extension} n'est pas autorisée.";
        return;
    }
    $path = __DIR__ . '/uploads/';
    if (!is_dir($path)) {
        echo "L'envoi n'a pas pu être effectué, le dossier uploads est manquant.";
        return;
    }
    move_uploaded_file($_FILES['screenshot']['tmp_name'], $path . basename($_FILES['screenshot']['name']));
}

header('Location: index.php');
exit();
