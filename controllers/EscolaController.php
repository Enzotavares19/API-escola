<?php
require_once 'config/Database.php';
require_once 'models/AlunoModel.php';
require_once 'models/ProfessorModel.php';

class EscolaController {
    private $db;
    private $alunoModel;
    private $professorModel;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->alunoModel = new AlunoModel($this->db);
        $this->professorModel = new ProfessorModel($this->db);
    }

    public function dashboardCoordenacao() {
        $alunosMonitorados = $this->alunoModel->getMonitoramentoAlunos();
        $mensagem = isset($_GET['msg']) ? $_GET['msg'] : '';
        require_once 'views/header.php';
        require_once 'views/dashboard_coordenacao.php';
    }

    public function formNovoAluno() {
        require_once 'views/header.php';
        require_once 'views/form_aluno.php';
    }

    public function salvarAluno() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->alunoModel->cadastrarAluno($_POST['nome'], $_POST['email'], $_POST['senha']);
            header("Location: index.php?acao=dashboard&msg=aluno_criado");
            exit;
        }
    }
    
    public function formEditarAluno() {
        $id = $_GET['id'];
        $aluno = $this->alunoModel->getAlunoById($id);
        require_once 'views/header.php';
        require_once 'views/form_edita_aluno.php';
    }
    
    public function atualizarAluno() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->alunoModel->atualizarAluno($_POST['id'], $_POST['nome'], $_POST['email'], $_POST['senha']);
            header("Location: index.php?acao=dashboard&msg=aluno_atualizado");
            exit;
        }
    }
    
    public function excluirAluno() {
        if (isset($_GET['id'])) {
            $this->alunoModel->excluirAluno($_GET['id']);
            header("Location: index.php?acao=dashboard&msg=aluno_excluido");
            exit;
        }
    }

    public function dashboardProfessor() {
        $alunos = $this->professorModel->getDesempenhoTodosAlunos();
        $mensagem = isset($_GET['msg']) ? $_GET['msg'] : '';
        require_once 'views/header.php';
        require_once 'views/dashboard_professor.php';
    }

    public function formNota() {
        $aluno_id = $_GET['id'];
        $dados = $this->professorModel->getDesempenhoAluno($aluno_id);
        require_once 'views/header.php';
        require_once 'views/form_nota.php';
    }

    public function salvarRegistro() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->professorModel->salvarDesempenho($_POST['aluno_id'], $_POST['disciplina'], $_POST['nota'], $_POST['faltas']);
            header("Location: index.php?acao=professor&msg=sucesso");
            exit;
        }
    }

    public function dashboardAluno() {
        $aluno_id = isset($_GET['id']) ? $_GET['id'] : 1; 
        $boletim = $this->alunoModel->getDadosAluno($aluno_id);
        require_once 'views/header.php';
        require_once 'views/dashboard_aluno.php';
    }

    public function intervir() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->alunoModel->registrarIntervencao($_POST['aluno_id'], $_POST['descricao']);
            header("Location: index.php?acao=dashboard&msg=intervencao_ok");
            exit;
        }
        $aluno_id = $_GET['id'];
        require_once 'views/header.php';
        require_once 'views/form_intervencao.php';
    }

    public function verProntuario() {
        $aluno_id = $_GET['id'];
        $dadosAluno = $this->alunoModel->getDadosAluno($aluno_id);
        $nomeAluno = !empty($dadosAluno) ? $dadosAluno[0]['nome'] : 'Aluno';
        $historico = $this->alunoModel->getIntervencoes($aluno_id);
        require_once 'views/header.php';
        require_once 'views/prontuario_aluno.php';
    }
}
?>