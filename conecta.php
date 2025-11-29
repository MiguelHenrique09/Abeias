<?php
    $servidor   = "localhost";
    $usuario    = "root";
    $senha_bd      = "root";
    $nome_bd    = "cardapiovirtual";

    //cria a conexão
    $conexao = mysqli_connect($servidor, $usuario, $senha_bd, $nome_bd);

    //verifica a conexão
    if (!$conexao) {
        die("Conexão falhou: " . mysqli_connect_error());
    }
?>
