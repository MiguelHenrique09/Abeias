<?php
session_start();
include("bd/conecta.php");



$idCliente = $_SESSION["usuario_id"];
$produtos = $_POST["produto"] ?? [];
 $status = "confirmando";
 $obs = $_POST["observacoes"];
if (!$produtos) {
    die("Nenhum produto enviado.");
}

// cria pedido
$sqlPedido = "INSERT INTO pedido (id_cliente, data_hora_pedido, statusPedido, valor_total,observacoes)
              VALUES ($idCliente, NOW(), 'confirmando', 0,'$obs')";


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
       

        // insere produto_pedido
    $sqlItem = "INSERT INTO produto_pedido (pedido_idPedido, produto_idProduto, quantidade, preco_unitario)
VALUES ($idPedido, $idProduto, $qtd, $preco)";
        mysqli_query($conexao, $sqlItem);
    }
}

// atualiza total no pedido
$sqlUp = "UPDATE pedido SET valor_total = $total WHERE idPedido = $idPedido";
mysqli_query($conexao, $sqlUp);

echo "Pedido feito com sucesso, sô!<br>";
echo "Código do pedido: $idPedido<br>";
echo "<a href='fazer_pedido.php'>Fazer outro pedido</a>";
