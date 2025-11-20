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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Estilo para comentários recursivos */
        .comment-reply { margin-left: 2rem; border-left: 2px solid #ddd; padding-left: 1rem; }
        
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
            margin-left: 25px;
        }

        .d-none {
            display: none;
        }

        .navbar-nav .dropdown-toggle img {
            border: 2px solid #fff;
        }

        /* Dark Mode */
        /* Dark Mode estilo Instagram */
        .dark-mode {
            background: radial-gradient(1200px 400px at 10% 10%, rgba(124,58,237,0.12), transparent 10%),
                        radial-gradient(1000px 300px at 90% 90%, rgba(236,72,153,0.08), transparent 10%),
                        #0f0f10 !important;
            color: #e6e6e6;
            min-height: 100vh;
        }

        .dark-mode body {
             background: radial-gradient(1200px 400px at 10% 10%, rgba(124,58,237,0.08), transparent 10%),
                         radial-gradient(1000px 300px at 90% 90%, rgba(236,72,153,0.06), transparent 10%),
                         #0f0f10 !important;
        }
        
        .dark-mode .navbar-dark {
            background: linear-gradient(90deg, #111827 0%, #4c1d95 40%, #7c3aed 100%) !important;
            box-shadow: 0 2px 8px rgba(0,0,0,0.6);
        }
        
        .dark-mode .card {
            background: linear-gradient(180deg,#111316,#18202a);
            color: #e6e6e6;
            border-color: rgba(255,255,255,0.04);
        }
        
        .dark-mode .form-control {
            background: #1f2937;
            border-color: #374151;
            color: #e6e6e6;
        }
        
        .dark-mode .form-control::placeholder {
            color: #9ca3af;
        }
    </style>
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
                <img src="<?= $userPhoto ?>" style="width:30px; height:30px; border-radius:50%; margin-right:8px; object-fit: cover;">
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