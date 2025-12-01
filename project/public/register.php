<?php require_once "../partials/header.php"; ?>

<div class="register-wrapper">
    <h2 class="register-title">🚀 Criar Conta</h2>

    <?php if (isset($_SESSION['flash'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $_SESSION['flash']; unset($_SESSION['flash']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <form action="../actions/register_action.php" method="POST" enctype="multipart/form-data">
        <label>👤 Nome de usuário:</label>
        <input type="text" name="username" class="form-control" required placeholder="Seu nome de usuário">

        <label class="mt-3">📧 Email:</label>
        <input type="email" name="email" class="form-control" required placeholder="seu@email.com">

        <label class="mt-3">🔒 Senha:</label>
        <input type="password" name="password" class="form-control" required placeholder="Crie uma senha segura">

        <label class="mt-3">🖼️ Foto de perfil (opcional):</label>
        <input type="file" name="photo" class="form-control" accept="image/*" onchange="previewProfilePhoto(this)">
        
        <img id="profilePreview" class="photo-preview d-none">

        <button class="btn btn-success">🎉 Criar Minha Conta</button>
    </form>

    <p class="register-links">
        Já tem conta? <a href="login.php">Faça login aqui!</a>
    </p>
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