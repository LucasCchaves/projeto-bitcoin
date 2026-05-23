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
        </div>

    </div>
</div>

<script>// ✅ Deixa só essa — ela já está completa!
async function pegarCotacaoBTC() {
    try {
        const resposta = await fetch(
            "https://api.coingecko.com/api/v3/simple/price?ids=bitcoin&vs_currencies=usd"
        );

        if (!resposta.ok) {
            throw new Error("API fora do ar. Código: " + resposta.status);
        }

        const dados = await resposta.json();
        let preco = dados.bitcoin.usd;

        document.getElementById("cotacao_btc").innerText =
            "BTC: $" + preco.toLocaleString("en-US", { minimumFractionDigits: 2 });

        const agora = new Date();
        const horario = agora.toLocaleTimeString("pt-BR");
        document.getElementById("ultima_atualizacao").innerText = 
            "Última atualização: " + horario;

    } catch (erro) {
        document.getElementById("cotacao_btc").innerText = "Erro ao carregar cotação";
        console.error(erro);
    }
}

pegarCotacaoBTC();
setInterval(pegarCotacaoBTC, 10000);
</script>