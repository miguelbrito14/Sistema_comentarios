<?php 
session_start();
require_once __DIR__ . "/../config/config.php"; 
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Sistema Comentários</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Estilo para comentários recursivos */
        .comment-reply { margin-left: 2rem; border-left: 2px solid #ddd; padding-left: 1rem; }
    </style>
    <style>
.reply-box {
    margin-left: 25px;
    padding: 8px 12px;
    background: #f7f7f7;
    border-radius: 8px;
    border-left: 3px solid #007bff;
}

.reply-form {
    margin-left: 25px;
}

.reply-box .reply-box {
    margin-left: 25px; /* recuo para respostas de respostas */
}

.d-none {
    display: none;
}
</style>

</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="<?= $BASE_URL ?>/index.php">Sistema</a>
    <div>
      <ul class="navbar-nav">

        <li class="nav-item"><a class="nav-link" href="<?= $BASE_URL ?>/index.php">Home</a></li>

        <?php if (!isset($_SESSION['user'])): ?>
          <li class="nav-item"><a class="nav-link" href="<?= $BASE_URL ?>/login.php">Login</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= $BASE_URL ?>/register.php">Registrar</a></li>
        <?php else: ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                <?php 
                $userPhoto = !empty($_SESSION['user']['photo']) ? 
                    $BASE_URL . '/../uploads/' . $_SESSION['user']['photo'] : 
                    'https://via.placeholder.com/30x30/007bff/ffffff?text=' . substr($_SESSION['user']['username'], 0, 1);
                ?>
                <img src="<?= $userPhoto ?>" style="width:30px; height:30px; border-radius:50%; margin-right:8px;">
                <?= $_SESSION['user']['username'] ?>
            </a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="<?= $BASE_URL ?>/comments.php">Comentários</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="<?= $BASE_URL ?>/logout.php">Sair</a></li>
            </ul>
          </li>
        <?php endif; ?>

      </ul>
    </div>
  </div>
</nav>
<div class="container mt-4">