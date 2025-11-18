<?php 
require_once "../partials/header.php";
require_once "../config/database.php";

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

?>

<h2>Comentários</h2>

<form action="../actions/comment_action.php" method="POST" class="mt-3">
    <textarea name="comment" class="form-control" placeholder="Escreva um comentário..." required></textarea>
    <button class="btn btn-primary mt-3">Publicar</button>
</form>

<hr>

<h3>Todos os Comentários</h3>

<?php
$stmt = $pdo->query("
    SELECT comments.*, users.username 
    FROM comments
    JOIN users ON users.id = comments.user_id
    ORDER BY comments.id DESC
");

while ($c = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
    <div class="card mt-3">
        <div class="card-body">
            <h5><?= htmlspecialchars($c['username']) ?></h5>
            <p><?= nl2br(htmlspecialchars($c['comment'])) ?></p>
            <small class="text-muted"><?= $c['created_at'] ?></small>
        </div>
    </div>
<?php endwhile; ?>


<?php require_once "../partials/footer.php"; ?>
