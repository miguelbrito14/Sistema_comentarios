<?php require_once "../partials/header.php"; ?>

<style>
/* --- LOGIN MODERNO --- */
.login-wrapper {
    max-width: 420px;
    margin: 60px auto;
    padding: 30px;
    background: #ffffff;
    border-radius: 14px;
    box-shadow: 0 4px 25px rgba(0,0,0,0.12);
    animation: fadeIn .5s ease;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to   { opacity: 1; transform: translateY(0); }
}

.login-title {
    font-size: 28px;
    font-weight: 700;
    text-align: center;
    margin-bottom: 20px;
    color: #222;
}

.login-wrapper label {
    font-weight: 600;
    margin-top: 10px;
}

.login-wrapper input {
    height: 45px;
    border-radius: 10px;
}

.login-wrapper button {
    width: 100%;
    height: 45px;
    font-size: 17px;
    font-weight: 600;
    border-radius: 10px;
}

.login-links {
    text-align: center;
    margin-top: 15px;
}
.login-links a {
    font-weight: bold;
    color: #007bff;
    text-decoration: none;
}
.login-links a:hover {
    text-decoration: underline;
}
</style>


<div class="login-wrapper">
    
    <h2 class="login-title">Entrar</h2>

    <?php if (isset($_SESSION['flash'])): ?>
        <div class="alert alert-danger text-center">
            <?= $_SESSION['flash']; unset($_SESSION['flash']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['flash_success'])): ?>
        <div class="alert alert-success text-center">
            <?= $_SESSION['flash_success']; unset($_SESSION['flash_success']); ?>
        </div>
    <?php endif; ?>

    <form action="../actions/login_action.php" method="POST">

        <label>Email:</label>
        <input type="email" name="email" class="form-control" required>

        <label class="mt-3">Senha:</label>
        <input type="password" name="password" class="form-control" required>

        <button class="btn btn-primary mt-4">Entrar</button>
    </form>

    <p class="login-links">
        Não tem conta? <a href="register.php">Registrar-se</a>
    </p>
</div>

<?php require_once "../partials/footer.php"; ?>
