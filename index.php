<?php
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 0);
session_start();
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
require_once(__DIR__ . '/config/mysql.php');
require_once(__DIR__ . '/databaseconnect.php');
require_once(__DIR__ . '/variables.php');
require_once(__DIR__ . '/functions.php');

$validRecipes = getRecipes($recipes);
$totalRecipes = count($validRecipes);
$totalUsers   = count($users);

$commentsStatement = $mysqlClient->prepare('SELECT COUNT(*) as total FROM comments');
$commentsStatement->execute();
$totalComments = $commentsStatement->fetch(PDO::FETCH_ASSOC)['total'];

$topRecipes = array_slice($validRecipes, 0, 6);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>L'Atelier Douceur - Accueil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">

    <?php require_once(__DIR__ . '/header.php'); ?>

    <?php if (isset($_SESSION['LOGGED_USER'])) : ?>
        <div class="container mt-3">
            <div class="alert alert-bienvenue alert-dismissible fade show" role="alert" id="welcomeMessage">
                Bienvenue <strong><?php echo htmlspecialchars($_SESSION['LOGGED_USER']['username']); ?></strong> !
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
        <script>
        setTimeout(function() {
            var alert = document.getElementById('welcomeMessage');
            if (alert) {
                var bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }
        }, 5000);
        </script>
    <?php endif; ?>

    <!-- HERO -->
    <section class="hero text-center">
        <div class="container">
            <h1>L'Atelier Douceur</h1>
            <p class="mb-5">Partagez et découvrez des desserts du monde entier</p>
            <div class="d-flex gap-3 justify-content-center flex-wrap">
                <a href="recettes.php" class="btn btn-primary btn-lg px-5 fw-bold">
                    Voir tous les desserts
                </a>
                <?php if (!isset($_SESSION['LOGGED_USER'])) : ?>
                    <a href="register.php" class="btn btn-outline-light btn-lg px-5">
                        S'inscrire gratuitement
                    </a>
                <?php else : ?>
                    <a href="recipes_create.php" class="btn btn-outline-light btn-lg px-5">
                        Ajouter un dessert
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <div class="container">

        <!-- STATS -->
        <section>
            <div class="row g-3">
                <div class="col-6 col-md-4">
                    <div class="card stat-card text-center p-4">
                        <div class="stat-icon">🍰</div>
                        <div class="fw-bold fs-2 mt-1"><?php echo $totalRecipes; ?></div>
                        <div class="text-muted">Desserts publiés</div>
                    </div>
                </div>
                <div class="col-6 col-md-4">
                    <div class="card stat-card text-center p-4">
                        <div class="stat-icon">👨‍🍳</div>
                        <div class="fw-bold fs-2 mt-1"><?php echo $totalUsers; ?></div>
                        <div class="text-muted">Cuisiniers inscrits</div>
                    </div>
                </div>
                <div class="col-6 col-md-4">
                    <div class="card stat-card text-center p-4">
                        <div class="stat-icon">💬</div>
                        <div class="fw-bold fs-2 mt-1"><?php echo $totalComments; ?></div>
                        <div class="text-muted">Commentaires postés</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- COUPS DE CŒUR -->
        <section>
            <h2 class="section-title text-center">Nos coups de cœur</h2>

            <?php if (empty($topRecipes)) : ?>
                <p class="text-center text-muted">Aucun dessert pour l'instant.</p>
            <?php else : ?>
                <div class="row g-4">
                    <?php foreach ($topRecipes as $recipe) :
                        $excerpt = mb_substr(strip_tags($recipe['recipe']), 0, 100);
                        if (mb_strlen(strip_tags($recipe['recipe'])) > 100) $excerpt .= '…';
                        $isOwner = isset($_SESSION['LOGGED_USER']) && $recipe['author'] === $_SESSION['LOGGED_USER']['email'];
                    ?>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card recipe-card">
                            <?php if (!empty($recipe['image'])) : ?>
                                <img src="<?php echo htmlspecialchars($recipe['image']); ?>"
                                     alt="<?php echo htmlspecialchars($recipe['title']); ?>"
                                     class="card-img-top"
                                     style="height:180px; object-fit:cover; border-radius:10px 10px 0 0;">
                            <?php endif; ?>
                            <div class="card-body d-flex flex-column p-4">
                                <h5 class="card-title"><?php echo htmlspecialchars($recipe['title']); ?></h5>
                                <div class="mb-2">
                                    <span class="author-badge">👤 <?php echo htmlspecialchars(displayAuthor($recipe['author'], $users)); ?></span>
                                </div>
                                <p class="excerpt flex-grow-1"><?php echo htmlspecialchars($excerpt); ?></p>
                                <div class="d-flex gap-2 mt-auto flex-wrap">
                                    <a href="recipes_read.php?id=<?php echo $recipe['recipe_id']; ?>" class="btn btn-danger btn-sm">
                                        Voir le dessert
                                    </a>
                                    <?php if ($isOwner) : ?>
                                        <a href="recipes_update.php?id=<?php echo $recipe['recipe_id']; ?>" class="btn btn-warning btn-sm">✏️</a>
                                        <a href="recipes_delete.php?id=<?php echo $recipe['recipe_id']; ?>" class="btn btn-outline-danger btn-sm">🗑️</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <div class="text-center mt-5">
                    <a href="recettes.php" class="btn btn-danger btn-lg px-5 fw-bold">
                        Voir tous les desserts →
                    </a>
                </div>
            <?php endif; ?>
        </section>

        <!-- POURQUOI L'ATELIER DOUCEUR ? -->
        <section>
            <h2 class="section-title text-center">Pourquoi L'Atelier Douceur ?</h2>
            <div class="row g-4">
                <div class="col-12 col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon mb-3">🍰</div>
                        <h5 class="fw-bold">Partagez vos desserts</h5>
                        <p class="text-muted mb-0">
                            Publiez vos créations sucrées et faites découvrir vos talents à une communauté passionnée de pâtisserie.
                        </p>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon mb-3">🌍</div>
                        <h5 class="fw-bold">Découvrez le monde</h5>
                        <p class="text-muted mb-0">
                            Explorez des desserts venus des quatre coins du monde et trouvez votre prochain coup de cœur.
                        </p>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon mb-3">💬</div>
                        <h5 class="fw-bold">Commentez</h5>
                        <p class="text-muted mb-0">
                            Donnez votre avis et échangez avec la communauté pour trouver les meilleures créations.
                        </p>
                    </div>
                </div>
            </div>
        </section>

    </div>

    <?php require_once(__DIR__ . '/footer.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
