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
    body { font-family: Arial; padding: 20px; }
    .produto { border: 1px solid #ccc; padding: 10px; margin-bottom: 10px; border-radius: 5px; }
</style>
</head>
<body>

<h2>Montar Pedido</h2>
<p>Escolhe os trem aí, uai:</p>

<form action="processa_pedido.php" method="post">

<?php while($p = mysqli_fetch_assoc($produtos)): ?>
    <div class="produto">
        <strong><?= $p['nome_produto'] ?></strong><br>
        Preço: R$ <?= number_format($p['preco_atual'], 2, ',', '.') ?><br><br>

        Quantidade: 
        <input type="number" name="produto[<?= $p['idProduto'] ?>]" min="0" value="0">
        Observações : 
        <input type="text" name="observacoes" placeholder="Faça suas observações">

        
    </div>
<?php endwhile; ?>

<button type="submit">Enviar Pedido</button>

</form>

</body>
</html>
