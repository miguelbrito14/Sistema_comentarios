<?php 
require_once "../partials/header.php";
require_once "../config/database.php";

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

// Mostrar mensagens
if (isset($_SESSION['flash'])) {
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            ' . $_SESSION['flash'] . '
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>';
    unset($_SESSION['flash']);
}

if (isset($_SESSION['flash_success'])) {
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            ' . $_SESSION['flash_success'] . '
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>';
    unset($_SESSION['flash_success']);
}

// PEGAR TODOS OS COMENTÁRIOS
$stmt = $pdo->query("
    SELECT c.*, u.username, u.photo as user_photo
    FROM comments c
    JOIN users u ON u.id = c.user_id
    ORDER BY c.created_at DESC
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

// FUNÇÃO RECURSIVA — COM FOTOS
function showComments($tree, $parent = null, $level = 0) {
    if (!isset($tree[$parent])) return;

    foreach ($tree[$parent] as $c) {
        $userPhoto = !empty($c['user_photo']) ? "../uploads/" . $c['user_photo'] : 'https://via.placeholder.com/40x40/007bff/ffffff?text=' . substr($c['username'], 0, 1);
        
        echo '
        <div class="comment-box '.($level > 0 ? "reply-box" : "").'">
            <div class="comment-header">
                <img src="'.$userPhoto.'" class="avatar" alt="'.$c['username'].'">
                <strong class="username">'.$c['username'].'</strong>
                <span class="time small">'.date('d/m/Y H:i', strtotime($c['created_at'])).'</span>
            </div>';

        // Mostrar foto do comentário se existir
        if (!empty($c['foto'])) {
            echo '
            <div class="comment-photo-container mt-2">
                <img src="../uploads/comentarios/'.$c['foto'].'" 
                     alt="Foto do comentário" 
                     class="comment-photo"
                     onclick="openModal(this.src)">
            </div>';
        }

        // Mostrar texto do comentário se existir
        if (!empty($c['comment'])) {
            echo '<div class="comment-text">'.nl2br(htmlspecialchars($c['comment'])).'</div>';
        }

        echo '
            <button class="btn-reply" onclick="toggleForm('.$c['id'].')">Responder</button>

            <form id="form-'.$c['id'].'" 
                  action="../actions/comment_action.php" 
                  method="POST" 
                  enctype="multipart/form-data"
                  class="reply-form d-none mt-2">
                
                <input type="hidden" name="parent_id" value="'.$c['id'].'">
                <textarea name="comment" class="form-control comment-input" rows="2" placeholder="Responda aqui..."></textarea>
                
                <div class="mt-2">
                    <label class="small text-muted">Adicionar foto (opcional):</label>
                    <input type="file" name="foto" class="form-control form-control-sm" accept="image/*" onchange="previewImage(this, '.$c['id'].')">
                </div>
                
                <div class="preview-container mt-2" id="preview-'.$c['id'].'" style="display:none;">
                    <img class="preview-image" style="max-width: 150px; border-radius: 5px;">
                    <button type="button" class="btn btn-sm btn-outline-danger ms-2" onclick="removeImage('.$c['id'].')">Remover</button>
                </div>
                
                <button class="btn-send mt-2" type="submit">Enviar</button>
            </form>
        </div>';

        showComments($tree, $c['id'], $level + 1);
    }
}
?>

<h2 class="title-main">Comentários</h2>

<div class="new-comment-box">
    <form action="../actions/comment_action.php" method="POST" enctype="multipart/form-data">
        <textarea name="comment" class="form-control main-input" placeholder="Escreva algo..."></textarea>
        
        <div class="mt-2">
            <label class="small text-muted">Adicionar foto (opcional):</label>
            <input type="file" name="foto" id="fotoPrincipal" class="form-control" accept="image/*" onchange="previewImage(this, 'principal')">
        </div>
        
        <div class="preview-container mt-2" id="preview-principal" style="display:none;">
            <img class="preview-image" style="max-width: 200px; border-radius: 5px;">
            <button type="button" class="btn btn-sm btn-outline-danger ms-2" onclick="removeImage('principal')">Remover</button>
        </div>
        
        <button class="btn-publicar mt-3" type="submit">Publicar</button>
    </form>
</div>

<div class="comments-container mt-4">
    <?php showComments($tree); ?>
</div>

<!-- Modal para visualizar imagem -->
<div id="imageModal" class="modal-overlay">
    <div class="modal-content">
        <img id="modalImage">
        <button onclick="closeModal()" class="modal-close">X Fechar</button>
    </div>
</div>

<style>
/* ================================
   ESTILO PREMIUM — INSTAGRAM
   ================================ */

body {
    background: #fafafa;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.title-main {
    font-weight: 700;
    text-align: center;
    margin-bottom: 20px;
    color: #262626;
}

/* Novo comentário */
.new-comment-box {
    background: #fff;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    border: 1px solid #dbdbdb;
    margin-bottom: 20px;
}

.main-input {
    border-radius: 8px;
    resize: none;
    border: 1px solid #dbdbdb;
    padding: 12px;
    font-size: 14px;
}

.main-input:focus {
    border-color: #0095f6;
    box-shadow: 0 0 0 1px #0095f6;
}

.btn-publicar {
    width: 100%;
    background: #0095f6;
    border: none;
    padding: 10px;
    border-radius: 8px;
    color: #fff;
    font-weight: 600;
    font-size: 14px;
}

.btn-publicar:hover {
    background: #0081d6;
}

/* Lista de comentários */
.comments-container {
    background: #fff;
    padding: 0;
    border-radius: 12px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    border: 1px solid #dbdbdb;
}

/* Caixa do comentário */
.comment-box {
    padding: 16px 20px;
    border-bottom: 1px solid #efefef;
}

.comment-box:last-child {
    border-bottom: none;
}

.reply-box {
    margin-left: 40px;
    border-left: 2px solid #efefef;
    padding-left: 20px;
    background: #fafafa;
    margin-top: 8px;
    border-radius: 0 8px 8px 0;
}

/* Cabeçalho */
.comment-header {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 8px;
}

.avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    object-fit: cover;
    border: 1px solid #dbdbdb;
}

/* Texto */
.username {
    font-weight: 600;
    color: #262626;
    font-size: 14px;
}

.comment-text {
    margin: 8px 0;
    font-size: 14px;
    line-height: 1.4;
    color: #262626;
}

.time {
    margin-left: auto;
    color: #8e8e8e;
    font-size: 12px;
}

/* Foto do comentário */
.comment-photo {
    max-width: 100%;
    max-height: 400px;
    border-radius: 8px;
    cursor: pointer;
    border: 1px solid #efefef;
    margin: 8px 0;
}

.comment-photo:hover {
    opacity: 0.95;
}

/* Botão responder */
.btn-reply {
    background: none;
    border: none;
    color: #8e8e8e;
    font-size: 12px;
    font-weight: 600;
    padding: 0;
    cursor: pointer;
}

.btn-reply:hover {
    color: #262626;
}

/* Input de resposta */
.reply-form {
    margin-top: 12px;
}

.comment-input {
    border-radius: 8px;
    resize: none;
    border: 1px solid #dbdbdb;
    padding: 8px 12px;
    font-size: 14px;
}

.btn-send {
    padding: 6px 16px;
    background: #0095f6;
    border: none;
    border-radius: 8px;
    color: white;
    font-weight: 600;
    font-size: 14px;
}

.btn-send:hover {
    background: #0081d6;
}

.preview-container {
    background: #f8f9fa;
    padding: 12px;
    border-radius: 8px;
    border: 1px dashed #dee2e6;
    display: flex;
    align-items: center;
    gap: 12px;
}

/* Modal */
.modal-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.9);
    z-index: 1000;
    align-items: center;
    justify-content: center;
}

.modal-content {
    position: relative;
    max-width: 90vw;
    max-height: 90vh;
}

.modal-content img {
    max-width: 100%;
    max-height: 90vh;
    border-radius: 8px;
}

.modal-close {
    position: absolute;
    top: -45px;
    right: 0;
    background: #ff4444;
    color: white;
    border: none;
    padding: 8px 12px;
    border-radius: 5px;
    cursor: pointer;
    font-weight: 600;
}

.alert {
    border-radius: 8px;
    border: none;
    font-size: 14px;
}
</style>

<script>
function toggleForm(id){
    const form = document.getElementById("form-"+id);
    form.classList.toggle("d-none");
}

function previewImage(input, formId) {
    const file = input.files[0];
    const previewContainer = document.getElementById('preview-' + formId);
    const previewImage = previewContainer.querySelector('.preview-image');
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImage.src = e.target.result;
            previewContainer.style.display = 'flex';
        }
        reader.readAsDataURL(file);
    } else {
        previewContainer.style.display = 'none';
    }
}

function removeImage(formId) {
    const previewContainer = document.getElementById('preview-' + formId);
    const fileInput = document.querySelector('input[onchange*="'+formId+'"]');
    
    previewContainer.style.display = 'none';
    if (fileInput) {
        fileInput.value = '';
    }
}

function openModal(src) {
    document.getElementById('modalImage').src = src;
    document.getElementById('imageModal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeModal() {
    document.getElementById('imageModal').style.display = 'none';
    document.body.style.overflow = 'auto';
}

// Fechar modal clicando fora ou com ESC
document.getElementById('imageModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeModal();
    }
});

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeModal();
    }
});

// Preview para o formulário principal
document.getElementById('fotoPrincipal').addEventListener('change', function(e) {
    previewImage(this, 'principal');
});
</script>

<?php require_once "../partials/footer.php"; ?>
