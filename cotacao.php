<?php

require_once 'classes/CotacaoService.php';
require_once 'classes/CoinGeckoService.php';
require_once 'classes/CacheDecorator.php';

date_default_timezone_set('America/Sao_Paulo');

// instancia e envolve aqui
    $coin = new CoinGeckoService();
    $cache = new CacheDecorator($coin);

    $dados = $cache->getCotacao();

    header('Content-Type: application/json');
    echo json_encode($dados);