<?php
// Permitir que o React acesse este script (CORS)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

$host = "localhost";
$user = "root";
$pass = ""; // Senha padrão do XAMPP é vazia
$dbname = "projeto_balsa";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Erro de conexão"]);
    exit;
}

// Recebe os dados do React
$data = json_decode(file_get_contents("php://input"), true);
$usuario = $data['username'] ?? '';
$senha = $data['password'] ?? '';

// Consulta no banco de dados (Prevenindo SQL Injection)
$stmt = $conn->prepare("SELECT tipo_acesso FROM usuarios WHERE nome_usuario = ? AND senha = ?");
$stmt->bind_param("ss", $usuario, $senha);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    echo json_encode(["success" => true, "type" => $user['tipo_acesso']]);
} else {
    echo json_encode(["success" => false, "message" => "Usuário ou senha inválidos"]);
}

$stmt->close();
$conn->close();
?>