<?php 
session_start();

    if (!isset($_SESSION['id'])) {
        header("Location: login.php");
        exit;
    }

// Importa a classe Cadastro responsável pelas operações no banco de dados
require_once 'classes/Compra.php';

// Variáveis de feedback para o usuário (começa vazia)
$mensagem = '';
$tipo_mensagem = ''; // 'sucesso' ou 'erro'

// Verifica se o formulário foi enviado via método POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Substitui vírgula por ponto (ex: 1,50 → 1.50)
    $comprado = str_replace(',', '.', $_POST['comprado']);
    $cotacao  = str_replace(',', '.', $_POST['cotacao']);
    $data_compra  = $_POST['data_compra'];
    $hora_compra  = $_POST['hora_compra'];

    // ✅ VALIDAÇÃO — verifica se os valores são numéricos e maiores que zero
    if (!is_numeric($comprado) || !is_numeric($cotacao) || $comprado <= 0 || $cotacao <= 0) {
        $mensagem = "Erro: Valor comprado e cotação devem ser números maiores que zero!";
        $tipo_mensagem = 'erro';

    } elseif (empty($data_compra) || empty($hora_compra)) {
        $mensagem = "Erro: Data e hora são obrigatórios!";
        $tipo_mensagem = 'erro';

    } else {
        // Calcula a quantidade de BTC comprada'
        $quant_btc = $comprado / $cotacao;

        // ✅ Uma única instância reutilizada
        $compraService = new Compra();

        // ✅ Verifica o retorno do método
        $resultado = $compraService->adicionar(
            $comprado,
            $cotacao,
            $data_compra,
            $hora_compra,
            $quant_btc,
            $_SESSION['id'] // usuário logado
        );

        if ($resultado) {
            $mensagem = "Compra registrada com sucesso!";
            $tipo_mensagem = 'sucesso';
        } else {
            $mensagem = "Erro ao registrar compra. Tente novamente.";
            $tipo_mensagem = 'erro';
        }
    }
}

// Inclui o cabeçalho da página
include "header.php";
?>

<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card card-bitcoin p-4">
                    <h3 class="title-bitcoin mb-4">Compra de Bitcoin</h3>

                    <!-- ✅ Exibe mensagem de sucesso ou erro para o usuário -->
                    <?php if (!empty($mensagem)): ?>
                        <div class="alert alert-<?= $tipo_mensagem === 'sucesso' ? 'success' : 'danger' ?>">
                            <?= htmlspecialchars($mensagem) ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST">

                        <div class="form-group mb-3">
                            <label for="comprado">Valor comprado - USD</label>
                            <!-- ✅ type="number" já ajuda a bloquear letras no navegador -->
                            <input type="number" step="0.01" min="0.01"
                                   class="form-control" id="comprado" 
                                   name="comprado" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="cotacao">Cotação</label>
                            <input type="number" step="0.01" min="0.01"
                                   class="form-control" id="cotacao" 
                                   name="cotacao" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="data_compra">Data da compra</label>
                            <input type="date" class="form-control" 
                                   id="data_compra" name="data_compra" required>
                        </div>
                        
                        <div class="form-group mb-4">
                            <label for="hora_compra">Hora da compra</label>
                            <input type="time" class="form-control" 
                                   id="hora_compra" name="hora_compra" required>
                        </div>

                        <button type="submit" class="btn btn-bitcoin w-100">
                            Registrar Compra
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
```

