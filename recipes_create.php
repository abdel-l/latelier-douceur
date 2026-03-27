<?php
require_once(__DIR__ . '/isConnect.php');
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
    <title>L'Atelier Douceur - Ajouter un dessert</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">

    <?php require_once(__DIR__ . '/header.php'); ?>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <h1 class="fw-bold mb-4">Ajouter un dessert</h1>
                <div class="card">
                    <div class="card-body p-4">
                        <form action="recipes_post_create.php" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="title" class="form-label">Nom du dessert</label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="Tiramisu, Fondant au chocolat..." required>
                            </div>
                            <div class="mb-3">
                                <label for="recipe" class="form-label">Préparation</label>
                                <textarea class="form-control" id="recipe" name="recipe" rows="8"
                                          placeholder="Ingrédients et étapes de préparation..."></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label">Photo du dessert (optionnel)</label>
                                <input type="file" class="form-control" id="image" name="image"
                                       accept="image/jpeg,image/png,image/gif,image/webp">
                                <div class="form-text">Formats acceptés : jpg, png, gif, webp. Max 2 Mo.</div>
                            </div>
                            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Publier le dessert</button>
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
