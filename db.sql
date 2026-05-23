CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome varchar(100),
    email varchar(100),
    senha varchar(255),
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);