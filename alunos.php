<?php
require_once 'config.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(204); exit; }

$pdo    = getConexao();
$metodo = $_SERVER['REQUEST_METHOD'];
$id     = isset($_GET['id']) ? (int) $_GET['id'] : null;

// GET
if ($metodo === 'GET') {
    if ($id) {
        $stmt = $pdo->prepare('SELECT * FROM alunos WHERE id = ?');
        $stmt->execute([$id]);
        $aluno = $stmt->fetch();
        if (!$aluno) {
            http_response_code(404);
            echo json_encode(['erro' => 'Aluno não encontrado']);
            exit;
        }
        echo json_encode($aluno);
    } else {
        $stmt = $pdo->query('SELECT * FROM alunos ORDER BY nome');
        echo json_encode($stmt->fetchAll());
    }
    exit;
}

// POST
if ($metodo === 'POST') {
    $dados = json_decode(file_get_contents('php://input'), true);

    if (empty($dados['nome']) || empty($dados['email'])) {
        http_response_code(422);
        echo json_encode(['erro' => 'Os campos nome e email são obrigatórios']);
        exit;
    }

    try {
        $stmt = $pdo->prepare(
            'INSERT INTO alunos (nome, email, data_nascimento, ativo)
             VALUES (?, ?, ?, ?)'
        );
        $stmt->execute([
            trim($dados['nome']),
            trim($dados['email']),
            $dados['data_nascimento'] ?? null,
            isset($dados['ativo']) ? (int) $dados['ativo'] : 1,
        ]);
        http_response_code(201);
        echo json_encode(['id' => (int) $pdo->lastInsertId(), 'mensagem' => 'Aluno criado']);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['erro' => 'Erro ao criar aluno. E-mail já cadastrado?']);
    }
    exit;
}

// PUT
if ($metodo === 'PUT') {
    if (!$id) {
        http_response_code(400);
        echo json_encode(['erro' => 'Informe o id na URL (?id=)']);
        exit;
    }

    $dados = json_decode(file_get_contents('php://input'), true);

    if (empty($dados['nome']) || empty($dados['email'])) {
        http_response_code(422);
        echo json_encode(['erro' => 'Os campos nome e email são obrigatórios']);
        exit;
    }

    try {
        $stmt = $pdo->prepare(
            'UPDATE alunos SET nome = ?, email = ?, data_nascimento = ?, ativo = ?
             WHERE id = ?'
        );
        $stmt->execute([
            trim($dados['nome']),
            trim($dados['email']),
            $dados['data_nascimento'] ?? null,
            isset($dados['ativo']) ? (int) $dados['ativo'] : 1,
            $id,
        ]);
        if ($stmt->rowCount() === 0) {
            http_response_code(404);
            echo json_encode(['erro' => 'Aluno não encontrado']);
            exit;
        }
        echo json_encode(['mensagem' => 'Aluno atualizado']);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['erro' => 'Erro ao atualizar aluno']);
    }
    exit;
}

// DELETE
if ($metodo === 'DELETE') {
    if (!$id) {
        http_response_code(400);
        echo json_encode(['erro' => 'Informe o id na URL (?id=)']);
        exit;
    }

    $stmt = $pdo->prepare('DELETE FROM alunos WHERE id = ?');
    $stmt->execute([$id]);

    if ($stmt->rowCount() === 0) {
        http_response_code(404);
        echo json_encode(['erro' => 'Aluno não encontrado']);
        exit;
    }
    echo json_encode(['mensagem' => 'Aluno removido']);
    exit;
}

http_response_code(405);
echo json_encode(['erro' => 'Método não permitido']);