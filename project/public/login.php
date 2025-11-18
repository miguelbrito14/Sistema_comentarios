<?php require_once "../partials/header.php"; ?>

<h2>Login</h2>

<?php if (isset($_SESSION['flash'])): ?>
<div class="alert alert-danger"><?= $_SESSION['flash']; unset($_SESSION['flash']); ?></div>
<?php endif; ?>

<?php if (isset($_SESSION['flash_success'])): ?>
<div class="alert alert-success"><?= $_SESSION['flash_success']; unset($_SESSION['flash_success']); ?></div>
<?php endif; ?>

<form action="../actions/login_action.php" method="POST" class="mt-3">
    <label>Email:</label>
    <input type="email" name="email" class="form-control" required>

    <label class="mt-3">Senha:</label>
    <input type="password" name="password" class="form-control" required>

    <button class="btn btn-primary mt-3">Entrar</button>
</form>

<p class="mt-3">Não tem conta? <a href="register.php">Registrar-se</a></p>

<?php require_once "../partials/footer.php"; ?>
