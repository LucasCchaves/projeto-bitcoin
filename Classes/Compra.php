<?php 
require_once "Database.php"; // D maiúsculo igual ao nome do arquivo

class Compra {

    // Atributo privado que armazena a conexão com o banco de dados (PDO)
    // É definido como "private" para garantir encapsulamento,
    // ou seja, só pode ser acessado dentro desta classe.
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->connect();
    }
    
public function adicionar($comprado, $cotacao, $data_compra, $hora_compra, $quant_btc, $usuario_id) {
    
    if (empty($comprado) || $cotacao <= 0 || $quant_btc <= 0) {
        return false;
    }

    try {
        // Adicionado usuario_id no INSERT para vincular a compra ao usuário
        $sql = "INSERT INTO compras 
                (comprado, cotacao, data_compra, hora_compra, quant_btc, usuario_id) 
                VALUES 
                (:comprado, :cotacao, :data_compra, :hora_compra, :quant_btc, :usuario_id)";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':comprado'    => $comprado,
            ':cotacao'     => $cotacao,
            ':data_compra' => $data_compra,
            ':hora_compra' => $hora_compra,
            ':quant_btc'   => $quant_btc,
            ':usuario_id'  => $usuario_id  // vincula a compra ao usuário logado
        ]);

        return true;

    } catch (PDOException $e) {
        error_log("Erro ao inserir compra: " . $e->getMessage());
        return false;
    }
}

public function listar($usuario_id) {
    // WHERE usuario_id filtra apenas as compras do usuário logado
    $sql = "SELECT id, comprado, cotacao, data_compra, hora_compra, quant_btc 
            FROM compras 
            WHERE usuario_id = :usuario_id
            ORDER BY data_compra ASC";

    $stmt = $this->db->prepare($sql);
    $stmt->execute([':usuario_id' => $usuario_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function excluir($id, $usuario_id) {
    try {
        // WHERE usuario_id garante que só exclui compras do próprio usuário
        $sql = "DELETE FROM compras WHERE id = :id AND usuario_id = :usuario_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':id'         => $id,
            ':usuario_id' => $usuario_id
        ]);

        return true;

    } catch (PDOException $e) {
        error_log("Erro ao excluir: " . $e->getMessage());
        return false;
    }
}

public function buscarPorId($id, $usuario_id) {
    try {
        // usuario_id garante que o usuário só acessa as próprias compras
        $sql = "SELECT * FROM compras WHERE id = :id AND usuario_id = :usuario_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':id'         => $id,
            ':usuario_id' => $usuario_id
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        error_log("Erro ao buscar compra: " . $e->getMessage());

        return false;
    }
}

public function editar($id, $comprado, $cotacao, $data_compra, $hora_compra, $quant_btc, $usuario_id) {
    try {
        // UPDATE atualiza os dados da compra existente
        // WHERE id E usuario_id garante que só edita a própria compra
        $sql = "UPDATE compras 
                SET comprado    = :comprado,
                    cotacao     = :cotacao,
                    data_compra = :data_compra,
                    hora_compra = :hora_compra,
                    quant_btc   = :quant_btc
                WHERE id = :id AND usuario_id = :usuario_id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':comprado'    => $comprado,
            ':cotacao'     => $cotacao,
            ':data_compra' => $data_compra,
            ':hora_compra' => $hora_compra,
            ':quant_btc'   => $quant_btc,
            ':id'          => $id,
            ':usuario_id'  => $usuario_id
        ]);

        return true;

    } catch (PDOException $e) {
        error_log("Erro ao editar: " . $e->getMessage());
        return false;
    }
}

}