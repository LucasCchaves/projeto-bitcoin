<?php
require_once "CotacaoService.php";

class CacheDecorator implements CotacaoService {
    private $servico;
    private $arquivo;
    private $ttl;

    public function __construct(CotacaoService $servico, $arquivo = 'cache_cotacao.json', $ttl = 300) {
        $this->servico  = $servico;
        $this->arquivo  = $arquivo;
        $this->ttl      = $ttl; // 300 segundos = 5 minutos
    }
public function getCotacao(): array {
  
      if (file_exists($this->arquivo) && time() - filemtime($this->arquivo) < $this->ttl) {
        $conteudo = file_get_contents($this->arquivo);
            return json_decode($conteudo, true);


        } else {
           //busca da API, salva e retorna
        $dados = $this->servico->getCotacao();
        file_put_contents($this->arquivo, json_encode($dados));
        return $dados;
        }
    }
}