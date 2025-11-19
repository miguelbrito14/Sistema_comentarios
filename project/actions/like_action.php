<?php
session_start();
require_once "../config/database.php";

if (!isset($_SESSION['user'])) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Não logado']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Método não permitido']);
    exit;
}

$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (!$data) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Dados inválidos']);
    exit;
}

$commentId = $data['comment_id'] ?? null;
$userId = $_SESSION['user']['id'];

if (!$commentId) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'ID do comentário não informado']);
    exit;
}

try {
    $pdo->beginTransaction();
    
    // Verificar se já curtiu
    $stmt = $pdo->prepare("SELECT id FROM comment_likes WHERE user_id = ? AND comment_id = ?");
    $stmt->execute([$userId, $commentId]);
    $existingLike = $stmt->fetch();
    
    if ($existingLike) {
        // Remover like
        $stmt = $pdo->prepare("DELETE FROM comment_likes WHERE user_id = ? AND comment_id = ?");
        $stmt->execute([$userId, $commentId]);
        
        // Atualizar contador
        $stmt = $pdo->prepare("UPDATE comments SET likes = GREATEST(0, likes - 1) WHERE id = ?");
        $stmt->execute([$commentId]);
        
        $action = 'unlike';
    } else {
        // Adicionar like
        $stmt = $pdo->prepare("INSERT INTO comment_likes (user_id, comment_id) VALUES (?, ?)");
        $stmt->execute([$userId, $commentId]);
        
        // Atualizar contador
        $stmt = $pdo->prepare("UPDATE comments SET likes = likes + 1 WHERE id = ?");
        $stmt->execute([$commentId]);
        
        $action = 'like';
    }
    
    // Buscar novo total de likes
    $stmt = $pdo->prepare("SELECT likes FROM comments WHERE id = ?");
    $stmt->execute([$commentId]);
    $comment = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $pdo->commit();
    
    header('Content-Type: application/json');
    echo json_encode([
        'success' => true, 
        'likes' => $comment['likes'] ?? 0,
        'action' => $action
    ]);
    
} catch (PDOException $e) {
    $pdo->rollBack();
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Erro: ' . $e->getMessage()]);
}
?>