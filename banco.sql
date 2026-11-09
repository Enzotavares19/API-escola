CREATE DATABASE IF NOT EXISTS sistema_escolar;
USE sistema_escolar;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    perfil ENUM('aluno', 'professor', 'coordenador', 'diretor') NOT NULL
);

CREATE TABLE desempenho (
    id INT AUTO_INCREMENT PRIMARY KEY,
    aluno_id INT NOT NULL,
    disciplina VARCHAR(50) NOT NULL,
    nota DECIMAL(5,2) DEFAULT 0,
    faltas INT DEFAULT 0,
    FOREIGN KEY (aluno_id) REFERENCES usuarios(id)
);

CREATE TABLE intervencoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    aluno_id INT NOT NULL,
    data_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    descricao TEXT NOT NULL,
    FOREIGN KEY (aluno_id) REFERENCES usuarios(id)
);

INSERT INTO usuarios (nome, email, senha, perfil) VALUES 
('Gabriel Kumagai', 'gabriel@escola.com', '$2y$10$e.w/9Q5X8O3/I5Y8/9Q5X.e.w/9Q5X8O3/I5Y8/9Q5X8O3/I5Y8/9', 'aluno'),
('Ana Julia', 'ana@escola.com', '$2y$10$e.w/9Q5X8O3/I5Y8/9Q5X.e.w/9Q5X8O3/I5Y8/9Q5X8O3/I5Y8/9', 'aluno'),
('Professor Enzo', 'enzo@escola.com', '$2y$10$e.w/9Q5X8O3/I5Y8/9Q5X.e.w/9Q5X8O3/I5Y8/9Q5X8O3/I5Y8/9', 'professor'),
('Diretor Carlos', 'carlos@escola.com', '$2y$10$e.w/9Q5X8O3/I5Y8/9Q5X.e.w/9Q5X8O3/I5Y8/9Q5X8O3/I5Y8/9', 'diretor');

INSERT INTO desempenho (aluno_id, disciplina, nota, faltas) VALUES 
(1, 'Matemática', 8.5, 2),
(2, 'Matemática', 4.0, 18);

INSERT INTO intervencoes (aluno_id, descricao) VALUES 
(2, 'Contato feito com a família. Aluna relatou problemas com transporte público.');