<?php
session_start();
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>L'Atelier Douceur - Contact</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">

    <?php require_once(__DIR__ . '/header.php'); ?>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <h1 class="fw-bold mb-4">Contactez-nous</h1>
                <div class="card">
                    <div class="card-body p-4">
                        <form action="submit_contact.php" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <?php if (isset($_SESSION['LOGGED_USER'])) : ?>
                                    <input type="email" class="form-control" id="email" name="email"
                                           value="<?php echo htmlspecialchars($_SESSION['LOGGED_USER']['email']); ?>" readonly>
                                <?php else : ?>
                                    <input type="email" class="form-control" id="email" name="email"
                                           placeholder="vous@exemple.com" aria-describedby="email-help">
                                <?php endif; ?>
                                <div id="email-help" class="form-text">Nous ne revendrons pas votre email.</div>
                            </div>
                            <div class="mb-3">
                                <label for="message" class="form-label">Votre message</label>
                                <textarea class="form-control" placeholder="Exprimez-vous" id="message" name="message" rows="5"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="screenshot" class="form-label">Capture d'écran (optionnel)</label>
                                <input type="file" class="form-control" id="screenshot" name="screenshot">
                            </div>
                            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Envoyer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require_once(__DIR__ . '/footer.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
