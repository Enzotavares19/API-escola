<?php
require_once __DIR__ . '/../config/Database.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(204); exit; }

$database = new Database();
$pdo      = $database->getConnection();
$metodo   = $_SERVER['REQUEST_METHOD'];
$id       = isset($_GET['id']) ? (int) $_GET['id'] : null;

// GET
if ($metodo === 'GET') {
    if ($id) {
        $stmt = $pdo->prepare(
            "SELECT id, nome, email FROM usuarios WHERE id = ? AND perfil = 'aluno'"
        );
        $stmt->execute([$id]);
        $aluno = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$aluno) {
            http_response_code(404);
            echo json_encode(['erro' => 'Aluno não encontrado']);
            exit;
        }
        echo json_encode($aluno);
    } else {
        $stmt = $pdo->query(
            "SELECT id, nome, email FROM usuarios WHERE perfil = 'aluno' ORDER BY nome"
        );
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    }
    exit;
}

// POST
if ($metodo === 'POST') {
    $dados = json_decode(file_get_contents('php://input'), true);

    if (empty($dados['nome']) || empty($dados['email']) || empty($dados['senha'])) {
        http_response_code(422);
        echo json_encode(['erro' => 'Os campos nome, email e senha são obrigatórios']);
        exit;
    }

    try {
        $stmt = $pdo->prepare(
            "INSERT INTO usuarios (nome, email, senha, perfil)
             VALUES (?, ?, ?, 'aluno')"
        );
        $stmt->execute([
            trim($dados['nome']),
            trim($dados['email']),
            password_hash($dados['senha'], PASSWORD_DEFAULT),
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
        if (!empty($dados['senha'])) {
            $stmt = $pdo->prepare(
                "UPDATE usuarios SET nome = ?, email = ?, senha = ?
                 WHERE id = ? AND perfil = 'aluno'"
            );
            $stmt->execute([
                trim($dados['nome']),
                trim($dados['email']),
                password_hash($dados['senha'], PASSWORD_DEFAULT),
                $id,
            ]);
        } else {
            $stmt = $pdo->prepare(
                "UPDATE usuarios SET nome = ?, email = ?
                 WHERE id = ? AND perfil = 'aluno'"
            );
            $stmt->execute([
                trim($dados['nome']),
                trim($dados['email']),
                $id,
            ]);
        }

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

    $pdo->prepare("DELETE FROM intervencoes WHERE aluno_id = ?")->execute([$id]);
    $pdo->prepare("DELETE FROM desempenho WHERE aluno_id = ?")->execute([$id]);
    $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = ? AND perfil = 'aluno'");
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