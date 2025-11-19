<?php
session_start();

// Limpar todas as variáveis da sessão
$_SESSION = array();

// Destruir a sessão
session_destroy();

// Redirecionar para a página de login com mensagem
header("Location: login.php?message=logout_success");
exit;
?>