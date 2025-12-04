<?php
include("../bd/conecta.php");

$id = $_POST["idPedido"];
$status = $_POST["statusPedido"];

$sql = "UPDATE pedido SET statusPedido = '$status' WHERE idPedido = $id";

mysqli_query($conexao, $sql);

header("Location: gerenciaStatus.php");
exit;
?>