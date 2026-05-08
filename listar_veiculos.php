<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$conn = new mysqli("localhost", "root", "", "projeto_balsa");

// Busca todos os veículos, do mais recente para o mais antigo
$sql = "SELECT * FROM veiculos ORDER BY data_embarque DESC";
$result = $conn->query($sql);

$veiculos = [];
while($row = $result->fetch_assoc()) {
    $veiculos[] = $row;
}

echo json_encode($veiculos);
$conn->close();
?>