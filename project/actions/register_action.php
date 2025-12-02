<?php
session_start();
require_once "../config/database.php";

$username = trim($_POST['username']);
$email = trim($_POST['email']);
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
// Nome de arquivo padrão caso usuário não envie foto
$defaultPhoto = 'fotoPerfil.jpeg';
$photoName = null;

// Processar upload da foto de perfil se existir
if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
    $foto = $_FILES['photo'];
    
    // Verificar se é uma imagem
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $foto['tmp_name']);
    finfo_close($finfo);
    
    if (!in_array($mime, $allowedTypes)) {
        $_SESSION['flash'] = "Tipo de arquivo não permitido. Use apenas imagens (JPEG, PNG, GIF).";
        header("Location: ../public/register.php");
        exit;
    }
    
    // Verificar tamanho (5MB max)
    if ($foto['size'] > 5 * 1024 * 1024) {
        $_SESSION['flash'] = "Arquivo muito grande. Máximo: 5MB";
        header("Location: ../public/register.php");
        exit;
    }
    
    // Criar diretório de uploads se não existir
    $uploadDir = "../uploads/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }
    
    // Gerar nome único
    $extensao = strtolower(pathinfo($foto['name'], PATHINFO_EXTENSION));
    $photoName = uniqid('perfil_') . '.' . $extensao;
    $caminhoCompleto = $uploadDir . $photoName;
    
    // Mover arquivo
    if (!move_uploaded_file($foto['tmp_name'], $caminhoCompleto)) {
        $_SESSION['flash'] = "Erro ao salvar a foto de perfil. Tente novamente.";
        header("Location: ../public/register.php");
        exit;
    }
}

// Inserir no banco
// Se não enviou foto, atribuir a foto padrão
if (empty($photoName)) {
    $photoName = $defaultPhoto;
}

$stmt = $pdo->prepare("INSERT INTO users (username, email, password, photo) VALUES (?, ?, ?, ?)");

try {
    $stmt->execute([$username, $email, $password, $photoName]);
    $_SESSION['flash_success'] = "Conta criada com sucesso! Faça login.";
    header("Location: ../public/login.php");
    exit;
} catch (PDOException $e) {
    $_SESSION['flash'] = "Erro ao registrar: " . $e->getMessage();
    header("Location: ../public/register.php");
    exit;
}
?>