<?php
session_start();

// Proteção de rota
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

require_once 'classes/Compra.php';

// Verifica se o id foi passado na URL
if (!isset($_GET['id'])) {
    header("Location: listar.php");
    exit;
}

$id = $_GET['id'];
$usuario_id = $_SESSION['id'];

$compraService = new Compra();
$compraService->excluir($id, $usuario_id);

header("Location: listar.php");
exit;