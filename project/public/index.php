<?php require_once "../partials/header.php"; ?>

<style>
.home-box {
    max-width: 650px;
    margin: 70px auto;
    padding: 40px;
    background: #ffffff;
    border-radius: 18px;
    text-align: center;
    box-shadow: 0 5px 30px rgba(0,0,0,0.12);
    animation: fadeIn .5s ease;
}

.home-title {
    font-size: 32px;
    font-weight: 700;
    color: #222;
}

.home-subtitle {
    font-size: 18px;
    color: #555;
    margin-top: 10px;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to   { opacity: 1; transform: translateY(0); }
}

.home-btn {
    margin-top: 25px;
    padding: 12px 30px;
    font-size: 18px;
    border-radius: 12px;
}
</style>

<div class="home-box">
    <h1 class="home-title">Bem-vindo ao Sistema de Comentários</h1>
    <p class="home-subtitle">Interaja, comente e responda com facilidade.  
    Use o menu acima para navegar.</p>

    <?php if (!isset($_SESSION['user'])): ?>
        <a href="login.php" class="btn btn-primary home-btn">Entrar</a>
        <a href="register.php" class="btn btn-outline-primary home-btn ms-2">Criar Conta</a>
    <?php else: ?>
        <a href="comments.php" class="btn btn-primary home-btn">Ir para Comentários</a>
    <?php endif; ?>
</div>

<?php require_once "../partials/footer.php"; ?>
