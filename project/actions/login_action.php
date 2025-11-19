<?php
session_start();
require_once "../config/database.php";

$email = $_POST['email'] ?? '';
$pass = $_POST['password'] ?? '';

$stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user || !password_verify($pass, $user['password'])) {
    $_SESSION['flash'] = "Email ou senha incorretos!";
    header("Location: ../public/login.php");
    exit;
}

$_SESSION['user'] = $user;
header("Location: ../public/comments.php");
exit;
?>