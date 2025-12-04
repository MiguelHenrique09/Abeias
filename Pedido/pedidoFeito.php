<?php
session_start();
include("../bd/conecta.php");

$idCliente = $_SESSION["usuario_id"] ?? 0;

// Excluir pedido se enviado via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idPedidoExcluir'])) {
    $idExcluir = intval($_POST['idPedidoExcluir']);

    // Excluir produtos do pedido primeiro
    mysqli_query($conexao, "DELETE FROM produto_pedido WHERE pedido_idPedido = $idExcluir");

    // Agora excluir o pedido
    mysqli_query($conexao, "DELETE FROM pedido WHERE idPedido = $idExcluir AND id_cliente = $idCliente");

    // Redirecionar para evitar reenvio de formulário
    header("Location: pedidoFeito.php");
    exit;
}

// Buscar todos os pedidos do cliente
$sqlTodos = "
    SELECT idPedido, data_hora_pedido, valor_total, statusPedido 
    FROM pedido 
    WHERE id_cliente = $idCliente
    ORDER BY idPedido DESC
";

$resTodos = mysqli_query($conexao, $sqlTodos);

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
        padding-top: 40px;
    }
    .caixa {
        background-color: #161a33;
        border: 1px solid #2c325c;
        width: 60%;
        margin: 20px auto;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 0 10px #00000055;
    }
    h1, h2 {
        margin-bottom: 20px;
    }
    p {
        font-size: 18px;
        margin: 5px 0;
    }
    .codigo {
        font-size: 22px;
        font-weight: bold;
        color: #d66b23;
        margin-bottom: 10px;
    }
    .back-btn {
        background-color: #d66b23;
        color: white;
        border: none;
        padding: 12px 25px;
        border-radius: 10px;
        font-size: 16px;
        text-decoration: none;
        display: inline-block;
        margin: 10px 5px;
        transition: 0.2s;
        cursor: pointer;
    }
    .back-btn:hover {
        background-color: #b8581d;
    }
    .excluir-btn {
        background-color: #e02424;
        color: #fff;
        border: none;
        padding: 8px 18px;
        border-radius: 8px;
        cursor: pointer;
        margin-top: 10px;
        font-weight: bold;
        transition: 0.2s;
    }
    .excluir-btn:hover {
        background-color: #b81b1b;
    }
</style>
</head>
<body>

<div class="caixa">
    <h1>Todos os seus pedidos</h1>

    <?php if ($resTodos && mysqli_num_rows($resTodos) > 0): ?>
        <?php while ($p = mysqli_fetch_assoc($resTodos)): ?>
            <div class="caixa" style="text-align:left;">
                <p class="codigo">Código: <?= $p['idPedido'] ?></p>
                <p><strong>Data:</strong> <?= $p['data_hora_pedido'] ?></p>
                <p><strong>Total:</strong> <?= 'R$ ' . number_format($p['valor_total'], 2, ',', '.') ?></p>
                <p><strong>Status:</strong> <?= $p['statusPedido'] ?></p>

                <!-- Botão para excluir -->
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="idPedidoExcluir" value="<?= $p['idPedido'] ?>">
                    <button type="submit" class="excluir-btn" onclick="return confirm('Deseja realmente excluir este pedido?');">Excluir Pedido</button>
                </form>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>Nenhum pedido encontrado.</p>
    <?php endif; ?>

</div>

<div style="text-align:center; margin-top:20px;">
    <a class="back-btn" href="pedidos.php">Fazer outro pedido</a>
    <a class="back-btn" href="../index.html">Voltar ao menu inicial</a>
</div>

</body>
</html>
