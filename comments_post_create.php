<?php
require_once(__DIR__ . '/isConnect.php');
require_once(__DIR__ . '/config/mysql.php');
require_once(__DIR__ . '/databaseconnect.php');

if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    die('Erreur : token CSRF invalide. Action non autorisée.');
}

$postData = $_POST;

if (
    !isset($postData['comment']) ||
    !isset($postData['recipe_id']) ||
    !is_numeric($postData['recipe_id'])
) {
    echo('Le commentaire est invalide.');
    return;
}

$comment  = trim(strip_tags($postData['comment']));
$recipeId = (int)$postData['recipe_id'];

if ($comment === '') {
    echo 'Le commentaire ne peut pas être vide.';
    return;
}

$insertRecipe = $mysqlClient->prepare('INSERT INTO comments(comment, recipe_id, user_id) VALUES (:comment, :recipe_id, :user_id)');
$insertRecipe->execute([
    'comment'   => $comment,
    'recipe_id' => $recipeId,
    'user_id'   => $_SESSION['LOGGED_USER']['user_id'],
]);

header('Location: recipes_read.php?id=' . $recipeId);
exit();
