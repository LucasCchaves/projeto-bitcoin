<?php 
include "header.php"; 
?>

<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="container text-center mt-5">

        <h1 id="cotacao_btc" class="text-success fw-bold display-4">
            Carregando cotação...
        </h1>

        <!-- Pequeno indicador de quando foi a última atualização -->
        <p id="ultima_atualizacao" class="text-muted mt-2"></p>

        <!-- Botões de acesso rápido -->
        <div class="mt-4">
            <a href="cadastrar.php" class="btn btn-warning me-2">Registrar Compra</a>
            <a href="listar.php" class="btn btn-outline-light">Ver Investimentos</a>
             <a href="limpar-cache.php" class="btn btn-outline-light">atualizar cache</a>
        </div>

    </div>
</div>

<script>// ✅ Deixa só essa — ela já está completa!
async function pegarCotacaoBTC() {
    try {
        const resposta = await fetch(
            "cotacao.php"
        );

        if (!resposta.ok) {
            throw new Error("API fora do ar. Código: " + resposta.status);
        }

        const dados = await resposta.json();
        let preco = dados.preco;

        document.getElementById("cotacao_btc").innerText =
            "BTC: $" + preco.toLocaleString("en-US", { minimumFractionDigits: 2 });

      document.getElementById("ultima_atualizacao").innerText = 
    "Última atualização: " + dados.atualizado_em;

    } catch (erro) {
        document.getElementById("cotacao_btc").innerText = "Erro ao carregar cotação";
        console.error(erro);
    }
}

pegarCotacaoBTC();
setInterval(pegarCotacaoBTC, 10000);
</script>