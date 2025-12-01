<?php 
session_start();
require_once __DIR__ . "/../config/config.php"; 
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Comentários</title>
    <link href="<?= $BASE_URL ?>/assets/app.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="<?= $BASE_URL ?>/index.php">💬 Sistema Comentários</a>
    
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
                <img src="<?= $userPhoto ?>" class="nav-avatar">
                <?= $_SESSION['user']['username'] ?>
            </a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="<?= $BASE_URL ?>/comments.php">📝 Comentários</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <button class="dropdown-item" onclick="toggleDarkMode()">
                        <span id="darkModeText">🌙 Dark Mode</span>
                    </button>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-danger" href="<?= $BASE_URL ?>/logout.php">🚪 Sair</a></li>
            </ul>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
<div class="container mt-4">

<script>
// Dark Mode System
function toggleDarkMode() {
    const body = document.body;
    const isDark = body.classList.toggle('dark-mode');
    localStorage.setItem('darkMode', isDark);
    updateDarkModeButton();
}

function updateDarkModeButton() {
    const isDark = document.body.classList.contains('dark-mode');
    const button = document.getElementById('darkModeText');
    if (button) {
        button.textContent = isDark ? '☀️ Light Mode' : '🌙 Dark Mode';
    }
}

// Carregar preferência salva
document.addEventListener('DOMContentLoaded', function() {
    const savedDarkMode = localStorage.getItem('darkMode') === 'true';
    if (savedDarkMode) {
        document.body.classList.add('dark-mode');
    }
    updateDarkModeButton();
});
</script>