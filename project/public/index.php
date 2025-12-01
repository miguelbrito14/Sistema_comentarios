<?php 
require_once "../partials/header.php"; 
require_once "../config/database.php";

// Buscar estatísticas
$totalUsers = $pdo->query("SELECT COUNT(*) as total FROM users")->fetch()['total'];
$totalComments = $pdo->query("SELECT COUNT(*) as total FROM comments")->fetch()['total'];
$totalLikes = $pdo->query("SELECT SUM(likes) as total FROM comments")->fetch()['total'];
$recentComments = $pdo->query(
    "SELECT c.*, u.username, u.photo FROM comments c JOIN users u ON u.id = c.user_id ORDER BY c.created_at DESC LIMIT 3"
)->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- estilos movidos para assets/app.css -->

<div class="home-box">
    <h1 class="home-title">💬 Sistema de Comentários</h1>
    <p class="home-subtitle">Interaja, comente, curta e responda com facilidade. <br>Uma experiência social completa e moderna.</p>

    <div class="home-stats">
        <div class="stat-card">
            <span class="stat-number"><?= $totalUsers ?></span>
            <span class="stat-label">Usuários</span>
        </div>
        <div class="stat-card">
            <span class="stat-number"><?= $totalComments ?></span>
            <span class="stat-label">Comentários</span>
        </div>
        <div class="stat-card">
            <span class="stat-number"><?= $totalLikes ?: '0' ?></span>
            <span class="stat-label">Curtidas</span>
        </div>
    </div>

    <div class="home-buttons">
        <?php if (!isset($_SESSION['user'])): ?>
            <a href="login.php" class="home-btn btn-primary-custom">🚀 Entrar</a>
            <a href="register.php" class="home-btn btn-outline-custom">📝 Criar Conta</a>
        <?php else: ?>
            <a href="comments.php" class="home-btn btn-primary-custom">💬 Ver Comentários</a>
            <a href="comments.php" class="home-btn btn-outline-custom">✏️ Novo Comentário</a>
        <?php endif; ?>
    </div>

    <?php if ($recentComments): ?>
    <div class="recent-comments">
        <h3 class="recent-title">📢 Comentários Recentes</h3>
        <?php foreach ($recentComments as $comment): ?>
            <div class="comment-preview">
                <div class="comment-header-preview">
                    <?php 
                    $userPhoto = !empty($comment['photo']) ? "../uploads/" . $comment['photo'] : 'https://via.placeholder.com/30x30/007bff/ffffff?text=' . substr($comment['username'], 0, 1);
                    ?>
                    <img src="<?= $userPhoto ?>" class="avatar-preview" alt="<?= $comment['username'] ?>">
                    <span class="username-preview"><?= $comment['username'] ?></span>
                </div>
                <div class="comment-text-preview">
                    <?= strlen($comment['comment']) > 100 ? substr($comment['comment'], 0, 100) . '...' : $comment['comment'] ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>

<?php require_once "../partials/footer.php"; ?>