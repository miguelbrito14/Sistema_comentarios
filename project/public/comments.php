<?php 
require_once "../partials/header.php";
require_once "../config/database.php";

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

// Função recursiva para mostrar comentários e respostas
function displayComments($comments, $parentId = null, $level = 0) {
    foreach ($comments as $c) {
        if ($c['parent_id'] == $parentId) {
            $margin = $level * 20;
            echo '<div class="card mt-3" style="margin-left:' . $margin . 'px">';
            echo '<div class="card-body">';
            echo '<h5>' . htmlspecialchars($c['username']) . '</h5>';
            echo '<p>' . nl2br(htmlspecialchars($c['comment'])) . '</p>';
            echo '<small class="text-muted">' . $c['created_at'] . '</small>';

            // Formulário de resposta
            echo '<form action="../actions/comment_action.php" method="POST" class="mt-2">';
            echo '<input type="hidden" name="parent_id" value="' . $c['id'] . '">';
            echo '<textarea name="comment" class="form-control" placeholder="Responder..." required></textarea>';
            echo '<button class="btn btn-sm btn-secondary mt-2">Responder</button>';
            echo '</form>';

            echo '</div></div>';

            // Chamada recursiva para respostas
            displayComments($comments, $c['id'], $level + 1);
        }
    }
}

// Pegar todos os comentários
$stmt = $pdo->query("
    SELECT comments.*, users.username
    FROM comments
    JOIN users ON users.id = comments.user_id
    ORDER BY comments.id DESC
");
$allComments = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Comentários</h2>

<form action="../actions/comment_action.php" method="POST" class="mt-3">
    <textarea name="comment" class="form-control" placeholder="Escreva um comentário..." required></textarea>
    <button class="btn btn-primary mt-3">Publicar</button>
</form>

<hr>

<h3>Todos os Comentários</h3>

<?php displayComments($allComments); ?>

<?php require_once "../partials/footer.php"; ?>
