<?php require_once "../partials/header.php"; ?>

<h2>Login</h2>

<?php if (isset($_SESSION['flash'])): ?>
<div class="alert alert-danger"><?= $_SESSION['flash']; ?></div>
<?php unset($_SESSION['flash']); endif; ?>

<form action="../actions/login_action.php" method="POST" class="mt-3">

    <label>Email:</label>
    <input type="email" name="email" class="form-control" required>

    <label class="mt-3">Senha:</label>
    <input type="password" name="password" class="form-control" required>

    <button class="btn btn-primary mt-3">Entrar</button>
</form>

<?php require_once "../partials/footer.php"; ?>
