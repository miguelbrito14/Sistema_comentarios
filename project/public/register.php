<?php require_once "../partials/header.php"; ?>

<style>
/* --- FORMULÁRIO MODERNO --- */
.register-wrapper {
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

.register-title {
    font-size: 28px;
    font-weight: 700;
    text-align: center;
    margin-bottom: 25px;
    color: #222;
}

.register-wrapper label {
    font-weight: 600;
    margin-top: 10px;
}

.register-wrapper input {
    height: 45px;
    border-radius: 10px;
}

.register-wrapper button {
    width: 100%;
    height: 45px;
    font-size: 17px;
    font-weight: 600;
    border-radius: 10px;
}

.register-links {
    text-align: center;
    margin-top: 15px;
}
.register-links a {
    font-weight: bold;
    color: #007bff;
    text-decoration: none;
}
.register-links a:hover {
    text-decoration: underline;
}
</style>


<div class="register-wrapper">
    
    <h2 class="register-title">Criar Conta</h2>

    <?php if (isset($_SESSION['flash'])): ?>
        <div class="alert alert-danger text-center">
            <?= $_SESSION['flash']; unset($_SESSION['flash']); ?>
        </div>
    <?php endif; ?>

    <form action="../actions/register_action.php" method="POST">

        <label>Usuário:</label>
        <input type="text" name="username" class="form-control" required>

        <label class="mt-3">Email:</label>
        <input type="email" name="email" class="form-control" required>

        <label class="mt-3">Senha:</label>
        <input type="password" name="password" class="form-control" required>

        <button class="btn btn-success mt-4">Registrar</button>
    </form>

    <p class="register-links">
        Já tem conta? <a href="login.php">Entrar</a>
    </p>
</div>

<?php require_once "../partials/footer.php"; ?>
