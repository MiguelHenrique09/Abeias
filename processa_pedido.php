<?php
session_start();
include("conecta.php");

if (!isset($_SESSION["logado"])) {
    die("Uai, ocê precisa logar primeiro!");
}

$idCliente = $_SESSION["usuario_id"];
$produtos = $_POST["produto"] ?? [];

if (!$produtos) {
    die("Nenhum produto enviado.");
}

// cria pedido
$sqlPedido = "INSERT INTO pedido (id_cliente, data_hora_pedido, statusPedido, valor_total)
              VALUES ($idCliente, NOW(), 'preparando', 0)";


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
        $sqlItem = "INSERT INTO pedido (codigo_pedido, id_cliente, data_hora_pedido, prazo_estimado, valor_total, statusPedido, observacoes)
VALUES (NULL, '$id_cliente', NOW(), '$prazo', '$valor', '$status', '$obs');
";

        mysqli_query($conexao, $sqlItem);
    }
}

// atualiza total no pedido
$sqlUp = "UPDATE pedido SET valor_total = $total WHERE idPedido = $idPedido";
mysqli_query($conexao, $sqlUp);

echo "Pedido feito com sucesso, sô!<br>";
echo "Código do pedido: $idPedido<br>";
echo "<a href='fazer_pedido.php'>Fazer outro pedido</a>";
