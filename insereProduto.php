


<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Admin — Abeias Burguer</title>


  <style>
    :root {
      --primary:#E06A24;
      --bg:#06092a;
      --muted:#f0f0f0;
      --card:rgba(255,255,255,0.05);
    }

    body {
      margin:0;
      font-family:Arial, sans-serif;
      background:var(--bg);
      color:var(--muted);
      padding:15px;
    }

    .container {
      max-width:900px;
      margin:auto;
    }

    /* ================= HEADER ================= */
    header {
      margin-bottom:20px;
    }

    .brand {
      display:flex;
      align-items:center;
      gap:12px;
    }

    .logo {
      width:50px;
      height:50px;
      background:var(--primary);
      border-radius:10px;
      display:flex;
      align-items:center;
      justify-content:center;
      font-weight:bold;
      color:var(--bg);
      font-size:20px;
    }

    /* ================= MENU DE ABAS ================= */
    .tabs {
      display:flex;
      gap:10px;
      margin-bottom:20px;
      flex-wrap:wrap;
    }

    .tab-btn {
      background:transparent;
      border:1px solid rgba(255,255,255,0.3);
      padding:10px 18px;
      border-radius:8px;
      color:var(--muted);
      cursor:pointer;
    }

    .tab-btn.active {
      background:var(--primary);
      color:var(--bg);
      font-weight:bold;
      border:0;
    }

    /* ================= PAINÉIS ================= */
    .panel {
      display:none;
      background:var(--card);
      padding:20px;
      border-radius:10px;
    }

    .panel.active {
      display:block;
    }

    /* ================= FORMULÁRIOS ================= */
    .form-row {
      display:flex;
      gap:10px;
      margin-bottom:15px;
      flex-wrap:wrap;
    }

    .form-row input {
      padding:10px;
      border:none;
      border-radius:6px;
      flex:1;
      min-width:180px;
    }

    .btn {
      background:var(--primary);
      border:none;
      color:var(--bg);
      padding:10px 18px;
      border-radius:8px;
      cursor:pointer;
      font-weight:bold;
    }

    .btn:active {
      transform:scale(0.95);
    }

    /* ================= TABELAS ================= */
    .table-box {
      overflow-x:auto;
      margin-top:10px;
    }

    table {
      width:100%;
      border-collapse:collapse;
      min-width:450px;
    }

    th, td {
      padding:12px;
      border-bottom:1px solid rgba(255,255,255,0.1);
    }

    /* ================= RESPONSIVIDADE EXTRA ================= */
    @media (max-width:600px) {
      h1 { font-size:20px; }
      table { font-size:14px; }
      .btn { width:100%; }
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




  </style>

</head>

<body>

<div class="container">

<a class="back-btn" href="gerenciaProdutos.php">Voltar</a>


 
  <!-- ================= PAINEL PRODUTOS ================= -->
    <h2>Produtos</h2>

    <form class="form-row" method="post">
      <input id="nomeProduto" name="nomeProduto" placeholder="Produto" required>
      <input id="precoProduto" type="text" name="precoProduto" placeholder="Preço" step="0.01" required> 
       <input id="descricaoProduto" name="descricaoProduto" type="text" placeholder="Descrição" required>
       
      <button class="btn" name = "inseri"">Adicionar</button>
  </form>

    <div class="table-box">
      <table>
        <thead>
          <tr>
            <th>Produto</th>
            <th>Preço</th>
            <th>Descrição</th>
          </tr>
        </thead>
      </table>
    </div>

</div>

<!-- ================= JS ================= -->
<script>
  // Troca abas
  const tabButtons = document.querySelectorAll('.tab-btn');
  const preco = document.querySelectorAll('#precoProduto').value;
  const panels = document.querySelectorAll('.panel');


  tabButtons.forEach(btn => {
    btn.addEventListener("click", () => {
      tabButtons.forEach(b => b.classList.remove("active"));
      panels.forEach(p => p.classList.remove("active"));

      btn.classList.add("active");
      document.getElementById(btn.dataset.tab).classList.add("active");
    });
  });
  

</script>

</body>
</html>
<?php
include 'conecta.php';

if(isset($_POST["inseri"])){

    $nomeProduto = $_POST['nomeProduto'] ?? '';
    $preco = (float)($_POST['precoProduto'] ?? 0);
    $desc = $_POST['descricaoProduto'] ?? '';

    if(
        isset($nomeProduto) && 
        isset($preco) && 
        !empty(trim($_POST['nomeProduto'])) &&
         is_numeric($preco)
    ){


        $nomeEscapado = mysqli_real_escape_string($conexao, $nomeProduto);
        $checkSql = "SELECT nome_produto FROM produto WHERE nome_produto = '$nomeEscapado' LIMIT 1";
        $checkResult = mysqli_query($conexao, $checkSql);

        if(mysqli_num_rows($checkResult) > 0){
            echo "Esse produto já existe!";
        } else {
            // insert no bd
            $sql = "INSERT INTO produto (nome_produto, descricao, preco_atual)
                    VALUES ('$nomeEscapado', '$desc', '$preco')";

            if(mysqli_query($conexao, $sql)){
                echo "Novo produto criado com sucesso!";
            } else {
                echo "Erro ao inserir!";
            }
        }

    } else {
        echo "Erro: dados inválidos.";
    }

}

mysqli_close($conexao);
?>
