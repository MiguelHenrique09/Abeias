<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <title>Admin — Abeias Burguer</title>

  <style>
    .container{
      width:100%;
      max-width:900px;
    }
    :root {
      --bg:#06092a;
      --primary:#E06A24;
      --primary-hover:#ff7f3a;
      --text:#ffffff;
    }

    body {
      font-family:Arial, sans-serif;
      background:var(--bg);
      color:var(--text);
      display:flex;
      justify-content:center;
      align-items:center;
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

    input[type="text"]{
      padding:10px;
      width:300px;
      border-radius:8px;
      border:none;
      margin-right:8px;
    }

    .btn{
      padding:10px 18px;
      border:none;
      background:var(--primary);
      color:var(--bg);
      font-weight:bold;
      border-radius:8px;
      cursor:pointer;
    }

    .btn:hover{
      background:var(--primary-hover);
    }

    /* ===== MODAL ===== */
    .modal-bg{
      position:fixed;
      z-index:100;
      inset:0;
      background:rgba(0,0,0,0.6);
      display:flex;
      justify-content:center;
      align-items:center;
      display:none;
    }

    .modal-box{
      background:#fff;
      color:#000;
      padding:30px;
      border-radius:12px;
      max-width:400px;
      text-align:center;
    }

    .modal-buttons{
      margin-top:20px;
      display:flex;
      justify-content:space-around;
    }

    .modal-btn{
      padding:10px 18px;
      border:none;
      border-radius:8px;
      cursor:pointer;
      font-weight:bold;
    }

    .sim{
      background:#d9534f;
      color:#fff;
    }

    .nao{
      background:#ccc;
    }
  </style>

</head>

<body>
<div class="container">

<!-- ===== MODAL ===== -->
<div class="modal-bg" id="modalBg">
  <div class="modal-box">
    <h2>Tem certeza?</h2>
    <p>Deseja excluir o cliente <strong id="clienteNome"></strong>?</p>

    <div class="modal-buttons">
      <form method="post">
        <input type="hidden" id="clienteId" name="idCliente">

        <!-- ESTE É O BOTÃO CORRETO -->
        <button class="modal-btn sim" type="submit" name="excluir">
          Excluir
        </button>
      </form>

      <button class="modal-btn nao"
        onclick="document.querySelector('.modal-bg').style.display='none'">
        Cancelar
      </button>
    </div>
  </div>
</div>

</div>
<?php
include '../bd/conecta.php';

if(isset($_POST["excluir"])){

    $id = (int) $_POST["idCliente"];

    // Excluir itens dos pedidos do cliente
    $sqlPedidos = "SELECT idPedido FROM pedido WHERE id_cliente = $id";
    $resPedidos = mysqli_query($conexao, $sqlPedidos);

    while($p = mysqli_fetch_assoc($resPedidos)){
        $idPedido = $p["idPedido"];
        mysqli_query($conexao, "DELETE FROM produto_pedido WHERE pedido_idPedido = $idPedido");
    }

    // Excluir pedidos
    mysqli_query($conexao, "DELETE FROM pedido WHERE id_cliente = $id");

    // Excluir cliente
    if(mysqli_query($conexao, "DELETE FROM cliente WHERE idCliente = $id")){
        echo "<script>alert('Cliente excluído com sucesso!'); window.location.href='gerenciaCliente.php';</script>";
    } else {
        echo "<script>alert('Erro ao excluir cliente');</script>";
    }

    mysqli_close($conexao);
}

?>



</div>
<script>
function abrirModal(id, nome){
    document.querySelector(".modal-bg").style.display = "flex";
    document.getElementById("clienteNome").innerText = nome;
    document.getElementById("clienteId").value = id;
}
</script>

</body>
</html>
