<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

require_once 'classes/Compra.php';

if (!isset($_GET['id'])) {
    header("Location: listar.php");
    exit;
}

$id = $_GET['id'];
$usuario_id = $_SESSION['id'];
$compraService = new Compra();

// Se o formulário foi submetido, atualiza no banco
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $comprado    = str_replace(',', '.', $_POST['comprado']);
    $cotacao     = str_replace(',', '.', $_POST['cotacao']);
    $data_compra = $_POST['data_compra'];
    $hora_compra = $_POST['hora_compra'];
    $quant_btc   = $comprado / $cotacao;

    $compraService->editar($id, $comprado, $cotacao, $data_compra, $hora_compra, $quant_btc, $usuario_id);
    header("Location: listar.php");
    exit;
}

// Busca os dados atuais da compra para preencher o formulário
$dadosCompra = $compraService->buscarPorId($id, $usuario_id);

// Se não encontrou, redireciona
if (!$dadosCompra) {
    header("Location: listar.php");
    exit;
}

include "header.php";
?>

<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card card-bitcoin p-4">
                    <h3 class="title-bitcoin mb-4">Editar Compra</h3>

                    <form method="POST">

                        <div class="form-group mb-3">
                            <label for="comprado">Valor comprado - USD</label>
                            <!-- value preenche o campo com o valor atual da compra -->
                            <input type="number" step="0.01" min="0.01"
                                   class="form-control" id="comprado"
                                   name="comprado" value="<?= $dadosCompra['comprado'] ?>" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="cotacao">Cotação</label>
                            <input type="number" step="0.01" min="0.01"
                                   class="form-control" id="cotacao"
                                   name="cotacao" value="<?= $dadosCompra['cotacao'] ?>" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="data_compra">Data da compra</label>
                            <input type="date" class="form-control"
                                   id="data_compra" name="data_compra"
                                   value="<?= $dadosCompra['data_compra'] ?>" required>
                        </div>

                        <div class="form-group mb-4">
                            <label for="hora_compra">Hora da compra</label>
                            <input type="time" class="form-control"
                                   id="hora_compra" name="hora_compra"
                                   value="<?= $dadosCompra['hora_compra'] ?>" required>
                        </div>

                        <button type="submit" class="btn btn-bitcoin w-100">
                            Salvar alterações
                        </button>

                        <div class="text-white fw-bold text-center mt-2">
                            <small><a href="listar.php">Cancelar</a></small>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>