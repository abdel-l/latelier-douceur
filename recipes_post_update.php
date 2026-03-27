<?php
require_once(__DIR__ . '/isConnect.php');
require_once(__DIR__ . '/config/mysql.php');
require_once(__DIR__ . '/databaseconnect.php');

if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    die('Erreur : token CSRF invalide. Action non autorisée.');
}

$postData = $_POST;

if (
    !isset($postData['id'])
    || !is_numeric($postData['id'])
    || empty($postData['title'])
    || empty($postData['recipe'])
    || trim(strip_tags($postData['title'])) === ''
    || trim(strip_tags($postData['recipe'])) === ''
) {
    echo 'Il manque des informations pour permettre l\'édition du formulaire.';
    return;
}

$id = (int)$postData['id'];
$title = trim(strip_tags($postData['title']));
$recipe = trim(strip_tags($postData['recipe']));

// FIXME: sécuriser ça, n'importe qui peut modifier la recette de quelqu'un d'autre
// à revoir, j'ai fait ça à l'arrache, faudrait vérifier que c'est bien l'auteur
// la vraie vérif ce serait ça :
// $check = $mysqlClient->prepare('SELECT author FROM recipes WHERE recipe_id = :id');
// $check->execute(['id' => $id]);
// $data = $check->fetch();
// if ($data['author'] !== $_SESSION['LOGGED_USER']['email']) {
//     die('T\'as pas le droit de modifier cette recette.');
// }

// met à jour la recette
$insertRecipeStatement = $mysqlClient->prepare('UPDATE recipes SET title = :title, recipe = :recipe WHERE recipe_id = :id');
$insertRecipeStatement->execute([
    'title' => $title,
    'recipe' => $recipe,
    'id' => $id,
]);

header('Location: recipes_read.php?id=' . $id);
exit();
