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

</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="<?= $BASE_URL ?>/index.php">Sistema</a>

    <div>
      <ul class="navbar-nav">

        <li class="nav-item">
          <a class="nav-link" href="<?= $BASE_URL ?>/index.php">Home</a>
        </li>

        <?php if (!isset($_SESSION['user'])): ?>
          <li class="nav-item"><a class="nav-link" href="<?= $BASE_URL ?>/login.php">Login</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= $BASE_URL ?>/register.php">Registrar</a></li>
        <?php else: ?>
          <li class="nav-item"><a class="nav-link" href="<?= $BASE_URL ?>/comments.php">Comentários</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= $BASE_URL ?>/logout.php">Logout</a></li>
        <?php endif; ?>

      </ul>
    </div>
  </div>
</nav>

<div class="container mt-4">
