<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$conn = new mysqli("localhost", "root", "", "projeto_balsa");

$sql = "SELECT DATE(data_embarque) as data, SUM(valor_pago) as total 
        FROM veiculos 
        GROUP BY DATE(data_embarque) 
        LIMIT 7"; // Pega os últimos 7 dias

$result = $conn->query($sql);
$dados = [];

while($row = $result->fetch_assoc()) {
    $dados[] = [
        "label" => date("d/m", strtotime($row['data'])),
        "valor" => (float)$row['total']
    ];
}

echo json_encode($dados);
$conn->close();
?>