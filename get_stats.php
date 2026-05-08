<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$conn = new mysqli("localhost", "root", "", "projeto_balsa");

// 1. Total de Travessias
$totalTravessias = $conn->query("SELECT COUNT(*) as total FROM veiculos")->fetch_assoc()['total'];

// 2. Receita Total (Soma de todos os valores)
$receitaTotal = $conn->query("SELECT SUM(valor_pago) as total FROM veiculos")->fetch_assoc()['total'] ?? 0;

// 3. Valores Recebidos (Apenas onde pago = 1)
$recebidos = $conn->query("SELECT SUM(valor_pago) as total FROM veiculos WHERE pago = 1")->fetch_assoc()['total'] ?? 0;

// 4. Valores Pendentes (Apenas onde pago = 0)
$pendentes = $conn->query("SELECT SUM(valor_pago) as total FROM veiculos WHERE pago = 0")->fetch_assoc()['total'] ?? 0;

// 5. Estatísticas de Hoje
$hoje = date('Y-m-d');
$travessiasHoje = $conn->query("SELECT COUNT(*) as total FROM veiculos WHERE DATE(data_embarque) = '$hoje'")->fetch_assoc()['total'];
$receitaHoje = $conn->query("SELECT SUM(valor_pago) as total FROM veiculos WHERE DATE(data_embarque) = '$hoje'")->fetch_assoc()['total'] ?? 0;

echo json_encode([
    "totalTravessias" => $totalTravessias,
    "receitaTotal" => (float)$receitaTotal,
    "recebidos" => (float)$recebidos,
    "pendentes" => (float)$pendentes,
    "travessiasHoje" => $travessiasHoje,
    "receitaHoje" => (float)$receitaHoje
]);

$conn->close();
?>