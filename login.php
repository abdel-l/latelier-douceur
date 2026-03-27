<?php
session_start();
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
require_once(__DIR__ . '/functions.php');

// Si déjà connecté, rediriger vers l'accueil
if (isset($_SESSION['LOGGED_USER'])) {
    redirectToUrl('index.php');
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>L'Atelier Douceur - Connexion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">

    <?php require_once(__DIR__ . '/header.php'); ?>

    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-5">
                <div class="card">
                    <div class="card-body p-4">
                        <h2 class="card-title text-center mb-4">Connexion</h2>

                        <?php if (isset($_SESSION['LOGIN_ERROR_MESSAGE'])) : ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $_SESSION['LOGIN_ERROR_MESSAGE'];
                                unset($_SESSION['LOGIN_ERROR_MESSAGE']); ?>
                            </div>
                        <?php endif; ?>

                        <form action="submit_login.php" method="POST">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="vous@exemple.com" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Mot de passe</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Se connecter</button>
                            </div>
                        </form>
                        <hr>
                        <p class="text-center mb-0">Pas encore de compte ? <a href="register.php">S'inscrire</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require_once(__DIR__ . '/footer.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
