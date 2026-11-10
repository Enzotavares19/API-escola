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

    public function getAlunoById($id) {
        $query = "SELECT id, nome, email FROM usuarios WHERE id = :id AND perfil = 'aluno'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function atualizarAluno($id, $nome, $email, $senha = null) {
        if (!empty($senha)) {
            $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
            $query = "UPDATE usuarios SET nome = :nome, email = :email, senha = :senha WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':senha', $senhaHash);
        } else {
            $query = "UPDATE usuarios SET nome = :nome, email = :email WHERE id = :id";
            $stmt = $this->conn->prepare($query);
        }
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function excluirAluno($id) {
        $this->conn->prepare("DELETE FROM intervencoes WHERE aluno_id = :id")->execute([':id' => $id]);
        $this->conn->prepare("DELETE FROM desempenho WHERE aluno_id = :id")->execute([':id' => $id]);
        $stmt = $this->conn->prepare("DELETE FROM usuarios WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    public function getMonitoramentoAlunos() {
        $query = "SELECT u.id, u.nome, u.email, d.disciplina, d.nota, d.faltas FROM usuarios u LEFT JOIN desempenho d ON u.id = d.aluno_id WHERE u.perfil = 'aluno'";
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
        $query = "SELECT u.nome, d.disciplina, d.nota, d.faltas FROM usuarios u LEFT JOIN desempenho d ON u.id = d.aluno_id WHERE u.id = :id AND u.perfil = 'aluno'";
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