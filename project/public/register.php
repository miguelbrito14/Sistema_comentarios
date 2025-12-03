<?php require_once "../partials/header.php"; ?>

<div class="auth-container">
    <div class="auth-box">
        <h1 class="auth-title">Crie sua Conta 🚀</h1>

        <?php if (isset($_SESSION['flash'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= $_SESSION['flash']; unset($_SESSION['flash']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <form action="../actions/register_action.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="username" class="form-label">👤 Nome de usuário</label>
                <input type="text" id="username" name="username" class="form-control" required placeholder="Seu nome de usuário">
            </div>

            <div class="form-group">
                <label for="email" class="form-label">📧 Email</label>
                <input type="email" id="email" name="email" class="form-control" required placeholder="seu@email.com">
            </div>

            <div class="form-group">
                <label for="password" class="form-label">🔐 Senha</label>
                <input type="password" id="password" name="password" class="form-control" required placeholder="Crie uma senha segura">
            </div>

            <div class="form-group">
                <label for="photo" class="form-label">🖼️ Foto de perfil <span style="font-size: 0.8rem; color: var(--gray);">(opcional)</span></label>
                <input type="file" id="photo" name="photo" class="form-control" accept="image/*" onchange="previewProfilePhoto(this)">
                <img id="profilePreview" class="photo-preview d-none" alt="Prévia do perfil">
            </div>

            <button type="submit" class="btn btn-success w-100">
                <i class="bi bi-check-circle"></i> Criar Conta
            </button>
        </form>

        <p class="auth-link">
            Já tem conta? <a href="login.php">Faça login</a>
        </p>
    </div>
</div>

<script>
function previewProfilePhoto(input) {
    const preview = document.getElementById('profilePreview');
    const file = input.files[0];
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.classList.remove('d-none');
        }
        reader.readAsDataURL(file);
    } else {
        preview.classList.add('d-none');
    }
}
</script>

<?php require_once "../partials/footer.php"; ?>