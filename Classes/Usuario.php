<?php 
require_once "Database.php"; // D maiúsculo igual ao nome do arquivo

class Usuario {

    // Atributo privado que armazena a conexão com o banco de dados (PDO)
    // É definido como "private" para garantir encapsulamento,
    // ou seja, só pode ser acessado dentro desta classe.
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->connect();
    }

    public function cadastrar($nome, $email, $senha){

           try {
    

            $sql = "SELECT id FROM usuarios WHERE email = :email";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':email' => $email]);

            if ($stmt->rowCount() > 0) {
                return "email_existe";
            }

            $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

            $sql = "INSERT INTO usuarios 
                    (nome, email, senha) 
                    VALUES 
                    (:nome, :email, :senha)";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':nome'    => $nome,
                ':email'     => $email,
                ':senha' => $senhaHash
            ]);

            return true; // salvou com sucesso!

        } catch (PDOException $e) {
            error_log("Erro ao cadastrar: " . $e->getMessage());
            return false; // algo deu errado
        }
    }


    // Busca os dados do usuário logado pelo id
    public function buscar($id) {
        try {
            $sql = "SELECT id, nome, email FROM usuarios WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            error_log("Erro ao buscar usuário: " . $e->getMessage());
            return false;
        }
    }

    // Atualiza os dados do usuário
    public function editar($id, $nome, $email, $senha = null) {
        try {
            // Se o usuário digitou nova senha, atualiza também
            // Se não digitou, mantém a senha atual
            if ($senha) {
                $sql = "UPDATE usuarios 
                        SET nome = :nome, email = :email, senha = :senha 
                        WHERE id = :id";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([
                    ':nome'  => $nome,
                    ':email' => $email,
                    ':senha' => password_hash($senha, PASSWORD_DEFAULT),
                    ':id'    => $id
                ]);
            } else {
                $sql = "UPDATE usuarios 
                        SET nome = :nome, email = :email 
                        WHERE id = :id";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([
                    ':nome'  => $nome,
                    ':email' => $email,
                    ':id'    => $id
                ]);
            }

            return true;

        } catch (PDOException $e) {
            error_log("Erro ao editar usuário: " . $e->getMessage());
            return false;
        }
    }
}
 