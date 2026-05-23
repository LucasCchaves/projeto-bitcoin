<?php
// session_start() SEMPRE na primeira linha — inicia o sistema de sessões do PHP
session_start();

require_once 'classes/Login.php';

$mensagem = "";
$tipo_mensagem = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email']);
    $senha = $_POST['senha'];

    // Valida o formato do email antes de consultar o banco
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mensagem = "E-mail inválido.";
        $tipo_mensagem = "erro";
    } else {
        $login = new Login();
        $usuario = $login->verificarLogin($email, $senha);

        // Se retornou false, email ou senha estão errados
        if (!$usuario) {
            $mensagem = "E-mail ou senha incorretos.";
            $tipo_mensagem = "erro";
        } else {
            // Guarda os dados do usuário na sessão
            // $_SESSION é um array global acessível em qualquer página
            $_SESSION['id']   = $usuario['id'];
            $_SESSION['nome'] = $usuario['nome'];

            // Redireciona para a página principal
            header("Location: index.php");
            exit; // exit é obrigatório após header() para parar a execução
        }
    }
}
?>

<?php include "header-publico.php"; ?>

<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card card-bitcoin p-4">
                    <h3 class="title-bitcoin mb-4">Login</h3>

                    <!-- Exibe mensagem de erro se houver -->
                    <?php if (!empty($mensagem)): ?>
                        <div class="alert alert-<?= $tipo_mensagem === 'sucesso' ? 'success' : 'danger' ?>">
                            <?= htmlspecialchars($mensagem) ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST">

                        <div class="form-group mb-3">
                            <label for="email">E-mail</label>
                            <input type="email" class="form-control" 
                                   id="email" name="email" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="senha">Senha</label>
                            <input type="password" class="form-control" 
                                   id="senha" name="senha" required>
                        </div>

                        <button type="submit" class="btn btn-bitcoin w-100">
                            Entrar
                        </button>

                        <div class="text-white fw-bold text-center mt-2">
                            <small>Não tem conta? <a href="cadastro-usuario.php">Cadastrar</a></small>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>