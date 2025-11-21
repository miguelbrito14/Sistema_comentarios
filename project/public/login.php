<?php require_once "../partials/header.php"; ?>

<style>
.login-wrapper {
    max-width: 420px;
    margin: 60px auto;
    padding: 40px 30px;
    background: #ffffff;
    border-radius: 16px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.1);
    animation: fadeIn .6s ease;
    border: 1px solid #e0e0e0;
    position: relative;
    z-index: 1;
}

/* keyframes moved to shared CSS (assets/app.css) */

.login-title {
    font-size: 2rem;
    font-weight: 800;
    text-align: center;
    margin-bottom: 30px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.login-wrapper label {
    font-weight: 600;
    margin-top: 15px;
    color: #333;
    display: block;
}

.login-wrapper input {
    height: 50px;
    border-radius: 10px;
    border: 2px solid #e0e0e0;
    padding: 0 15px;
    font-size: 16px;
    transition: all 0.3s ease;
}

.login-wrapper input:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.login-wrapper button {
    width: 100%;
    height: 50px;
    font-size: 18px;
    font-weight: 700;
    border-radius: 10px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    margin-top: 25px;
    transition: all 0.3s ease;
}

.login-wrapper button:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
}

.alert {
    border: 1px solid #e6e6e6;
    border-radius: 8px;
    padding: .75rem 1rem;
}
.alert-danger {
    background: #fff5f5;
    border-color: #fed7d7;
    color: #742a2a;
}
.alert-success {
    background: #f0fff4;
    border-color: #c6f6d5;
    color: #22543d;
}
.alert .btn-close {
    border: none;
    background: transparent;
}
.alert:focus, .btn-close:focus {
    outline: none !important;
    box-shadow: none !important;
}

.login-links {
    text-align: center;
    margin-top: 25px;
    padding-top: 20px;
    border-top: 1px solid #e0e0e0;
}

.login-links a {
    font-weight: 600;
    color: #667eea;
    text-decoration: none;
    transition: color 0.3s ease;
}

.login-links a:hover {
    color: #764ba2;
    text-decoration: underline;
}

.feature-list {
    margin-top: 30px;
    padding: 20px;
    background: #f8f9fa;
    border-radius: 10px;
}

.feature-list h6 {
    color: #333;
    margin-bottom: 15px;
    font-weight: 700;
}

.feature-list ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.feature-list li {
    padding: 5px 0;
    color: #666;
    display: flex;
    align-items: center;
    gap: 8px;
}

.feature-list li:before {
    content: "✓";
    color: #43e97b;
    font-weight: bold;
}

/* Dark mode CORRIGIDO */
.dark-mode .login-wrapper {
    background: radial-gradient(1200px 400px at 10% 10%, rgba(124,58,237,0.06), transparent 10%),
                        radial-gradient(1000px 300px at 90% 90%, rgba(236,72,153,0.04), transparent 10%),
                        linear-gradient(180deg,#0b0b0d,#0f1113);
    border-color: rgba(255,255,255,0.04);
    box-shadow: 0 8px 32px rgba(2,6,23,0.6);
}

.dark-mode .login-wrapper label {
    color: #e6e6e6;
}

.dark-mode .login-wrapper input {
    background: #111318;
    border-color: #22262b;
    color: #e6e6e6;
}

.dark-mode .login-wrapper input::placeholder {
    color: #9ca3af;
}

.dark-mode .feature-list {
    background: linear-gradient(180deg,#0b0b0d,#14151a);
}

.dark-mode .feature-list h6 {
    color: #e6e6e6;
}

.dark-mode .feature-list li {
    color: #cbd5e0;
}

/* CORRIGIR COR DO TEXTO NO DARK MODE */
.dark-mode .login-title {
    color: #e2e8f0 !important;
    -webkit-text-fill-color: #e2e8f0 !important;
    background: none !important;
}

/* CORRIGIR ALERTAS NO DARK MODE - ESSA É A SOLUÇÃO DO RETÂNGULO AZUL! */
.dark-mode .alert-danger {
    background: #fed7d7 !important;
    border-color: #feb2b2 !important;
    color: #742a2a !important;
}

.dark-mode .alert-success {
    background: #c6f6d5 !important;
    border-color: #9ae6b4 !important;
    color: #22543d !important;
}

.dark-mode .alert {
    border: none !important;
}

.dark-mode .btn-close {
    filter: invert(1) !important;
}
</style>

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