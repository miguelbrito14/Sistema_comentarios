</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

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
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
    const comments = document.querySelectorAll('.comment-box');
    
    comments.forEach(comment => {
        const text = comment.textContent.toLowerCase();
        if (text.includes(searchTerm)) {
            comment.style.display = 'block';
            comment.style.animation = 'fadeIn 0.3s ease';
        } else {
            comment.style.display = 'none';
        }
    });
}

// Carregar mais comentários (para paginação futura)
let currentPage = 1;
function loadMoreComments() {
    // Implementar AJAX para carregar mais comentários
    // implementação futura: carregar mais comentários via AJAX
}

// Inicializar tooltips do Bootstrap
document.addEventListener('DOMContentLoaded', function() {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});

// Sistema de notificações
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
    notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    notification.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    document.body.appendChild(notification);
    
    // Auto-remove após 5 segundos
    setTimeout(() => {
        if (notification.parentNode) {
            notification.parentNode.removeChild(notification);
        }
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