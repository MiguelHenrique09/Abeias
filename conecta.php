<?php
    $servidor   = "localhost:3306";
    $usuario    = "root";
    $senha      = "Mhs2009.";
    $nome_bd    = "cardapiovirtual";

    //cria a conexão
    $conexao = mysqli_connect($servidor, $usuario, $senha, $nome_bd);

    //verifica a conexão
    if (!$conexao) {
    die("Conexão falhou: " . mysqli_connect_error());
    }
   // echo "Conectado!"; //debug
?>