<?php
// conexão
$servidor = "localhost";
$usuario = "root";
$senha_bd = "root";
$nome_bd = "cardapiovirtual";

$conexao = mysqli_connect($servidor, $usuario, $senha_bd, $nome_bd);

if (!$conexao) {
    die("erro na conexão" . mysqli_connect_error());
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Consulta de Pedidos</title>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    body {
        margin: 0;
        padding: 0;
        font-family: 'Segoe UI', Arial, sans-serif;
        background: linear-gradient(135deg, #4c5483ff, #080d2b);
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
    }

    .container {
        width: 40%;
        padding: 50px;
        border-radius: 14px;
        box-shadow: 0px 4px 15px rgba(0,0,0,0.15);
        text-align: center;
        animation: aparecer 0.4s ease;
        background-color: rgba(255,255,255,0.05);
    }

    @keyframes aparecer {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    h2 {
        color: white;
        margin-bottom: 20px;
    }

    label {
        font-weight: 600;
        color: white;
    }

    input {
        margin-top: 10px;
        padding: 12px;
        width: 100%;
        border: 2px solid #ddd;
        border-radius: 8px;
        font-size: 15px;
        outline: none;
        transition: .2s;
    }

    input:focus {
        border-color: #E06A24;
    }

    button {
        margin-top: 18px;
        width: 100%;
        padding: 12px;
        background: #E06A24;
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 16px;
        font-weight: bold;
        transition: .2s;
    }

    button:hover {
        background: #cf5a14;
    }

    .footer {
        margin-top: 15px;
        font-size: 13px;
        color: #ccc;
    }

    .back-btn{
      display:inline-block;
      margin-bottom:25px;
      padding:12px 18px;
      background:var(--primary);
      color:var(--bg);
      border-radius:10px;
      text-decoration:none;
      font-weight:bold;
      transition:.2s;
    



    }

</style>

</head>
<body>


<div class="container">

     


    <a class="back-btn" href="../admin.php"> Voltar</a>

    <h2>Consulta de Pedidos</h2>

    <form method="GET">
        <label>Consultar por data:</label>
        <input type="date" name="dia">

        <label>Consultar por nome do cliente:</label>
        <input type="text" name="nome" placeholder="Ex: João Silva">

        <label>Consultar por email:</label>
        <input type="text" name="email" placeholder="Ex: joao@gmail.com">

        <button type="submit">Consultar</button>
    </form>

    <div class="footer">Abeias Burgers • Sistema interno</div>
</div>

<?php

// CRIA FILTROS DINÂMICOS
$filtros = [];

if (!empty($_GET['dia'])) {
    $dia = mysqli_real_escape_string($conexao, $_GET['dia']);
    $filtros[] = "DATE(pedido.data_hora_pedido) = '$dia'";
}

if (!empty($_GET['nome'])) {
    $nome = mysqli_real_escape_string($conexao, $_GET['nome']);
    $filtros[] = "cliente.nome_cliente LIKE '%$nome%'";
}

if (!empty($_GET['email'])) {
    $email = mysqli_real_escape_string($conexao, $_GET['email']);
    $filtros[] = "cliente.username LIKE '%$email%'";
}

if (!empty($filtros)) {

    $where = "WHERE " . implode(" AND ", $filtros);

    $sql = "
        SELECT 
            pedido.idPedido,
            pedido.data_hora_pedido,
            pedido.valor_total,
            pedido.statusPedido,
            cliente.nome_cliente,
            cliente.username,
            GROUP_CONCAT(CONCAT(produto_pedido.quantidade, 'x ', produto.nome_produto) SEPARATOR ', ') AS itens
        FROM pedido
        JOIN cliente ON cliente.idCliente = pedido.id_cliente
        JOIN produto_pedido ON produto_pedido.pedido_idPedido = pedido.idPedido
        JOIN produto ON produto.idProduto = produto_pedido.produto_idProduto
        $where
        GROUP BY pedido.idPedido
        ORDER BY pedido.data_hora_pedido DESC
    ";

    $resultado = mysqli_query($conexao, $sql);

    if (mysqli_num_rows($resultado) == 0) {

        echo "
        <script>
            Swal.fire({
                icon: 'warning',
                title: 'Nenhum pedido encontrado',
                text: 'Uai, não achei nada com esses filtros não!',
                confirmButtonColor: '#E06A24'
            });
        </script>";

    } else {

        $html = "<strong>Resultados da consulta:</strong><br><br>";
        $totalFinal = 0;

        while ($p = mysqli_fetch_assoc($resultado)) {

            $totalFinal += $p['valor_total'];

            $html .= "
                <div style='text-align:left; margin-bottom:12px;'>
                    <b>Pedido:</b> {$p['idPedido']}<br>
                    <b>Cliente:</b> {$p['nome_cliente']}<br>
                    <b>Email:</b> {$p['username']}<br>
                    <b>Status:</b> {$p['statusPedido']}<br>
                    <b>Itens:</b> {$p['itens']}<br>
                    <b>Total:</b> R$ ".number_format($p['valor_total'], 2, ',', '.')."<br>
                    <b>Horário:</b> {$p['data_hora_pedido']}<br>
                    <hr>
                </div>
            ";
        }

        $totalFormatado = number_format($totalFinal, 2, ',', '.');
        $html .= "<h3 style='color:#E06A24; text-align:right;'>Total: R$ $totalFormatado</h3>";

        echo "
        <script>
            Swal.fire({
                title: 'Pedidos encontrados',
                html: ".json_encode($html).",
                width: 650,
                padding: '20px',
                background: '#fff',
                confirmButtonColor: '#E06A24'
            });
        </script>";
    }
}
?>

</body>
</html>
