<?php 
require_once "../partials/header.php";
require_once "../config/database.php";

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

// PEGAR TODOS OS COMENTÁRIOS
$stmt = $pdo->query("
    SELECT c.*, u.username 
    FROM comments c
    JOIN users u ON u.id = c.user_id
    ORDER BY c.id ASC
");
$comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

// ORGANIZAR EM ÁRVORE
function organizeComments($comments) {
    $tree = [];
    foreach ($comments as $c) {
        $tree[$c['parent_id']][] = $c;
    }
    return $tree;
}

$tree = organizeComments($comments);

// FUNÇÃO RECURSIVA PARA EXIBIR
function showComments($tree, $parent = null, $level = 0) {
    if (!isset($tree[$parent])) return;

    foreach ($tree[$parent] as $c) {

        echo '<div class="comment '.($level > 0 ? "reply" : "").'">
                <strong>'.$c['username'].'</strong><br>
                '.nl2br(htmlspecialchars($c['comment'])).'
                <div class="text-muted small">'.$c['created_at'].'</div>

                <button class="btn btn-sm btn-link p-0 mt-1" onclick="toggleForm('.$c['id'].')">Responder</button>

                <form id="form-'.$c['id'].'" 
                      action="../actions/comment_action.php" 
                      method="POST" 
                      class="reply-form d-none mt-2">
                    
                    <input type="hidden" name="parent_id" value="'.$c['id'].'">
                    <textarea name="comment" class="form-control" rows="1" placeholder="Escreva uma resposta..." required></textarea>
                    <button class="btn btn-primary btn-sm mt-1">Enviar</button>
                </form>
              </div>';

        showComments($tree, $c['id'], $level + 1);
    }
}

?>

<h2>Comentários</h2>

<form action="../actions/comment_action.php" method="POST" class="mt-3">
    <textarea name="comment" class="form-control" placeholder="Escreva um comentário..." required></textarea>
    <button class="btn btn-primary mt-3">Publicar</button>
</form>

<hr>

<div class="card p-3">
    <h4>Todos os comentários</h4>
    <?php showComments($tree); ?>
</div>

<style>
    /* Estilo igual Instagram */

    .comment {
        padding: 10px 0;
        border-bottom: 1px solid #eee;
    }

    .reply {
        margin-left: 40px;
        border-left: 2px solid #ddd;
        padding-left: 10px;
    }

    .reply-form {
        margin-left: 40px;
    }

    .comment:last-child {
        border-bottom: none;
    }
</style>

<script>
function toggleForm(id){
    document.getElementById("form-"+id).classList.toggle("d-none");
}
</script>

<?php require_once "../partials/footer.php"; ?>
