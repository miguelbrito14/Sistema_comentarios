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

$stmt = $pdo->prepare("INSERT INTO comments (user_id, comment, parent_id) VALUES (?, ?, ?)");
$stmt->execute([$userId, $comment, $parentId]);

header("Location: ../public/comments.php");
exit;
