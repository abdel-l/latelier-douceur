<?php

// TODO: optimiser plus tard, pour l'instant on charge tous les users
// idéalement faudrait faire une jointure plutôt que tout charger en mémoire
$usersStatement = $mysqlClient->prepare('SELECT * FROM users');
$usersStatement->execute();
$users = $usersStatement->fetchAll();

$recipesStatement = $mysqlClient->prepare('SELECT * FROM recipes WHERE is_enabled is TRUE');
$recipesStatement->execute();
$recipes = $recipesStatement->fetchAll();

// j'aurais pu faire une jointure mais j'avais pas compris comment au début
// du coup je récupère le nom de l'auteur pour chaque recette
foreach ($recipes as &$recipe) {
    $tmp = $mysqlClient->prepare('SELECT username FROM users WHERE email = :email');
    $tmp->execute(['email' => $recipe['author']]);
    $auteur = $tmp->fetch();
    $recipe['author_name'] = $auteur ? $auteur['username'] : 'Inconnu';
}
unset($recipe);
