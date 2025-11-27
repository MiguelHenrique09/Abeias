<?php 
require_once "conecta.php";

// Primeiro: receber dados do formulário
$email = $_POST['email'];
$senha = $_POST['password'];
$nome  = $_POST['nome'];


$stmt = $conexao->prepare("SELECT idCliente FROM cliente WHERE username = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {

echo "<script>alert('Email já registrado!'); window.location.href='cadastro.html';</script>";
exit;


}else{

echo "<script>alert('Cadastrdo com sucesso!'); window.location.href='login.html';</script>";
exit;


}

$stmt = $conexao->prepare("INSERT INTO cliente (username, password_, nome_cliente) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $email, $senha, $nome);

if ($stmt->execute()) {
    echo "Cadastrado com sucesso";
    header("Location: login.php");
    exit;
} else {
    echo "Erro no cadastro: " . $stmt->error;
}
?>
