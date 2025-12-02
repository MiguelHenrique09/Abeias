<?php
session_start();
include("bd/conecta.php");

$idCliente = $_SESSION["usuario_id"];
$produtos = $_POST["produto"] ?? [];
$obs = $_POST["observacoes"];
$status = "confirmando";


if (!$produtos) {
    die("Nenhum produto enviado.");
}

// cria pedido
$sqlPedido = "INSERT INTO pedido (id_cliente, data_hora_pedido, statusPedido, valor_total, observacoes)
              VALUES ($idCliente, NOW(), '$status', 0, '$obs')";

mysqli_query($conexao, $sqlPedido);
$idPedido = mysqli_insert_id($conexao);

// total do pedido
$total = 0;

foreach ($produtos as $idProduto => $qtd) {

    if ($qtd > 0) {

        // busca preço
        $sqlP = "SELECT preco_atual FROM produto WHERE idProduto = $idProduto";
        $res = mysqli_query($conexao, $sqlP);
        $prod = mysqli_fetch_assoc($res);
        
        $preco = $prod["preco_atual"];
        $subtotal = $preco * $qtd;
        $total += $subtotal;

        // insere item no pedido
        $sqlItem = "INSERT INTO produto_pedido (pedido_idPedido, produto_idProduto, quantidade, preco_unitario)
                    VALUES ($idPedido, $idProduto, $qtd, $preco)";
        mysqli_query($conexao, $sqlItem);
    }
}

// atualiza total no pedido
$sqlUp = "UPDATE pedido SET valor_total = $total WHERE idPedido = $idPedido";
mysqli_query($conexao, $sqlUp);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Pedido Confirmado</title>

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #0b0e27;
        color: #ffffff;
        text-align: center;
        padding-top: 80px;
    }

    .caixa {
        background-color: #161a33;
        border: 1px solid #2c325c;
        width: 50%;
        margin: auto;
        padding: 40px;
        border-radius: 15px;
        box-shadow: 0 0 10px #00000055;
    }

    h1 {
        font-size: 32px;
        margin-bottom: 20px;
    }

    p {
        font-size: 18px;
        margin-bottom: 8px;
    }

    .codigo {
        font-size: 26px;
        font-weight: bold;
        color: #d66b23;
        margin-top: 10px;
        margin-bottom: 25px;
    }

    .btn {
        background-color: #d66b23;
        color: white;
        border: none;
        padding: 14px 35px;
        border-radius: 10px;
        font-size: 18px;
        text-decoration: none;
        display: inline-block;
        margin-top: 20px;
        transition: 0.2s;
    }

    .btn:hover {
        background-color: #b8581d;
    }
</style>
</head>
<body>

<div class="caixa">



    <h1>Pedido feito com sucesso</h1>

    <p>Seu pedido foi registrado</p>

    <p class="codigo">Código do pedido: <br> <?= $idPedido ?></p>

        <p class="codigo">Preço Total <br> <?= $total ?></p>
 <p class="codigo">Preço Total <br> <?= $nome ?></p>
        


    <a class="btn" href="pedidos.php">Fazer outro pedido</a>

     <a class="back-btn" href="login.php"> Voltar</a>
   </div>

</body>
</html>
