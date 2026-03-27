<?php
header('Content-Type: text/html; charset=UTF-8');
session_start();
require_once(__DIR__ . '/config/mysql.php');
require_once(__DIR__ . '/databaseconnect.php');
require_once(__DIR__ . '/variables.php');
require_once(__DIR__ . '/functions.php');

$getData = $_GET;

if (!isset($getData['id']) || !is_numeric($getData['id'])) {
    echo('La recette n\'existe pas');
    return;
}

// j'ai galéré sur cette partie, la jointure avec les commentaires c'était pas évident
// var_dump($getData); // debug
$retrieveRecipeWithCommentsStatement = $mysqlClient->prepare('SELECT r.*, c.comment_id, c.comment, c.user_id, DATE_FORMAT(c.created_at, "%d/%m/%Y") as comment_date, u.username FROM recipes r
LEFT JOIN comments c on c.recipe_id = r.recipe_id
LEFT JOIN users u ON u.user_id = c.user_id
WHERE r.recipe_id = :id
ORDER BY comment_date DESC');
$retrieveRecipeWithCommentsStatement->execute([
    'id' => (int)$getData['id'],
]);
$recipeWithComments = $retrieveRecipeWithCommentsStatement->fetchAll(PDO::FETCH_ASSOC);

if ($recipeWithComments === []) {
    echo('La recette n\'existe pas');
    return;
}
$recipe = [
    'recipe_id' => $recipeWithComments[0]['recipe_id'],
    'title'     => $recipeWithComments[0]['title'],
    'recipe'    => $recipeWithComments[0]['recipe'],
    'author'    => $recipeWithComments[0]['author'],
    'image'     => $recipeWithComments[0]['image'],
    'comments'  => [],
];

foreach ($recipeWithComments as $comment) {
    if (!is_null($comment['comment_id'])) {
        $recipe['comments'][] = [
            'comment_id' => $comment['comment_id'],
            'comment'    => $comment['comment'],
            'user_id'    => (int) $comment['user_id'],
            'username'   => $comment['username'],
            'created_at' => $comment['comment_date'],
        ];
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>L'Atelier Douceur - <?php echo htmlspecialchars($recipe['title']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">

    <?php require_once(__DIR__ . '/header.php'); ?>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                <?php if ($recipe['image']) : ?>
                    <img src="<?php echo htmlspecialchars($recipe['image']); ?>"
                         alt="<?php echo htmlspecialchars($recipe['title']); ?>"
                         class="img-fluid rounded mb-4"
                         style="max-height:400px; width:100%; object-fit:cover;">
                <?php endif; ?>

                <h1 class="fw-bold mb-1"><?php echo htmlspecialchars($recipe['title']); ?></h1>
                <p class="text-muted mb-4">Publié par <em><?php echo htmlspecialchars(displayAuthor($recipe['author'], $users)); ?></em></p>

                <div class="card mb-5">
                    <div class="card-body p-4">
                        <div class="recipe-content"><?php echo htmlspecialchars($recipe['recipe']); ?></div>
                    </div>
                </div>

                <!-- COMMENTAIRES -->
                <h2 class="fw-bold mb-3">Commentaires</h2>

                <?php if ($recipe['comments'] !== []) : ?>
                    <?php foreach ($recipe['comments'] as $comment) : ?>
                        <div class="comment-card">
                            <div class="comment-meta mb-1">
                                <strong><?php echo htmlspecialchars($comment['username']); ?></strong>
                                &mdash; <?php echo htmlspecialchars($comment['created_at']); ?>
                            </div>
                            <p class="mb-0"><?php echo htmlspecialchars($comment['comment']); ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <p class="text-muted">Aucun commentaire pour l'instant.</p>
                <?php endif; ?>

                <?php if (isset($_SESSION['LOGGED_USER'])) : ?>
                    <hr class="my-4">
                    <?php require_once(__DIR__ . '/comments_create.php'); ?>
                <?php endif; ?>

            </div>
        </div>
    </div>

    <?php require_once(__DIR__ . '/footer.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
