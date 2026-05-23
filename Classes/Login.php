<?php

require_once "Database.php";

class Login {

    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->connect();
    }

    // Recebe o email e senha digitados no formulário
    public function verificarLogin($email, $senha) {
        try {
            // Busca o usuário no banco pelo email
            $sql = "SELECT id, nome, senha FROM usuarios WHERE email = :email";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':email' => $email]);

            // fetch() retorna uma linha do banco como array associativo
            // ex: ['id' => 1, 'nome' => 'Lucas', 'senha' => '$2y$10$...']
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            // Se não encontrou nenhum usuário com esse email
            if (!$usuario) {
                return false;
            }

            // Compara a senha digitada com o hash salvo no banco
            // password_verify() retorna true se bater, false se não bater
            if (password_verify($senha, $usuario['senha'])) {
                return $usuario; // retorna os dados do usuário (id, nome)
            } else {
                return false; // senha errada
            }

        } catch (PDOException $e) {
            error_log("Erro no login: " . $e->getMessage());
            return false;
        }
    }
}