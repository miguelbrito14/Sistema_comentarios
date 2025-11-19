<?php
session_start();
require_once "../config/database.php";

if (!isset($_SESSION['user'])) {
    header("Location: ../public/login.php");
    exit;
}

$comment = trim($_POST['comment']);
$userId = $_SESSION['user']['id'];
$parentId = $_POST['parent_id'] ?? null;
$fotoNome = null;

// Processar upload da foto se existir
if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
    $foto = $_FILES['foto'];
    
    // Verificar se é uma imagem
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $foto['tmp_name']);
    finfo_close($finfo);
    
    if (!in_array($mime, $allowedTypes)) {
        $_SESSION['flash'] = "Tipo de arquivo não permitido. Use apenas imagens (JPEG, PNG, GIF).";
        header("Location: ../public/comments.php");
        exit;
    }
    
    // Verificar tamanho (5MB max)
    if ($foto['size'] > 5 * 1024 * 1024) {
        $_SESSION['flash'] = "Arquivo muito grande. Máximo: 5MB";
        header("Location: ../public/comments.php");
        exit;
    }
    
    // Criar diretório de uploads se não existir
    $uploadDir = "../uploads/comentarios/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }
    
    // Gerar nome único
    $extensao = strtolower(pathinfo($foto['name'], PATHINFO_EXTENSION));
    $fotoNome = uniqid('comentario_') . '.' . $extensao;
    $caminhoCompleto = $uploadDir . $fotoNome;
    
    // Mover arquivo
    if (!move_uploaded_file($foto['tmp_name'], $caminhoCompleto)) {
        $_SESSION['flash'] = "Erro ao salvar a imagem. Tente novamente.";
        header("Location: ../public/comments.php");
        exit;
    }
}

// Verificar se tem pelo menos comentário OU foto
if (empty($comment) && empty($fotoNome)) {
    $_SESSION['flash'] = "Digite um comentário ou adicione uma foto.";
    header("Location: ../public/comments.php");
    exit;
}

// Inserir no banco (com ou sem foto)
try {
    $stmt = $pdo->prepare("INSERT INTO comments (user_id, comment, parent_id, foto) VALUES (?, ?, ?, ?)");
    $stmt->execute([$userId, $comment, $parentId, $fotoNome]);
    
    $_SESSION['flash_success'] = "Comentário adicionado com sucesso!";
} catch (PDOException $e) {
    $_SESSION['flash'] = "Erro ao adicionar comentário: " . $e->getMessage();
}

header("Location: ../public/comments.php");
exit;
?>