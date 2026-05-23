<?php
require_once "CotacaoService.php";

class CoinGeckoService implements CotacaoService {
    public function getCotacao(): array {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.coingecko.com/api/v3/simple/price?ids=bitcoin&vs_currencies=usd');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (projeto-bitcoin/1.0)');
        $json = curl_exec($ch);
        if ($json === false) {
            var_dump(curl_error($ch));
        }
        curl_close($ch);

        var_dump($json);

        $data = json_decode($json, true);
        return [
            'preco'        => $data['bitcoin']['usd'],
            'atualizado_em' => date('H:i:s')
        ];
    }
}