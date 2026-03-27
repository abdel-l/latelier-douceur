<?php
require_once(__DIR__ . '/isConnect.php');
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$getData = $_GET;

if (!isset($getData['id']) || !is_numeric($getData['id'])) {
    echo('Il faut un identifiant pour supprimer la recette.');
    return;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>L'Atelier Douceur - Supprimer le dessert</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">

    <?php require_once(__DIR__ . '/header.php'); ?>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-5 text-center">
                <div class="card">
                    <div class="card-body p-5">
                        <div style="font-size:3rem;" class="mb-3">🗑️</div>
                        <h2 class="fw-bold mb-3">Supprimer ce dessert ?</h2>
                        <p class="text-muted mb-4">Cette action est irréversible.</p>
                        <form action="recipes_post_delete.php" method="POST">
                            <input type="hidden" name="id" value="<?php echo (int)$getData['id']; ?>">
                            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                            <div class="d-flex gap-3 justify-content-center">
                                <a href="javascript:history.back()" class="btn btn-outline-secondary px-4">Annuler</a>
                                <button type="submit" class="btn btn-danger px-4">Supprimer définitivement</button>
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
