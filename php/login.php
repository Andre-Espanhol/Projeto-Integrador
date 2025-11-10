<?php
require 'db_connect.php';
session_start();

header('Content-Type: application/json');
error_reporting(0); // evita que mensagens de aviso quebrem o JSON

$data = json_decode(file_get_contents("php://input"), true);

$email = $data['email'] ?? '';
$senha = $data['senha'] ?? '';
$tipo = $data['tipo'] ?? '';

if (!$email || !$senha || !$tipo) {
    echo json_encode(["success" => false, "error" => "Preencha todos os campos!"]);
    exit;
}

// Escolhe a coleção correta
$collectionName = ($tipo === "empresa") ? "Enterprises" : "Users";
$collection = $database->selectCollection($collectionName);

// Procura o usuário pelo email
$user = $collection->findOne(["email" => $email]);

if (!$user) {
    echo json_encode(["success" => false, "error" => "Usuário não encontrado."]);
    exit;
}

// Verifica a senha
if (!password_verify($senha, $user['senha'])) {
    echo json_encode(["success" => false, "error" => "Senha incorreta."]);
    exit;
}

// Login OK
$_SESSION['tipo'] = $tipo;

echo json_encode([
    "success" => true,
    "message" => "Login realizado com sucesso!",
    "tipo" => $tipo
]);
exit; // ⚠️ muito importante!
?>
