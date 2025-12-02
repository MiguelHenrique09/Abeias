<?php
session_start();
include("bd/conecta.php");



$idCliente = $_SESSION["usuario_id"];

// busca produtos
$sql = "SELECT * FROM produto";
$produtos = mysqli_query($conexao, $sql);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Fazer Pedido</title>
    <style>
        /* ======== ESTILO GERAL ======== */
        body {
            font-family: Arial, sans-serif;
            background-color: #0b0e27;
            /* Fundo escuro igual na imagem */
            color: #ffffff;
            padding: 20px;
            text-align: center;
        }

        /* Títulos */
        h2 {
            font-size: 32px;
            margin-bottom: 20px;
            font-weight: bold;
        }

        /* ======== CAIXA DE PRODUTO ======== */
        .produto {
            background-color: #161a33;
            border: 1px solid #252b50;
            padding: 20px;
            border-radius: 10px;
            width: 60%;
            margin: 20px auto;
            text-align: left;
        }

        .produto strong {
            font-size: 20px;
            color: #ffffff;
        }

        /* Input de quantidade */
        input[type="number"] {
            padding: 6px;
            width: 80px;
            border-radius: 5px;
            border: none;
            outline: none;
            background-color: #0d112b;
            color: #ffffff;
            font-size: 14px;
        }

        /* ======== INPUT OBSERVAÇÕES ======== */
        input[type="text"] {
            width: 60%;
            padding: 10px;
            margin-top: 20px;
            border-radius: 8px;
            border: none;
            background-color: #161a33;
            color: white;
        }

        /* Placeholder */
        input::placeholder {
            color: #cccccc;
        }

        /* ======== BOTÃO ENVIAR ======== */
        button {
            margin-top: 25px;
            background-color: #d66b23;
            border: none;
            padding: 12px 30px;
            border-radius: 10px;
            color: white;
            cursor: pointer;
            font-size: 18px;
            transition: 0.2s;
        }

        button:hover {
            background-color: #b8581d;
        }

        /* ======== TABELA (CASO QUEIRA USAR DEPOIS) ======== */
        table {
            width: 80%;
            margin: 0 auto;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 12px;
            border-bottom: 1px solid #2c325c;
        }

        th {
            background-color: #1c2140;
            color: white;
        }

        td {
            background-color: #161a33;
        }

        /* ======== BOTÕES DA TABELA ======== */
        .btn {
            padding: 8px 18px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
        }

        .btn-editar {
            background-color: #d66b23;
            color: white;
        }

        .btn-excluir {
            background-color: #b8382b;
            color: white;
        }

        .btn-editar:hover {
            background-color: #b8581d;
        }

        .btn-excluir:hover {
            background-color: #922a22;
        }
    </style>
</head>

<body>

    <h2>Montar Pedido</h2>


    <form action="processa_pedido.php" method="post">

        <?php while ($p = mysqli_fetch_assoc($produtos)): ?>
            <div class="produto">
                <strong><?= $p['nome_produto'] ?></strong><br>
                Preço: R$ <?= number_format($p['preco_atual'], 2, ',', '.') ?><br><br>

                Quantidade:
                <input type="number" name="produto[<?= $p['idProduto'] ?>]" min="0" value="0">



            </div>
        <?php endwhile; ?>

        Observações :
        <input type="text" name="observacoes" placeholder="Faça suas observações">

        <button type="submit">Enviar Pedido</button>

    </form>

</body>

</html>