<?php

require_once(__DIR__ . '/isConnect.php');
require_once(__DIR__ . '/config/mysql.php');
require_once(__DIR__ . '/databaseconnect.php');
require_once(__DIR__ . '/functions.php');

if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    die('Erreur : token CSRF invalide. Action non autorisée.');
}

$postData = $_POST;

if (!isset($postData['id']) || !is_numeric($postData['id'])) {
    echo 'Il faut un identifiant valide pour supprimer une recette.';
    return;
}

// FIXME: même problème que pour l'update, pas de vérif du propriétaire
// n'importe quel user connecté peut supprimer n'importe quelle recette

// supprime la recette
$stmt = $mysqlClient->prepare('DELETE FROM recipes WHERE recipe_id = :id');
$stmt->execute([
    'id' => (int)$postData['id'],
]);

redirectToUrl('index.php');
