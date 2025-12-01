<?php require_once "../partials/header.php"; ?>

<div class="login-wrapper">
    <h2 class="login-title">🔐 Entrar</h2>

    <?php if (isset($_SESSION['flash'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $_SESSION['flash']; unset($_SESSION['flash']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['flash_success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $_SESSION['flash_success']; unset($_SESSION['flash_success']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <form action="../actions/login_action.php" method="POST">
        <label>📧 Email:</label>
        <input type="email" name="email" class="form-control" required placeholder="seu@email.com">

        <label class="mt-3">🔒 Senha:</label>
        <input type="password" name="password" class="form-control" required placeholder="Sua senha">

        <button class="btn btn-primary">🚀 Entrar na Conta</button>
    </form>

    <p class="login-links">
        Não tem conta? <a href="register.php">Crie uma agora!</a>
    </p>

    <div class="feature-list">
        <h6>✨ Recursos disponíveis:</h6>
        <ul>
            <li>Comentar com texto e fotos</li>
            <li>Curtir comentários</li>
            <li>Responder outros usuários</li>
            <li>Editar e excluir seus comentários</li>
            <li>Foto de perfil personalizada</li>
            <li>Modo escuro</li>
        </ul>
    </div>
</div>

<?php require_once "../partials/footer.php"; ?>

<script>
document.addEventListener('DOMContentLoaded', function(){
    if (document.querySelector('.alert')) {
        const els = document.querySelectorAll('.login-wrapper input, .login-wrapper button');
        els.forEach(e => e.blur());
    }
});
</script>