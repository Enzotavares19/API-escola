<?php
class AlunoModel {
    private $conn;
    public function __construct($db) { $this->conn = $db; }

    public function cadastrarAluno($nome, $email, $senha) {
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
        $query = "INSERT INTO usuarios (nome, email, senha, perfil) VALUES (:nome, :email, :senha, 'aluno')";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senhaHash);
        return $stmt->execute();
    }

    public function getMonitoramentoAlunos() {
        $query = "SELECT u.id, u.nome, d.disciplina, d.nota, d.faltas FROM usuarios u LEFT JOIN desempenho d ON u.id = d.aluno_id WHERE u.perfil = 'aluno'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $alunos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($alunos as $key => $aluno) {
            $risco = 'Baixo';
            $nota = $aluno['nota'] ?? 0;
            $faltas = $aluno['faltas'] ?? 0;

            if ($faltas >= 15 || ($nota < 5.0 && $aluno['disciplina'] != null)) $risco = 'Alto';
            elseif ($faltas >= 10 || ($nota < 6.0 && $aluno['disciplina'] != null)) $risco = 'Médio';
            $alunos[$key]['risco_evasao'] = $risco;
        }
        return $alunos;
    }

    public function getDadosAluno($aluno_id) {
        $query = "SELECT u.nome, d.disciplina, d.nota, d.faltas FROM usuarios u LEFT JOIN desempenho d ON u.id = d.aluno_id WHERE u.id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $aluno_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function registrarIntervencao($aluno_id, $descricao) {
        $query = "INSERT INTO intervencoes (aluno_id, descricao) VALUES (:aluno_id, :descricao)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':aluno_id', $aluno_id);
        $stmt->bindParam(':descricao', $descricao);
        return $stmt->execute();
    }

    public function getIntervencoes($aluno_id) {
        $query = "SELECT data_registro, descricao FROM intervencoes WHERE aluno_id = :aluno_id ORDER BY data_registro DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':aluno_id', $aluno_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>