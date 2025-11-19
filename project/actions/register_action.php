<?php
session_start();
require_once "../config/database.php";

$username = trim($_POST['username']);
$email = trim($_POST['email']);
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

// FOTO
$photoName = null;

if (!empty($_FILES['photo']['name'])) {

    $ext = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));

    // Garante que só imagens sejam aceitas
    $allowed = ["jpg", "jpeg", "png", "gif"];
    if (!in_array($ext, $allowed)) {
        $_SESSION['flash'] = "Formato de imagem inválido!";
        header("Location: ../public/register.php");
        exit;
    }

    // Cria nome único
    $photoName = uniqid("foto_").".".$ext;

    // Move para /uploads
    move_uploaded_file(
        $_FILES['photo']['tmp_name'],
        "../uploads/".$photoName
    );
}


// AGORA INSERE A FOTO NO BANCO
$stmt = $pdo->prepare("
    INSERT INTO users (username, email, password, photo)
    VALUES (?, ?, ?, ?)
");

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
