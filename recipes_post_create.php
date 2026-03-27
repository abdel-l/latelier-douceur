<?php
require_once(__DIR__ . '/isConnect.php');
require_once(__DIR__ . '/config/mysql.php');
require_once(__DIR__ . '/databaseconnect.php');

if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    die('Erreur : token CSRF invalide. Action non autorisée.');
}

$postData = $_POST;

if (
    empty($postData['title'])
    || empty($postData['recipe'])
    || trim(strip_tags($postData['title'])) === ''
    || trim(strip_tags($postData['recipe'])) === ''
) {
    echo 'Il faut un titre et une préparation pour soumettre le formulaire.';
    return;
}

$titre   = trim(strip_tags($postData['title']));
$contenu = trim(strip_tags($postData['recipe']));

// upload de l'image si y'en a une
$imageName = null;
if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
    if ($_FILES['image']['size'] > 2000000) {
        echo 'Image trop volumineuse (max 2 Mo).';
        return;
    }
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    if (!in_array($_FILES['image']['type'], $allowedTypes)) {
        echo 'Format d\'image non autorisé.';
        return;
    }
    $ext       = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $imageName = uniqid('recipe_', true) . '.' . $ext;
    move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . '/uploads/' . $imageName);
    // echo "DEBUG image : " . $imageName; // debug
}

$insertRecipe = $mysqlClient->prepare('INSERT INTO recipes(title, recipe, author, is_enabled, image) VALUES (:title, :recipe, :author, :is_enabled, :image)');
$insertRecipe->execute([
    'title'      => $titre,
    'recipe'     => $contenu,
    'is_enabled' => 1,
    'author'     => $_SESSION['LOGGED_USER']['email'],
    'image'      => $imageName,
]);

header('Location: recettes.php');
exit();
