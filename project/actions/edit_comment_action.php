<?php
session_start();
require_once "../config/database.php";

if (!isset($_SESSION['user'])) {
    header("Location: ../public/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['flash'] = "Método não permitido";
    header("Location: ../public/comments.php");
    exit;
}

$commentId = $_POST['comment_id'] ?? null;
$newComment = trim($_POST['comment'] ?? '');
$userId = $_SESSION['user']['id'];

if (!$commentId) {
    $_SESSION['flash'] = "Comentário não encontrado";
    header("Location: ../public/comments.php");
    exit;
}

if (empty($newComment)) {
    $_SESSION['flash'] = "Comentário não pode estar vazio";
    header("Location: ../public/comments.php");
    exit;
}

// Verificar se o comentário pertence ao usuário
try {
    $stmt = $pdo->prepare("SELECT id FROM comments WHERE id = ? AND user_id = ?");
    $stmt->execute([$commentId, $userId]);
    $comment = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$comment) {
        $_SESSION['flash'] = "Você não tem permissão para editar este comentário";
        header("Location: ../public/comments.php");
        exit;
    }
    
    // Atualizar comentário
    $stmt = $pdo->prepare("UPDATE comments SET comment = ?, updated_at = NOW() WHERE id = ?");
    $stmt->execute([$newComment, $commentId]);
    
    $_SESSION['flash_success'] = "Comentário atualizado com sucesso!";
    
} catch (PDOException $e) {
    $_SESSION['flash'] = "Erro ao editar comentário: " . $e->getMessage();
}

header("Location: ../public/comments.php");
exit;
?>