<?php
require_once(__DIR__ . '/config/mysql.php');
require_once(__DIR__ . '/databaseconnect.php');

echo "<h1>Migration des mots de passe vers hash sécurisé</h1>";

// Récupérer tous les utilisateurs
$stmt = $mysqlClient->query("SELECT user_id, email, password FROM users");
$users = $stmt->fetchAll();

foreach ($users as $user) {
    // Si le mot de passe n'est pas déjà hashé (commence par $2y$)
    if (substr($user['password'], 0, 4) !== '$2y$') {
        $hashedPassword = password_hash($user['password'], PASSWORD_DEFAULT);

        $updateStmt = $mysqlClient->prepare("UPDATE users SET password = ? WHERE user_id = ?");
        $updateStmt->execute([$hashedPassword, $user['user_id']]);

        echo "✅ Mot de passe hashé pour : " . htmlspecialchars($user['email']) . "<br>";
    } else {
        echo "⏭️ Déjà hashé : " . htmlspecialchars($user['email']) . "<br>";
    }
}

echo "<br><strong>✅ Migration terminée ! Tu peux supprimer ce fichier maintenant.</strong>";
