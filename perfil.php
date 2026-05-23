<?php
session_start();
/** verifica se a variavel id não existe ou é null, ou seja, se o usuario esta logado ou não */
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

require_once "classes/Usuario.php";

$usuarioService = new Usuario();
$dadosPerfil = $usuarioService->buscar($_SESSION['id']);

$mensagem = '';
$tipo_mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome  = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];

    $resultado = $usuarioService->editar($_SESSION['id'], $nome, $email, $senha);

    if ($resultado) {
        $mensagem = "Perfil atualizado com sucesso!";
        $tipo_mensagem = 'sucesso';
    } else {
        $mensagem = "Erro ao atualizar perfil.";
        $tipo_mensagem = 'erro';
    }
}

include "header.php";
?>

<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card card-bitcoin p-4">
                    <h3 class="title-bitcoin mb-4">Meu Perfil</h3>

                    <?php if (!empty($mensagem)): ?>
                        <div class="alert alert-<?= $tipo_mensagem === 'sucesso' ? 'success' : 'danger' ?>">
                            <?= htmlspecialchars($mensagem) ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST">

                        <div class="form-group mb-3">
                            <label for="nome">Nome</label>
                            <input type="text" class="form-control"
                                   id="nome" name="nome"
                                   value="<?= htmlspecialchars($dadosPerfil['nome']) ?>" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="email">E-mail</label>
                            <input type="email" class="form-control"
                                   id="email" name="email"
                                   value="<?= htmlspecialchars($dadosPerfil['email']) ?>" required>
                        </div>

                        <div class="form-group mb-4">
                            <label for="senha">Nova senha <small class="text-muted">(deixe em branco para manter)</small></label>
                            <input type="password" class="form-control"
                                   id="senha" name="senha">
                        </div>

                        <button type="submit" class="btn btn-bitcoin w-100">
                            Salvar alterações
                        </button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>