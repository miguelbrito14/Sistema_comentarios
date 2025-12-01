</div>

<script>
// Funções globais
function toggleForm(id) {
    const form = document.getElementById("form-" + id);
    if (form) {
        form.classList.toggle("d-none");
    }
}

// Busca em tempo real
function searchComments() {
    const el = document.getElementById('searchInput');
    const searchTerm = el ? el.value.toLowerCase() : '';
    const comments = document.querySelectorAll('.comment-box');
    
    comments.forEach(comment => {
        const text = comment.textContent.toLowerCase();
        if (searchTerm && text.includes(searchTerm)) {
            comment.style.display = 'block';
            comment.style.animation = 'fadeIn 0.3s ease';
        } else if (!searchTerm) {
            comment.style.display = '';
        } else {
            comment.style.display = 'none';
        }
    });
}

// Carregar mais comentários (para paginação futura)
let currentPage = 1;
function loadMoreComments() {
    // Implementar AJAX para carregar mais comentários (opcional)
}

// Substitui comportamento do Bootstrap para elementos com data-bs-dismiss
document.addEventListener('click', function(e){
    const el = e.target.closest('[data-bs-dismiss]');
    if (!el) return;
    const targetSel = el.getAttribute('data-bs-dismiss');
    if (targetSel === 'alert') {
        const parentAlert = el.closest('.alert');
        if (parentAlert) parentAlert.remove();
    } else {
        const parent = el.closest('.' + (targetSel || ''));
        if (parent) parent.remove();
    }
});

// Sistema de notificações (simples)
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `alert alert-${type} alert-dismissible position-fixed`;
    notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    notification.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    document.body.appendChild(notification);
    
    setTimeout(() => {
        if (notification.parentNode) notification.parentNode.removeChild(notification);
    }, 5000);
}

// Copiar link do comentário
function copyCommentLink(commentId) {
    const url = `${window.location.origin}${window.location.pathname}#comment-${commentId}`;
    navigator.clipboard.writeText(url).then(() => {
        showNotification('Link copiado para a área de transferência!', 'success');
    });
}

// Compartilhar comentário
function shareComment(commentId) {
    if (navigator.share) {
        navigator.share({
            title: 'Ver este comentário',
            url: `${window.location.origin}${window.location.pathname}#comment-${commentId}`
        });
    } else {
        copyCommentLink(commentId);
    }
}
</script>

</body>
</html>