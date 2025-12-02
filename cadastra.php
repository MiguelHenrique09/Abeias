<?php 
include "bd/conecta.php";

// receber dados do formulário
$email = $_POST['email'];
$senha = $_POST['password'];
$nome  = $_POST['nome'];

// 1️⃣ Verificar se o email já existe
$stmt = $conexao->prepare("SELECT idCliente FROM cliente WHERE username = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo "<script>alert('Email já registrado!'); window.location.href='cadastro.html';</script>";
    exit;
}

$stmt->close();

// 2️⃣ Inserir novo cliente
$stmt = $conexao->prepare("INSERT INTO cliente (username, password_, nome_cliente) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $email, $senha, $nome);

if ($stmt->execute()) {
    echo "<script>alert('Cadastrado com sucesso!'); window.location.href='login.php';</script>";
    exit;
} else {
    echo "Erro no cadastro: " . $stmt->error;
}

$stmt->close();
$conexao->close();
?>
