<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <title>Gerenciar Produtos — Abeias Burguer</title>

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

  <h1>Gerenciar Produtos</h1>

  <!-- ABAS -->
  <div class="tabs">
    
<button class="btn" onclick="window.location='insereProduto.php'">Inserir Produtos</button>    

</div>  

<div class="container">


  <h1>Lista de Produtos</h1>

  <table>
    <thead>
      <tr>
        <th>Produto</th>
        <th>Preço</th>
        <th>Descrição</th>
        <th></th>
        <th></th>
      </tr>
    </thead>

    <tbody>

      <?php
        include __DIR__ . '/../bd/conecta.php';

        $sql = "SELECT nome_produto, preco_atual, descricao FROM produto";
        $resultado = mysqli_query($conexao, $sql);

        if ($resultado && mysqli_num_rows($resultado) > 0) {

          while ($linha = mysqli_fetch_assoc($resultado)) {
            $nome = $linha['nome_produto'];

            echo "<tr>";
              echo "<td>$nome</td>";
              echo "<td>R$ " . number_format($linha['preco_atual'], 2, ',', '.') . "</td>";
              echo "<td>" . $linha['descricao'] . "</td>";

              // Botão editar
              echo "<td><button class='btn' name='Editar' onclick=\"abrirModalEdicao('$nome')\">Editar</button></td>";

              // Botão excluir
              echo "<td><button class='btn' name='Excluir' onclick=\"abrirModal('$nome')\">Excluir</button></td>";
            echo "</tr>";
          }

        } else {
          echo "<tr><td colspan='5'>Nenhum produto cadastrado.</td></tr>";
        }

        mysqli_close($conexao);
      ?>

    </tbody>
  </table>

</div>

<!-- ========= MODAL EXCLUSÃO DE PRODUTO ========= -->
<div class="modal-bg" id="modalBg">
  <div class="modal-box">
    <h2>Tem certeza?</h2>
    <p>Deseja excluir o produto <strong id="produtoNome"></strong>?</p>

    <form method="POST" class="modal-buttons">
      <input type="hidden" name="produto" id="produtoInput">

      <button type="submit" name="excluir" class="modal-btn sim">Excluir</button>
      <button type="button" class="modal-btn nao" onclick="fecharModal()">Cancelar</button>
    </form>
  </div>
</div>

<!-- ========= MODAL EDITAR PRODUTO ========= -->
<div class="modal-bg" id="modalBgE">
  <div class="modal-box">
    <h4>Editando o produto <strong id="produtoNomeE"></strong></h4><br>

    <div class="container">
      <form method="POST">
        <input type="hidden" name="nomeAntigo" id="nomeAntigo">
        <div><input type="text" name="novoNome" placeholder="Digite o novo nome" required></div><br>
        <div><input id="precoProduto" type="text" name="novoPreco" placeholder="Digite o novo preço" required></div><br>
        <div><input id="descricaoProduto" name="novaDesc" type="text" placeholder="Digite a nova descrição" required></div><br>
        <div>
      <button type="submit" name="editar" class="back-btn">Editar</button>
      <button type="button" class="modal-btn sim" onclick="fecharModalE()">Cancelar</button>
    </div>
      </form>
    </div>

  </div>
</div>



<?php
// ===== PROCESSANDO A EXCLUSÃO =====
if (isset($_POST["excluir"])) {

        include __DIR__ . '/../bd/conecta.php';
  $nome = $_POST["produto"];

  $sql = "DELETE FROM produto WHERE nome_produto = '$nome'";

  if (mysqli_query($conexao, $sql)) {
    echo "<script>alert('Produto excluído com sucesso!'); window.location.href='gerenciaProdutos.php';</script>";
  } else {
    echo "<script>alert('Erro ao excluir!');</script>";
  }

  mysqli_close($conexao);
}
?>

<?php
// ===== PROCESSANDO A EDIÇÃO =====
if (isset($_POST["editar"])) {

        include __DIR__ . '/../bd/conecta.php';
 $msg =" ";
  $nomeAntigo   = $_POST['nomeAntigo'];
  $nomeProduto  = $_POST['novoNome'] ?? '';
  $preco  = ($_POST['novoPreco'] ?? 0);
  $preco = str_replace(',', '.', $preco);   
  $preco = (float)$preco;    
  $desc = $_POST['novaDesc'] ?? '';

  if (
    isset($nomeProduto) &&
     isset($desc)&&
    isset($nomeAntigo) &&
     isset($preco)&&
    is_numeric($preco)
  ) {

$nomeEscapado = mysqli_real_escape_string($conexao, $nomeProduto);

$checkSql = "SELECT nome_produto FROM produto 
             WHERE nome_produto = '$nomeEscapado' 
             AND nome_produto != '$nomeAntigo' 
             LIMIT 1";

$checkResult = mysqli_query($conexao, $checkSql);

if (mysqli_num_rows($checkResult) > 0) {
    echo "<script>alert('Este nome já existe!');</script>";
} else {

    $sql = "UPDATE produto
            SET nome_produto='$nomeProduto',
                descricao='$desc',
                preco_atual='$preco'
            WHERE nome_produto ='$nomeAntigo'";

    if (mysqli_query($conexao, $sql)) {

        echo "<script>
                alert('Produto editado com sucesso!');
                window.location.href = 'gerenciaProdutos.php';
              </script>";
        exit;

    } else {
        echo "<script>alert('Erro ao editar o produto!');</script>";
    }
}}
  else {
    echo "Dados inválidos";
  }
echo $msg;

  mysqli_close($conexao);
}
?>
<script>
  function abrirModal(nome) {
    document.getElementById("produtoNome").innerText = nome;
    document.getElementById("produtoInput").value = nome;
    document.getElementById("modalBg").style.display = "flex";
  }

  function fecharModal(){
    document.getElementById("modalBg").style.display = "none";
  }

  function abrirModalEdicao(nome) {
    document.getElementById("produtoNomeE").innerText = nome;
    document.getElementById("nomeAntigo").value = nome;
    document.getElementById("modalBgE").style.display = "flex";
}


  function fecharModalE(){
    document.getElementById("modalBgE").style.display = "none";
  }
</script>

  </div>
 </div>
  
</body>
</html>
