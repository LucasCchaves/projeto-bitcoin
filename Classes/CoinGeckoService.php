<?php
require_once "CotacaoService.php";

class CoinGeckoService implements CotacaoService {
    public function getCotacao(): array {
        $json = file_get_contents('https://api.coingecko.com/api/v3/simple/price?ids=bitcoin&vs_currencies=usd');
        $data = json_decode($json, true);
        return [
                'preco'        => $data['bitcoin']['usd'],
                'atualizado_em' => date('H:i:s')
                ];
    }
}