<?php
// Inicia a sessão para poder destruí-la
session_start();

// Apaga todos os dados da sessão ($_SESSION vira array vazio)
$_SESSION = [];

// Destroi a sessão no servidor
session_destroy();

// Redireciona para o login
header("Location: login.php");
exit;