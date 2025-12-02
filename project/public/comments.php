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

// Buscar comentários com informações de like do usuário atual
$userId = $_SESSION['user']['id'];
$stmt = $pdo->prepare("
    SELECT c.*, u.username, u.photo as user_photo,
           EXISTS(SELECT 1 FROM comment_likes WHERE comment_id = c.id AND user_id = ?) as user_liked
    FROM comments c
    JOIN users u ON u.id = c.user_id
    ORDER BY c.created_at DESC
");
$stmt->execute([$userId]);
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

// FUNÇÃO RECURSIVA — COM TODAS AS FUNÇÕES
function showComments($tree, $parent = null, $level = 0) {
    if (!isset($tree[$parent])) return;

    foreach ($tree[$parent] as $c) {
        $userPhoto = !empty($c['user_photo']) ? "../uploads/" . $c['user_photo'] : '../uploads/fotoPerfil.jpeg';
        $isOwner = isset($_SESSION['user']) && $c['user_id'] == $_SESSION['user']['id'];
        $isEdited = !empty($c['updated_at']) && $c['updated_at'] != $c['created_at'];
        
        echo '
        <div class="comment-box '.($level > 0 ? "reply-box" : "").'" id="comment-'.$c['id'].'">

            <div class="comment-header">
                <img src="'.$userPhoto.'" class="avatar" alt="'.$c['username'].'">
                <strong class="username">'.$c['username'].'</strong>
                <span class="time small">'.date('d/m/Y H:i', strtotime($c['created_at']));
                
                if ($isEdited) {
                    echo ' <span class="text-muted">(editado)</span>';
                }
                
                echo '</span>';
                
                // Botões de ação
                echo '<div class="comment-actions-header">';
                
                // Botão like
        
                $likeClass = $c['user_liked'] ? 'btn-liked' : 'btn-like';
                $likeIcon = $c['user_liked'] ? 
                    '<path d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z"/>' :
                    '<path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z"/>';

                echo '<button class="'.$likeClass.'" onclick="toggleLike('.$c['id'].')" title="Curtir">
                        <span class="like-count">'.($c['likes'] ?: '0').'</span>
                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            '.$likeIcon.'
                        </svg>
                    </button>';
                
                // Botão excluir apenas para o dono do comentário
                if ($isOwner) {
                    echo '<button class="btn-delete" onclick="confirmDelete('.$c['id'].')" title="Excluir comentário">
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                            </svg>
                          </button>';
                    
                    // Botão editar
                    echo '<button class="btn-edit" onclick="enableEdit('.$c['id'].')" title="Editar comentário">
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                            </svg>
                          </button>';
                }
                
                echo '</div>';
                
        echo '</div>';

        // Área de conteúdo editável
        echo '<div class="comment-content" id="content-'.$c['id'].'">';
        
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
            echo '<div class="comment-text" id="text-'.$c['id'].'">'.nl2br(htmlspecialchars($c['comment'])).'</div>';
        }
        
        echo '</div>';

        // Formulário de edição (hidden)
        if ($isOwner && !empty($c['comment'])) {
            echo '
            <form id="edit-form-'.$c['id'].'" 
                  action="../actions/edit_comment_action.php" 
                  method="POST" 
                  class="edit-form d-none mt-2">
                
                <input type="hidden" name="comment_id" value="'.$c['id'].'">
                <textarea name="comment" class="form-control edit-input" rows="3">'.htmlspecialchars($c['comment']).'</textarea>
                <div class="edit-actions mt-2">
                    <button type="submit" class="btn-save">Salvar</button>
                    <button type="button" class="btn-cancel" onclick="cancelEdit('.$c['id'].')">Cancelar</button>
                </div>
            </form>';
        }

        echo '
            <div class="comment-footer">
                <button class="btn-reply" onclick="toggleForm('.$c['id'].')">Responder</button>
            </div>

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
                
                <div class="preview-container mt-2 d-none" id="preview-'.$c['id'].'">
                    <img class="preview-image">
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
        
        <div class="preview-container mt-2 d-none" id="preview-principal">
            <img class="preview-image">
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

<!-- Modal de confirmação para excluir -->
<div id="deleteModal" class="modal-overlay" style="display: none;">
    <div class="modal-content modal-box">
        <h5>Excluir Comentário</h5>
        <p>Tem certeza que deseja excluir este comentário?</p>
        <div class="mt-3">
            <button id="confirmDelete" class="btn btn-danger">Sim, Excluir</button>
            <button onclick="closeDeleteModal()" class="btn btn-secondary">Cancelar</button>
        </div>
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

/* Dark mode: caixa de publicar (novo comentário) */
.dark-mode .new-comment-box {
    background: linear-gradient(180deg,#0b0b0d,#0f1113);
    border: 1px solid rgba(255,255,255,0.04);
    box-shadow: 0 8px 32px rgba(2,6,23,0.6);
}

.dark-mode .main-input {
    background: #111318;
    border-color: #22262b;
    color: #e6e6e6;
}

.dark-mode .title-main {
    color: #ffffff;
}

.dark-mode .small.text-muted,
.dark-mode label.small.text-muted {
    color: #e6e6e6 !important;
}

.dark-mode .preview-container {
    background: rgba(255,255,255,0.02);
    border-color: rgba(255,255,255,0.03);
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

/* Dark mode: caixas de comentário em tom escuro (estilo instagram) */
.dark-mode .comments-container {
    background: linear-gradient(180deg,#0b0b0d,#0f1113);
    border: 1px solid rgba(255,255,255,0.04);
    box-shadow: 0 8px 32px rgba(2,6,23,0.6);
}

/* Caixa do comentário */
.comment-box {
    padding: 16px 20px;
    border-bottom: 1px solid #efefef;
    transition: all 0.3s ease;
}

.dark-mode .comment-box {
    background: linear-gradient(180deg, rgba(255,255,255,0.02), transparent);
    border-bottom: 1px solid rgba(255,255,255,0.03);
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

.dark-mode .reply-box {
    border-left-color: rgba(255,255,255,0.03);
    background: linear-gradient(180deg, rgba(255,255,255,0.01), transparent);
}

/* Cabeçalho */
.comment-header {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 8px;
    position: relative;
}

.avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    object-fit: cover;
    border: 1px solid #dbdbdb;
}

.dark-mode .avatar {
    border-color: rgba(255,255,255,0.04);
}

/* Texto */
.username {
    font-weight: 600;
    color: #262626;
    font-size: 14px;
}

.dark-mode .username {
    color: #e6e6e6;
}

.comment-text {
    margin: 8px 0;
    font-size: 14px;
    line-height: 1.4;
    color: #262626;
}

.dark-mode .comment-text {
    color: #d1d5db;
}

.time {
    margin-left: auto;
    color: #8e8e8e;
    font-size: 12px;
    margin-right: 10px;
}

/* Corrigir cor da hora e rótulos pequenos no dark mode */
.dark-mode .time {
    color: #cbd5e0; /* tom claro para legibilidade */
}

/* Garantir que o texto '(editado)' (text-muted) fique legível no dark mode */
.dark-mode .text-muted {
    color: #9ca3af !important;
}

/* Ações do cabeçalho */
.comment-actions-header {
    display: flex;
    gap: 8px;
    align-items: center;
}

.btn-like, .btn-liked {
    background: none;
    border: none;
    color: #8e8e8e;
    padding: 4px 8px;
    border-radius: 4px;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 4px;
    font-size: 12px;
    transition: all 0.2s ease;
}

.btn-liked {
    color: #ff2d55; /* vermelho forte ao curtir */
    font-weight: 700;
}

.btn-like:hover {
    color: #ff6b81;
}

/* Garantir contraste do like no dark mode */
.dark-mode .btn-like, .dark-mode .btn-liked {
    color: #9ca3af;
}
.dark-mode .btn-liked {
    color: #ff6b6b;
}

.btn-like:hover {
    color: #ed4956;
    background: #fafafa;
}

.like-count {
    font-weight: 600;
}

.btn-edit, .btn-delete {
    background: none;
    border: none;
    color: #8e8e8e;
    padding: 4px 8px;
    border-radius: 4px;
    cursor: pointer;
}

.btn-edit:hover {
    color: #0095f6;
    background: #f0f8ff;
}

.btn-delete:hover {
    color: #dc3545;
    background: #fef2f2;
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

/* Rodapé do comentário */
.comment-footer {
    margin-top: 8px;
}

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

/* Formulários */
.reply-form, .edit-form {
    margin-top: 12px;
}

.comment-input, .edit-input {
    border-radius: 8px;
    resize: none;
    border: 1px solid #dbdbdb;
    padding: 8px 12px;
    font-size: 14px;
}

.edit-input {
    border-color: #0095f6;
}

.btn-send, .btn-save {
    padding: 6px 16px;
    background: #0095f6;
    border: none;
    border-radius: 8px;
    color: white;
    font-weight: 600;
    font-size: 14px;
    margin-right: 8px;
}

.btn-send:hover, .btn-save:hover {
    background: #0081d6;
}

.btn-cancel {
    padding: 6px 16px;
    background: #6c757d;
    border: none;
    border-radius: 8px;
    color: white;
    font-weight: 600;
    font-size: 14px;
}

.btn-cancel:hover {
    background: #5a6268;
}

.edit-actions {
    display: flex;
    gap: 8px;
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
/* Modal: regras base movidas para assets/app.css (limpeza) */

/* Caixa do modal (confirm delete) - padrão claro */
.modal-box {
    background: white;
    padding: 20px;
    border-radius: 8px;
    text-align: center;
    color: #111827;
    box-shadow: 0 6px 24px rgba(0,0,0,0.12);
    border: 1px solid rgba(0,0,0,0.06);
}

/* Dark mode: modal escuro e botões com contraste */
.dark-mode .modal-box {
    background: linear-gradient(180deg,#0b0b0d,#14161a);
    color: #e6e6e6;
    border: 1px solid rgba(255,255,255,0.04);
    box-shadow: 0 8px 32px rgba(2,6,23,0.6);
}

.dark-mode .modal-close {
    background: #ff6b6b;
}

/* Botões no modal em dark mode */
.dark-mode .btn-danger {
    background: #9b2c2c;
    border-color: #7f1d1d;
    color: #fff;
}
.dark-mode .btn-secondary {
    background: transparent;
    color: #d1d5db;
    border: 1px solid rgba(255,255,255,0.06);
}

/* Garantir que texto não fique branco sobre fundo branco */
.modal-box h5, .modal-box p {
    margin: 0 0 8px 0;
}

.alert {
    border-radius: 8px;
    border: none;
    font-size: 14px;
}

/* Animações centralizadas em assets/app.css */

/* Responsivo */
@media (max-width: 768px) {
    .reply-box { margin-left: 15px; }
    .comment-actions-header { gap: 4px; }
    .comment-header { flex-wrap: wrap; }
    .time { margin-left: 0; width: 100%; }
}
</style>

<script>
let commentToDelete = null;

// Sistema de Likes CORRIGIDO
async function toggleLike(commentId) {
    const likeBtn = document.querySelector(`#comment-${commentId} .btn-like, #comment-${commentId} .btn-liked`);
    const likeCount = document.querySelector(`#comment-${commentId} .like-count`);
    
    if (!likeBtn || !likeCount) {
        console.error('Elementos do like não encontrados');
        return;
    }
    
    const isLiked = likeBtn.classList.contains('btn-liked');
    
    try {
        const response = await fetch('../actions/like_action.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                comment_id: commentId
            })
        });
        
        const result = await response.json();

        if (result.success) {
            // Atualizar contador
            likeCount.textContent = result.likes;
            
            // Atualizar aparência do botão
            if (result.action === 'like') {
                likeBtn.classList.remove('btn-like');
                likeBtn.classList.add('btn-liked');
                likeBtn.innerHTML = `<span class="like-count">${result.likes}</span>
                                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z"/>
                                    </svg>`;
            } else {
                likeBtn.classList.remove('btn-liked');
                likeBtn.classList.add('btn-like');
                likeBtn.innerHTML = `<span class="like-count">${result.likes}</span>
                                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z"/>
                                    </svg>`;
            }
        } else {
            console.error('Erro no like:', result.message);
            alert('Erro ao curtir: ' + result.message);
        }
    } catch (error) {
        console.error('Erro na requisição:', error);
        alert('Erro de conexão. Tente novamente.');
    }
}

// Sistema de Edição CORRIGIDO
function enableEdit(commentId) {
    const contentDiv = document.getElementById(`content-${commentId}`);
    const editForm = document.getElementById(`edit-form-${commentId}`);
    const replyForm = document.getElementById(`form-${commentId}`);
    
    if (contentDiv) contentDiv.style.display = 'none';
    if (editForm) editForm.classList.remove('d-none');
    if (replyForm) replyForm.classList.add('d-none'); // Esconder formulário de resposta
}

function cancelEdit(commentId) {
    const contentDiv = document.getElementById(`content-${commentId}`);
    const editForm = document.getElementById(`edit-form-${commentId}`);
    
    if (contentDiv) contentDiv.style.display = 'block';
    if (editForm) editForm.classList.add('d-none');
}

// Prevenir conflito entre edição e resposta
function toggleForm(id){
    const form = document.getElementById("form-"+id);
    const editForm = document.getElementById("edit-form-"+id);
    
    if (form) {
        form.classList.toggle("d-none");
    }
    
    // Cancelar edição se estiver ativa
    if (editForm && !editForm.classList.contains('d-none')) {
        cancelEdit(id);
    }
}

// Sistema de Exclusão
function confirmDelete(commentId) {
    commentToDelete = commentId;
    document.getElementById('deleteModal').style.display = 'flex';
}

function closeDeleteModal() {
    commentToDelete = null;
    document.getElementById('deleteModal').style.display = 'none';
}

document.getElementById('confirmDelete').addEventListener('click', function() {
    if (commentToDelete) {
        window.location.href = '../actions/delete_comment_action.php?id=' + commentToDelete;
    }
});

// Funções de imagem
function previewImage(input, formId) {
    const file = input.files[0];
    const previewContainer = document.getElementById('preview-' + formId);
    const previewImage = previewContainer.querySelector('.preview-image');
    
    if (file && previewContainer && previewImage) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImage.src = e.target.result;
            previewContainer.style.display = 'flex';
        }
        reader.readAsDataURL(file);
    } else if (previewContainer) {
        previewContainer.style.display = 'none';
    }
}

function removeImage(formId) {
    const previewContainer = document.getElementById('preview-' + formId);
    const fileInput = document.querySelector('input[onchange*="'+formId+'"]');
    
    if (previewContainer) {
        previewContainer.style.display = 'none';
    }
    if (fileInput) {
        fileInput.value = '';
    }
}

function openModal(src) {
    const modalImage = document.getElementById('modalImage');
    const imageModal = document.getElementById('imageModal');
    
    if (modalImage && imageModal) {
        modalImage.src = src;
        imageModal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }
}

function closeModal() {
    const imageModal = document.getElementById('imageModal');
    if (imageModal) {
        imageModal.style.display = 'none';
        document.body.style.overflow = 'auto';
    }
}

// Event Listeners CORRIGIDOS
document.addEventListener('DOMContentLoaded', function() {
    // Fechar modal clicando fora ou com ESC
    const imageModal = document.getElementById('imageModal');
    const deleteModal = document.getElementById('deleteModal');
    
    if (imageModal) {
        imageModal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
    }
    
    if (deleteModal) {
        deleteModal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });
    }
    
    // Preview para o formulário principal
    const fotoPrincipal = document.getElementById('fotoPrincipal');
    if (fotoPrincipal) {
        fotoPrincipal.addEventListener('change', function(e) {
            previewImage(this, 'principal');
        });
    }
    
    // Tecla ESC para fechar modais
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeModal();
            closeDeleteModal();
        }
    });
    
    // sistema carregado
});
</script>

<?php require_once "../partials/footer.php"; ?>