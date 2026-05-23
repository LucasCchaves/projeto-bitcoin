
<?php
session_start();

// Se o usuário não estiver logado, redireciona para o login
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

require_once 'classes/Compra.php';

$compraService = new Compra();
$dadosCompra = $compraService->listar($_SESSION['id']);

include "header.php";
?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Compras de Bitcoin</h2>
    <h2 class="cotacao-atual">Carregando valores...</h2>

    <!-- Verifica se há compras antes de exibir a tabela -->
    <?php if (empty($dadosCompra)): ?>

        <p class="text-center text-muted mt-5">
            Nenhuma compra registrada ainda.
            <a href="cadastrar.php">Registrar primeira compra</a>
        </p>

    <?php else: ?>

        <div class="table-responsive">
            <table class="table table-dark table-hover table-bordered text-center align-middle shadow">

                <thead class="table-warning text-dark">
                    <tr>
                      
                        <th>Valor (USD)</th>
                        <th>Cotação</th>
                        <th>Data</th>
                        <th>Hora</th>
                        <th>BTC</th>
                        <th>Valor Atual</th>
                        <th>Rendimento</th>
                        <th>Ações</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($dadosCompra as $item): ?>
                     
                    <!-- cria variaveis data-btc e data-investido em js que recebe os valores inseridos nas tabelas-->
                    <tr data-btc="<?= $item['quant_btc'] ?>"
                        data-investido="<?=  $item['comprado'] ?>">
                        
                        <td>$ <?= number_format($item['comprado'], 2, ',', '.') ?></td>
                        <td>$ <?= number_format($item['cotacao'], 2, ',', '.') ?></td>
                        <td><?= date('d/m/Y', strtotime($item['data_compra'])) ?></td>
                        <td><?= htmlspecialchars($item['hora_compra']) ?></td>
                        <td class="text-success fw-bold">
                            <?= number_format($item['quant_btc'], 8, ',', '.') ?>
                        </td>
                    <!-- as class valor-atual e rendimento são as etiquetas que o js usa para localizar as células -->
                        <td class="valor-atual">aguardando...</td>
                        <td class="rendimento">aguardando...</td>
                           <td>
                            <a href="editar.php?id=<?= $item['id'] ?>" 
                            class="btn btn-warning btn-sm">
                                Editar
                            </a>
                            <a href="excluir.php?id=<?= $item['id'] ?>" 
                            class="btn btn-danger btn-sm"
                            onclick="return confirm('Tem certeza que deseja excluir?')">
                                Excluir
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>

            </table>
        </div>

    <?php endif; ?>
</div>

<script>
// Guarda a cotação aqui para qualquer função conseguir usar
let cotacaoAtual = 0;

async function pegarCotacaoBTC() {
    try {
        const resposta = await fetch(
            "https://api.coingecko.com/api/v3/simple/price?ids=bitcoin&vs_currencies=usd"
        );

        if (!resposta.ok) {
            throw new Error("API fora do ar");
        }

        const dados = await resposta.json();
        cotacaoAtual = dados.bitcoin.usd; // guarda o valor

        atualizarTabela(); // chama a função que vai calcular

    } catch (erro) {
        console.error(erro);
    }
}

function atualizarTabela() {
    // Seleciona todas as linhas que têm data-btc
    const linhas = document.querySelectorAll("tr[data-btc]");

    //Mostra cotação Atual
        document.querySelector(".cotacao-atual").innerText = 
            "$ " + cotacaoAtual.toLocaleString("en-US", { minimumFractionDigits: 2 });

    linhas.forEach(function(linha) {
        // Lê as etiquetas invisíveis que o PHP colocou
        const btc       = parseFloat(linha.dataset.btc);
        const investido = parseFloat(linha.dataset.investido);

        // Faz o cálculo
        const valorAtual  = btc * cotacaoAtual;
        const rendimento  = valorAtual - investido;

        // Encontra as células dessa linha e preenche
        linha.querySelector(".valor-atual").innerText = 
            "$ " + valorAtual.toLocaleString("en-US", { minimumFractionDigits: 2 });

        linha.querySelector(".rendimento").innerText = 
            "$ " + rendimento.toLocaleString("en-US", { minimumFractionDigits: 2 });


        //Alterar a cor de acordo com lucro e prejuizo
        const celulaRendimento = linha.querySelector(".rendimento");
        celulaRendimento.innerText = "$ " + rendimento.toLocaleString("en-US", { minimumFractionDigits: 2 });

            if (rendimento >= 0) {
                celulaRendimento.classList.add("text-success");
            } else {
                celulaRendimento.classList.add("text-danger");
            }
        
    });

    
}

// Executa ao carregar e repete a cada 30 segundos
pegarCotacaoBTC();
setInterval(pegarCotacaoBTC, 30000);
</script>
