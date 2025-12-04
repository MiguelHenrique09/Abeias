
<?php
session_start();
include("../bd/conecta.php");

$idPedido = $_SESSION["pedidoFeito_id"] ?? 0;
$total    = $_SESSION["pedidoFeito_total"] ?? 0;
$nome     = $_SESSION["pedidoFeito_cliente"] ?? "Cliente";
    
// Buscar o status real do banco
$status = "Indefinido";

if ($idPedido > 0) {
    $sql = "SELECT statusPedido FROM pedido WHERE idPedido = $idPedido";
    $res = mysqli_query($conexao, $sql);

    if ($res && mysqli_num_rows($res) > 0) {
        $status = mysqli_fetch_assoc($res)['statusPedido'];
    }
}

mysqli_close($conexao);
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

    .back-btn {
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

<?php
// Reabrir conexão para buscar os pedidos do cliente
include("../bd/conecta.php");

$idCliente = $_SESSION["usuario_id"] ?? 0;

// Buscar todos os pedidos desse cliente
$sqlTodos = "
    SELECT idPedido, data_hora_pedido, valor_total, statusPedido 
    FROM pedido 
    WHERE id_cliente = $idCliente
    ORDER BY idPedido DESC
";

$resTodos = mysqli_query($conexao, $sqlTodos);
?>

<div class="caixa" style="margin-top:40px;">
    <h2 style="font-size:28px; margin-bottom:20px;">Todos os seus pedidos</h2>

    <?php
    if ($resTodos && mysqli_num_rows($resTodos) > 0) {
        while ($p = mysqli_fetch_assoc($resTodos)) {
    ?>

        <div style="
            background-color:#0f122b;
            border: 1px solid #2c325c;
            padding: 18px;
            border-radius: 12px;
            margin-bottom: 15px;
            text-align: left;
        ">
            <p class="codigo" style="text-align:left;">
                Código: <?= $p['idPedido'] ?>
            </p>

            <p style="font-size:18px; margin:5px 0;">
                <strong style="color:#d66b23;">Data:</strong> <?= $p['data_hora_pedido'] ?>
            </p>

            <p style="font-size:18px; margin:5px 0;">
                <strong style="color:#d66b23;">Total:</strong>
                <?= 'R$ ' . number_format($p['valor_total'], 2, ',', '.'); ?>
            </p>

            <p style="font-size:18px; margin:5px 0;">
                <strong style="color:#d66b23;">Status:</strong> <?= $p['statusPedido'] ?>
            </p>
        </div>

    <?php } 
    } else { ?>
        <p style="font-size:18px;">Nenhum pedido encontrado.</p>
    <?php } ?>

</div>

<?php mysqli_close($conexao); ?>

    <a class="back-btn" href="pedidos.php">Fazer outro pedido</a>

     <a class="back-btn" href="../index.html"> Voltar ao menu inicial</a>
 

</body>
</html>