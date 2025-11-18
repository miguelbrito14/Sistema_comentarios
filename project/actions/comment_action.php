<?php
session_start();
require_once "../config/database.php";

if (!isset($_SESSION['user'])) {
    header("Location: ../public/login.php");
    exit;
}

$comment = trim($_POST['comment']);
$userId = $_SESSION['user']['id'];

$stmt = $pdo->prepare("INSERT INTO comments (user_id, comment) VALUES (?, ?)");
$stmt->execute([$userId, $comment]);

header("Location: ../public/comments.php");
exit;// teste dec 
// teste