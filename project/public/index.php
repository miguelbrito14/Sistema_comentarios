<?php 
require_once "../partials/header.php"; 
require_once "../config/database.php";

// Buscar estatísticas
$totalUsers = $pdo->query("SELECT COUNT(*) as total FROM users")->fetch()['total'];
$totalComments = $pdo->query("SELECT COUNT(*) as total FROM comments")->fetch()['total'];
$totalLikes = $pdo->query("SELECT SUM(likes) as total FROM comments")->fetch()['total'];
$recentComments = $pdo->query("
    SELECT c.*, u.username, u.photo 
    FROM comments c 
    JOIN users u ON u.id = c.user_id 
    ORDER BY c.created_at DESC 
    LIMIT 3
")->fetchAll(PDO::FETCH_ASSOC);
?>

<style>
.home-box {
    max-width: 800px;
    margin: 50px auto;
    padding: 40px;
    background: #ffffff;
    border-radius: 20px;
    text-align: center;
    box-shadow: 0 10px 40px rgba(0,0,0,0.1);
    animation: fadeIn .8s ease;
    border: 1px solid #e0e0e0;
}

.home-title {
    font-size: 3rem;
    font-weight: 800;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    margin-bottom: 10px;
}

.home-subtitle {
    font-size: 1.3rem;
    color: #666;
    margin-bottom: 40px;
    line-height: 1.6;
}

.home-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin: 40px 0;
}

.stat-card {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    color: white;
    padding: 25px;
    border-radius: 15px;
    text-align: center;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.stat-card:nth-child(2) {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
}

.stat-card:nth-child(3) {
    background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
}

.stat-number {
    font-size: 2.5rem;
    font-weight: 800;
    display: block;
    margin-bottom: 5px;
}

.stat-label {
    font-size: 0.9rem;
    opacity: 0.9;
}

.home-buttons {
    display: flex;
    gap: 15px;
    justify-content: center;
    flex-wrap: wrap;
    margin: 30px 0;
}

.home-btn {
    padding: 15px 30px;
    font-size: 1.1rem;
    border-radius: 12px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
}

.btn-primary-custom {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.btn-outline-custom {
    background: transparent;
    border: 2px solid #667eea;
    color: #667eea;
}

.home-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
}

.recent-comments {
    margin-top: 40px;
    text-align: left;
}

.recent-title {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 20px;
    text-align: center;
    color: #333;
}

.comment-preview {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 10px;
    margin-bottom: 15px;
    border-left: 4px solid #667eea;
}

.comment-header-preview {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 8px;
}

.avatar-preview {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    object-fit: cover;
}

.username-preview {
    font-weight: 600;
    color: #333;
}

.comment-text-preview {
    color: #666;
    font-size: 0.9rem;
    line-height: 1.4;
}

.no-comments {
    text-align: center;
    color: #999;
    font-style: italic;
    padding: 20px;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Dark mode support */
.dark-mode .home-box {
    background: #2d3748;
    border-color: #4a5568;
}

.dark-mode .home-title {
    color: #e2e8f0 !important;
    -webkit-text-fill-color: #e2e8f0 !important;
    background: none !important;
}

.dark-mode .home-subtitle {
    color: #cbd5e0;
}

.dark-mode .comment-preview {
    background: #4a5568;
}

.dark-mode .username-preview {
    color: #e2e8f0;
}

.dark-mode .comment-text-preview {
    color: #cbd5e0;
}

.dark-mode .recent-title {
    color: #e2e8f0;
}

@media (max-width: 768px) {
    .home-box {
        margin: 20px;
        padding: 25px;
    }
    
    .home-title {
        font-size: 2.2rem;
    }
    
    .home-stats {
        grid-template-columns: 1fr;
    }
    
    .home-buttons {
        flex-direction: column;
    }
}
</style>

<div class="home-box">
    <h1 class="home-title">💬 Sistema de Comentários</h1>
    <p class="home-subtitle">Interaja, comente, curta e responda com facilidade. 
    <br>Uma experiência social completa e moderna.</p>

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
                    $userPhoto = !empty($comment['photo']) ? 
                        "../uploads/" . $comment['photo'] : 
                        'https://via.placeholder.com/30x30/007bff/ffffff?text=' . substr($comment['username'], 0, 1);
                    ?>
                    <img src="<?= $userPhoto ?>" class="avatar-preview" alt="<?= $comment['username'] ?>">
                    <span class="username-preview"><?= $comment['username'] ?></span>
                </div>
                <div class="comment-text-preview">
                    <?= strlen($comment['comment']) > 100 ? 
                        substr($comment['comment'], 0, 100) . '...' : 
                        $comment['comment'] ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>

<?php require_once "../partials/footer.php"; ?>