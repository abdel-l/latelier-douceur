<?php
// ancienne version de submit_login.php - gardé au cas où
// j'avais fait ça avant de passer aux requêtes préparées

/*

session_start();

$postData = $_POST;

if (isset($postData['email']) && isset($postData['password'])) {

    require_once('config/mysql.php');

    // ancienne connexion sans PDO, à ne plus utiliser
    $conn = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_NAME);

    if (!$conn) {
        die("Erreur connexion : " . mysqli_connect_error());
    }

    // ATTENTION : ancienne version sans requête préparée = injection SQL possible !!!
    $email = $postData['email'];
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        if ($user['password'] === $postData['password']) { // mot de passe en clair, nul
            $_SESSION['LOGGED_USER'] = $user;
            header('Location: index.php');
        } else {
            echo "Mot de passe incorrect";
        }
    } else {
        echo "Utilisateur introuvable";
    }

    mysqli_close($conn);
}

*/

// nouvelle version : voir submit_login.php
// j'ai refait tout ça avec PDO et les requêtes préparées
// beaucoup plus sécurisé
