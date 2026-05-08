<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$conn = new mysqli("localhost", "root", "", "projeto_balsa");

$data = json_decode(file_get_contents("php://input"), true);

$placa = $data['placa'];
$tipo = $data['tipo'];
$condutor = $data['condutor'];
$valor = $data['valor'];
$pago = $data['pago'] ? 1 : 0; // Converte o checkbox para 1 ou 0

$sql = "INSERT INTO veiculos (placa, tipo, condutor, valor_pago, pago) 
        VALUES ('$placa', '$tipo', '$condutor', '$valor', '$pago')";

if ($conn->query($sql) === TRUE) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "error" => $conn->error]);
}
$conn->close();
?>