<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <title>Gerenciar clientes — Abeias Burguer</title>

  <style>
     /* ===== MODAL ===== */
    .modal-bg{
      position:fixed;
      inset:0;
      background:rgba(0,0,0,0.7);
      display:none;
      justify-content:center;
      align-items:center;
      z-index:200;
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
      justify-content:space-between;
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

  </style>
</head>

<body>

<div class="container">

  <a class="back-btn" href="../admin.php"> Voltar</a>


  <!-- ABAS -->
  <div class="tabs">
    

</div>  

<div class="container">


  <h1>Lista de Clientes</h1>

  <table>
    <thead>
      <tr>
        <th>Nome do cliente</th>
        <th>Username </th>
      
        <th></th>
        <th></th>
        <th></th>
      </tr>
    </thead>

    <tbody>

     <?php
include __DIR__ . '/../bd/conecta.php';

$sql = "SELECT idCliente, nome_cliente, username FROM cliente";
$resultado = mysqli_query($conexao, $sql);

if ($resultado && mysqli_num_rows($resultado) > 0) {

  while ($linha = mysqli_fetch_assoc($resultado)) {
    $id = $linha['idCliente'];
    $nome = $linha['nome_cliente'];

    echo "<tr>";
      echo "<td>$nome</td>";
      echo "<td>" . $linha['username'] . "</td>";

      echo "<td>
            <button class='btn' onclick=\"abrirModal($id, '$nome')\">
    Excluir
</button>

            </td>";
    echo "</tr>";
  }

} else {
  echo "<tr><td colspan='5'>Nenhum cliente cadastrado.</td></tr>";
}

mysqli_close($conexao);
?>

    </tbody>
  </table>

</div>

<!-- ========= MODAL EXCLUSÃO DE cliente ========= -->
<div class="modal-bg" id="modalBg">
  <div class="modal-box">
    <h2>Tem certeza?</h2>
    <p>Deseja excluir o cliente <strong id="clienteNome"></strong>?</p>

    <form method="POST" class="modal-buttons">
<input type="hidden" name="idCliente" id="clienteId">

      <button type="submit" name='excluir' class="modal-btn sim">Excluir</button>
      <button type="button" class="modal-btn nao" onclick="fecharModal()">Cancelar</button>
    </form>
  </div>
</div>





 <?php
// ===== PROCESSANDO A EXCLUSÃO =====
if (isset($_POST["excluir"])) {

    include __DIR__ . '/../bd/conecta.php';
    
    $id = (int) $_POST['idCliente'];

    // Verifica se o cliente possui pedidos
    $sqlCheck = "SELECT 1 FROM pedido WHERE id_cliente = $id LIMIT 1";
    $res = mysqli_query($conexao, $sqlCheck);

    if ($res && mysqli_num_rows($res) > 0) {
        echo "<script>alert('Esse cliente possui pedidos e não pode ser excluído!');</script>";
        echo "<script>window.location.href='gerenciaCliente.php';</script>";
        exit;
    }

    // Pode excluir
    $sqlDelete = "DELETE FROM cliente WHERE idCliente = $id";

    if (mysqli_query($conexao, $sqlDelete)) {
        echo "<script>alert('Cliente excluído com sucesso!'); window.location.href='gerenciaCliente.php';</script>";
    } else {
        echo "<script>alert('Erro ao excluir!');</script>";
    }

    mysqli_close($conexao);
}
?>
<script>
function abrirModal(id, nome) {
    document.getElementById("clienteNome").innerText = nome;
    document.getElementById("clienteId").value = id;
    document.getElementById("modalBg").style.display = "flex";
}

function fecharModal(){
    document.getElementById("modalBg").style.display = "none";
}
</script>

  </div>
 </div>
  
</body>
</html>
