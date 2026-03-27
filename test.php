<?php
// fichier de test - plus vraiment utile mais je laisse au cas où
require_once(__DIR__ . '/config/mysql.php');
require_once(__DIR__ . '/databaseconnect.php');

// test connexion bdd
echo "connexion ok<br>";

// test récup recettes
$stmt = $mysqlClient->query('SELECT COUNT(*) as nb FROM recipes');
$res = $stmt->fetch();
echo "nb recettes : " . $res['nb'] . "<br>";

// test récup users
$stmt2 = $mysqlClient->query('SELECT COUNT(*) as nb FROM users');
$res2 = $stmt2->fetch();
echo "nb users : " . $res2['nb'] . "<br>";

// $stmt3 = $mysqlClient->query('SELECT * FROM recipes');
// var_dump($stmt3->fetchAll());
