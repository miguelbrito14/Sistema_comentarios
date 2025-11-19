<?php
session_start();
require_once "../config/database.php";

if (!isset($_SESSION['user'])) {
    header("Location: ../public/login.php");
    exit;
}

if (!isset($_GET['id'])) {
    $_SESSION['flash'] = "Comentário não encontrado.";
    header("Location: ../public/comments.php");
    exit;
}

$commentId = $_GET['id'];
$userId = $_SESSION['user']['id'];

// Verificar se o comentário pertence ao usuário
try {
    $stmt = $pdo->prepare("SELECT * FROM comments WHERE id = ? AND user_id = ?");
    $stmt->execute([$commentId, $userId]);
    $comment = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$comment) {
        $_SESSION['flash'] = "Você não tem permissão para excluir este comentário.";
        header("Location: ../public/comments.php");
        exit;
    }
    
    // Deletar a foto do comentário se existir
    if (!empty($comment['foto'])) {
        $fotoPath = "../uploads/comentarios/" . $comment['foto'];
        if (file_exists($fotoPath)) {
            unlink($fotoPath);
        }
    }
    
    // Deletar o comentário
    $stmt = $pdo->prepare("DELETE FROM comments WHERE id = ?");
    $stmt->execute([$commentId]);
    
    $_SESSION['flash_success'] = "Comentário excluído com sucesso!";
    
} catch (PDOException $e) {
    $_SESSION['flash'] = "Erro ao excluir comentário: " . $e->getMessage();
}

header("Location: ../public/comments.php");
exit;
?>