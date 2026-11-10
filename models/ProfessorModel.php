<?php
class ProfessorModel {
    private $conn;

    public function __construct($db) { $this->conn = $db; }

    public function getDesempenhoTodosAlunos() {
        $query = "SELECT u.id as aluno_id, u.nome, d.disciplina, d.nota, d.faltas
                  FROM usuarios u LEFT JOIN desempenho d ON u.id = d.aluno_id
                  WHERE u.perfil = 'aluno' ORDER BY u.nome ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDesempenhoAluno($aluno_id) {
        $query = "SELECT u.id as aluno_id, u.nome, d.disciplina, d.nota, d.faltas
                  FROM usuarios u LEFT JOIN desempenho d ON u.id = d.aluno_id
                  WHERE u.id = :id AND u.perfil = 'aluno'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $aluno_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function salvarDesempenho($aluno_id, $disciplina, $nota, $faltas) {
        $queryCheck = "SELECT id FROM desempenho WHERE aluno_id = :aluno_id";
        $stmtCheck = $this->conn->prepare($queryCheck);
        $stmtCheck->bindParam(':aluno_id', $aluno_id);
        $stmtCheck->execute();

        if ($stmtCheck->fetch()) {
            $query = "UPDATE desempenho SET disciplina = :disciplina, nota = :nota, faltas = :faltas WHERE aluno_id = :aluno_id";
        } else {
            $query = "INSERT INTO desempenho (aluno_id, disciplina, nota, faltas) VALUES (:aluno_id, :disciplina, :nota, :faltas)";
        }
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':aluno_id', $aluno_id);
        $stmt->bindParam(':disciplina', $disciplina);
        $stmt->bindParam(':nota', $nota);
        $stmt->bindParam(':faltas', $faltas);
        return $stmt->execute();
    }
}
?>