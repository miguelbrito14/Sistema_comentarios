<?php
session_start();
require_once "../config/database.php";

$username = trim($_POST['username']);
$email = trim($_POST['email']);
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

$stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");

try {
    $stmt->execute([$username, $email, $password]);
    $_SESSION['flash_success'] = "Conta criada com sucesso! Faça login.";
    header("Location: ../public/login.php");
    exit;
} catch (PDOException $e) {
    $_SESSION['flash'] = "Erro ao registrar: " . $e->getMessage();
    header("Location: ../public/register.php");
    exit;
}
