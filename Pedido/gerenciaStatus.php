<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <title>Gerenciar Pedidos — Abeias Burguer</title>

  <style>
 
    :root {
      --bg:#06092a;
      --primary:#E06A24;
      --primary-hover:#ff7f3a;
      --text:#ffffff;
      --card:rgba(255,255,255,0.07);
    }

    *{
      margin:0; padding:0; box-sizing:border-box;
    }

    body{
      background: linear-gradient(135deg, #4c5483ff, #080d2b);
      background:var(--bg);
      color:var(--text);
      font-family:Arial, sans-serif;
      padding:40px 20px;
      min-height:100vh;
      display:flex;
      justify-content:center;
    }

    .container{
      width:100%;
      max-width:900px;
    }

    /* Botão voltar */
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
    .back-btn:hover{
      background:var(--primary-hover);
      transform:translateY(-2px);
    }

    h1{
      margin-bottom:25px;
      font-size:34px;
      text-align:center;
    }

  /* ABAS */
.tabs{
  display:flex;
  flex-direction:column;
  gap:12px;
  margin-bottom:20px;
}

.tabs .btn{
  width:100%;
  padding:18px;
  font-size:18px;
  background:var(--primary);
  border:none;
  border-radius:10px;
  cursor:pointer;
  color:var(--bg);
  font-weight:bold;
  text-align:center;
  transition:.2s;
  display:block;
}

.tabs .btn:hover{
  background:var(--primary-hover);
  transform:translateY(-3px);
}

    /* PAINÉIS */
    .panel{
      display:none;
      background:var(--card);
      padding:25px;
      border-radius:12px;
      box-shadow:0 6px 20px rgba(0,0,0,0.4);
    }

    .panel.active{
      display:block;
    }

    /* FORMULÁRIO */
    .form-row{
      display:flex;
      flex-wrap:wrap;
      gap:12px;
      margin-bottom:20px;
    }
    .form-row input{
      flex:1;
      padding:12px;
      border:none;
      border-radius:8px;
    }

    .btn{
      background:var(--primary);
      color:var(--bg);
      padding:12px 18px;
      border:none;
      border-radius:8px;
      cursor:pointer;
      font-weight:bold;
      transition:.2s;
    }
    .btn:hover{
      background:var(--primary-hover);
      transform:translateY(-2px);
    }

    /* TABELA */
    table{
      width:100%;
      border-collapse:collapse;
      margin-top:10px;
    }

    th, td{
      padding:12px;
      border-bottom:1px solid rgba(255,255,255,0.1);
    }

    th{
      background:rgba(255,255,255,0.1);
      text-align:left;
    }
      .modal-bg{
      position:fixed;
      inset:0;
      background:rgba(0,0,0,0.7);
      display:none;
      justify-content:center;
      align-items:center;
      z-index:200;
    }

  </style>
</head>

<body>

<div class="container">

  <a class="back-btn" href="../admin.php"> Voltar</a>

  <h1>Gerenciar Pedidos</h1>


  
  <!-- ABAS -->
  <div class="tabs">
    

</div>  

<div class="container">


  <h1>Lista de Pedidos</h1>

  <table>
    <thead>
      <tr>
       
        <th>ID do pedido</th>
        <th>Data e Hora que foi pedido</th>
        <th> Feito por </th>
       <th>Total  </th>
       <th>Produtos  </th>

        <th>Status do pedido </th>
       
      </tr>
    </thead>

    <tbody>

     <?php
include __DIR__ . '/../bd/conecta.php';

$sql = "SELECT 
    idPedido,
    data_hora_pedido,
    statusPedido,
    valor_total,
    username,
    GROUP_CONCAT(CONCAT( quantidade, '  '),nome_produto ) AS produtos
FROM pedido
JOIN produto_pedido ON pedido_idPedido =idPedido
JOIN produto ON idProduto = produto_idProduto
JOIN cliente ON idCliente = id_cliente
GROUP BY idPedido;";

$resultado = mysqli_query($conexao, $sql);

if ($resultado && mysqli_num_rows($resultado) > 0) {

    while ($linha = mysqli_fetch_assoc($resultado)) {

       echo "<tr>";
        echo "<td>" . $linha['idPedido'] . "</td>";
        echo "<td>" . $linha['data_hora_pedido'] . "</td>";
        echo "<td>" . $linha['username'] . "</td>"; 
        echo "<td>R$ " . number_format($linha['valor_total'], 2, ',', '.') . "</td>"; 
        echo "<td>" . $linha['produtos'] . "</td>"; 
         echo "<td>" . $linha['statusPedido'] . " 
              <button class='btn' style='margin-left:70px' name='EditarStatus' 
              onclick=\"abrirModalStatus('{$linha['statusPedido']}', '{$linha['idPedido']}')\">Editar Status</button>
              </td>";
              echo "</tr>"; 
    }

} else {
    echo "<tr><td colspan='5'>Nenhum pedido cadastrado.</td></tr>";
}

mysqli_close($conexao);
?>


    </tbody>
  </table>
<div class="modal-bg" id="modalBg">
  <div class="modal-box" style="background:#fff; padding:25px; border-radius:10px; width:350px; color:#000;">
    
    <h2>Editar Status</h2>

    <form method="POST" action="atualizaStatus.php">
      <input type="hidden" name="idPedido" id="inputIdPedido">

      <label>Novo Status:</label>
      <select name="statusPedido" id="inputStatus" style="width:100%; padding:10px; margin-top:10px;">
        <option value="preparando">Preparando</option>
        <option value="pronto">Pronto</option>
      </select>

      <button type="submit" class="btn" style="margin-top:15px;">Salvar</button>
      <button type="button" class="btn" onclick="fecharModal()" style="margin-top:15px; background:#777;">Cancelar</button>
    </form>

  </div>
</div>


</div>


<script>





function abrirModalStatus(status, idPedido) {
  document.getElementById("inputStatus").value = status;
  document.getElementById("inputIdPedido").value = idPedido;
  document.getElementById("modalBg").style.display = "flex";
}

function fecharModal() {
  document.getElementById("modalBg").style.display = "none";
}

  </script>
</body>
</html>
