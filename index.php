<?php
require_once 'controllers/EscolaController.php';

$controller = new EscolaController();
$acao = isset($_GET['acao']) ? $_GET['acao'] : 'dashboard';

switch ($acao) {
    case 'dashboard': $controller->dashboardCoordenacao(); break;
    case 'novo_aluno': $controller->formNovoAluno(); break;
    case 'salvar_aluno': $controller->salvarAluno(); break;
    case 'editar_aluno': $controller->formEditarAluno(); break; 
    case 'atualizar_aluno': $controller->atualizarAluno(); break; 
    case 'excluir_aluno': $controller->excluirAluno(); break; 
    
    case 'professor': $controller->dashboardProfessor(); break;
    case 'editar_nota': $controller->formNota(); break;
    case 'salvar_registro': $controller->salvarRegistro(); break;
    

    case 'aluno': $controller->dashboardAluno(); break;
    

    case 'intervir': $controller->intervir(); break;
    case 'prontuario': $controller->verProntuario(); break;
    
    default: 
        echo "Página não encontrada."; 
        break;
}
?>