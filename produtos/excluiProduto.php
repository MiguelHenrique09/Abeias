<?php
include "../bd/conecta.php";

$idProduto = (int)($_POST['idProdutoExcluir'] ?? 0);

if($idProduto > 0){
    // Inativa o produto
    $sqlUpdate = "UPDATE produto SET ativo = 0 WHERE idProduto = $idProduto";
    
    if(mysqli_query($conexao, $sqlUpdate)){
        echo "<script>
            alert('Produto inativado com sucesso!');
            window.location.href='gerenciaProdutos.php';
        </script>";
    } else {
        echo "<script>
            alert('Erro ao inativar o produto!');
            window.location.href='gerenciaProdutos.php';
        </script>";
    }

} else {
    echo "<script>
        alert('Produto inválido!');
        window.location.href='gerenciaProdutos.php';
    </script>";
}

mysqli_close($conexao);
?>
