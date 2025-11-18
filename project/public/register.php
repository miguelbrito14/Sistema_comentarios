<?php require_once "../partials/header.php"; ?>

<h2>Criar Conta</h2>

<?php if (isset($_SESSION['flash'])): ?>
<div class="alert alert-danger"><?= $_SESSION['flash']; unset($_SESSION['flash']); ?></div>
<?php endif; ?>

<form action="../actions/register_action.php" method="POST">
    <label>Usuário:</label>
    <input type="text" name="username" class="form-control" required>

    <label class="mt-3">Email:</label>
    <input type="email" name="email" class="form-control" required>

    <label class="mt-3">Senha:</label>
    <input type="password" name="password" class="form-control" required>

    <button class="btn btn-success mt-3">Registrar</button>
</form>

<p class="mt-3">Já tem conta? <a href="login.php">Entrar</a></p>

<?php require_once "../partials/footer.php"; ?>
