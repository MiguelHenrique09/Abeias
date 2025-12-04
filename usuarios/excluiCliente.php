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
<div class="modal-bg">
  <div class="modal-box">
    <h2>Tem certeza?</h2>
    <p>Deseja excluir o Cliente <strong id="clienteNome"></strong>?</p>

    <div class="modal-buttons">
      <form method="post" >
        <button class="modal-btn sim" type="submit" name = "excluir">Excluir</button>
      </form>
       <button class="modal-btn nao" onclick="document.querySelector('.modal-bg').style.display='none'">
        Cancelar
      </button>
    </div>
  </div>
</div>
<?php
include '../bd/conecta.php';
if(isset($_POST["excluir"])){
$nome = $_POST["cliente"];

$sql = "DELETE FROM cliente WHERE nome_cliente = '$nome'";

if(mysqli_query($conexao, $sql)){
    echo "Cliente excluído com sucesso!";
} else {
    echo "Erro ao excluir.";
}
}
mysqli_close($conexao);
?>



</div>
</body>
</html>
