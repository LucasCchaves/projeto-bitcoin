<?php
require_once 'classes/CoinGeckoService.php';
require_once 'classes/CacheDecorator.php';

// instancia e envolve aqui
    $coin = new CoinGeckoService();
    $cache = new CacheDecorator($coin);

    $dados = $cache->getCotacao();

    header('Content-Type: application/json');
    echo json_encode($dados);