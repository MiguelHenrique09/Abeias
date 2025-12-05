<?php
session_start();
include("../bd/conecta.php");



$idCliente = $_SESSION["usuario_id"];
$nomeCliente = $_SESSION["usuario_email"];
$produtos = $_POST["produto"] ?? [];
$obs = $_POST["observacoes"] ?? "";
$status = "confirmando";

$total = 0;

// Se não enviou produtos, volta
if (!$produtos) {
    header("Location: pedidos.php");
    exit;
}

// 1) Cria pedido
$sqlPedido = "INSERT INTO pedido (id_cliente, data_hora_pedido, statusPedido, valor_total, observacoes)
              VALUES ($idCliente, NOW(), '$status', 0, '$obs')";
mysqli_query($conexao, $sqlPedido);

$idPedido = mysqli_insert_id($conexao);

// 2) Insere itens
foreach ($produtos as $idProduto => $qtd) {
    if ($qtd > 0) {
        $sqlP = "SELECT preco_atual FROM produto WHERE idProduto = $idProduto";
        $res = mysqli_query($conexao, $sqlP);
        $prod = mysqli_fetch_assoc($res);

        $preco = $prod['preco_atual'];
        $subtotal = $preco * $qtd;
        $total += $subtotal;

        $sqlItem = "INSERT INTO produto_pedido (pedido_idPedido, produto_idProduto, quantidade, preco_unitario)
                    VALUES ($idPedido, $idProduto, $qtd, $preco)";
        mysqli_query($conexao, $sqlItem);
    }
}

// 3) Atualiza total do pedido
$sqlUp = "UPDATE pedido SET valor_total = $total WHERE idPedido = $idPedido";
mysqli_query($conexao, $sqlUp);

// 4) Salva dados na sessão
$_SESSION["pedidoFeito_id"] = $idPedido;
$_SESSION["pedidoFeito_total"] = $total;
$_SESSION["pedidoFeito_cliente"] = $nomeCliente;
$_SESSION["statusPedido"] = $status; 


// 5) Redireciona para a página final
header("Location: pedidoFeito.php");
exit;
?>