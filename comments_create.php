<?php
require_once(__DIR__ . '/isConnect.php');
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>

<form action="comments_post_create.php" method="POST">
    <input type="hidden" name="recipe_id" value="<?php echo (int)$recipe['recipe_id']; ?>">
    <div class="mb-3">
        <label for="comment" class="form-label fw-bold">Laisser un commentaire</label>
        <textarea class="form-control" id="comment" name="comment" rows="3"
                  placeholder="Partagez votre avis..."></textarea>
    </div>
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
    <button type="submit" class="btn btn-primary">Publier</button>
</form>
