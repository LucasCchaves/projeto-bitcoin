## Regras de negócio

## Cadastro
-   O usuario deve cadastrar o valor comprado, a cotação, data e hora;
-   O sistema deve calcular automaticamente a quantidade de bitcoin com base na cotação e valor;
-   O sistema deve listar em uma tabela os dados das compras organizados por ordem de data;
-   



## 💡 Entendendo as duas funções do listar

**`pegarCotacaoBTC`** — você já conhece do `index.php`! A única diferença é que agora ao invés de mostrar o preço num `<h1>`, ela guarda em `cotacaoAtual` e chama `atualizarTabela()`.

**`atualizarTabela`** — função nova! Ela faz três coisas:
```
1. Encontra todas as linhas da tabela
2. Lê os dados das etiquetas invisíveis (data-btc, data-investido)
3. Calcula e preenche as células "aguardando..."