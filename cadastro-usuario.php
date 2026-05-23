<?php
// Importa a classe Usuario que contém a lógica de cadastro no banco de dados
require_once 'classes/Usuario.php';

// Variáveis que guardam a mensagem de feedback e seu tipo (sucesso ou erro)
$mensagem = "";
$tipo_mensagem = "";

// Verifica se o formulário foi enviado (método POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // trim() remove espaços extras no início e fim do texto digitado
    $nome  = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = $_POST['senha']; // senha não usa trim para preservar espaços intencionais

    // Valida se o email tem um formato válido (ex: usuario@email.com)
    // filter_var retorna false se o formato for inválido
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mensagem = "E-mail inválido.";
        $tipo_mensagem = "erro";
    } else {
        // Instancia a classe Usuario e chama o método de cadastro
        $cadastro = new Usuario();
        $resultado = $cadastro->cadastrar($nome, $email, $senha);

        // Trata o retorno do método:
        // "email_existe" → email já cadastrado no banco
        // true           → cadastro realizado com sucesso
        // false          → erro interno (ex: falha no banco)
        if ($resultado === "email_existe") {
            $mensagem = "Este e-mail já está cadastrado.";
            $tipo_mensagem = "erro";
        } elseif ($resultado === true) {
            $mensagem = "Cadastro realizado com sucesso!";
            $tipo_mensagem = "sucesso";
        } else {
            $mensagem = "Erro ao cadastrar. Tente novamente.";
            $tipo_mensagem = "erro";
        }
    }
}
?>

<?php include "header-publico.php"; // Inclui o cabeçalho da página (navbar, head, etc) ?>

<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card card-bitcoin p-4">
                    <h3 class="title-bitcoin mb-4">Cadastro de Usuário</h3>

                    <!-- Exibe a mensagem de feedback apenas se ela não estiver vazia -->
                    <?php if (!empty($mensagem)): ?>
                        <!-- Alterna entre alert-success e alert-danger conforme o tipo -->
                        <div class="alert alert-<?= $tipo_mensagem === 'sucesso' ? 'success' : 'danger' ?>">
                            <!-- htmlspecialchars evita XSS ao exibir texto vindo do servidor -->
                            <?= htmlspecialchars($mensagem) ?>
                        </div>
                    <?php endif; ?>

                    <!-- O formulário envia os dados para a própria página via POST -->
                    <form method="POST">

                        <div class="form-group mb-3">
                            <label for="nome">Nome</label>
                            <input type="text"
                                   class="form-control" id="nome" 
                                   name="nome" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="email">E-mail</label>
                            <!-- type="email" faz validação básica de formato no navegador -->
                            <input type="email"
                                   class="form-control" id="email" 
                                   name="email" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="senha">Senha</label>
                            <!-- type="password" oculta os caracteres digitados -->
                            <input type="password" class="form-control" 
                                   id="senha" name="senha" required>
                        </div>

                        <button type="submit" class="btn btn-bitcoin w-100">
                            Cadastrar
                        </button>

                        <!-- Link para a página de login caso o usuário já tenha conta -->
                        <div class="text-white fw-bold text-center mt-2">
                            <small>Já tem conta? <a href="login.php">Entrar</a></small>
                        </div>      

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>