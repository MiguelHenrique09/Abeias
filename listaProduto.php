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

    h1 {
      font-size:38px;
      font-weight:700;
      margin-bottom:30px;
      text-transform:uppercase;
      letter-spacing:2px;
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

    .listar-btn {
      margin:20px 0;
      padding:12px 28px;
      background:var(--primary);
      color:var(--bg);
      border:none;
      border-radius:10px;
      font-size:20px;
      cursor:pointer;
      font-weight:bold;
      transition:.2s;
    }

    .listar-btn:hover {
      background:var(--primary-hover);
    }

    table {
      width:90%;
      max-width:900px;
      border-collapse:collapse;
      background:#fff;
      color:#000;
      border-radius:10px;
      overflow:hidden;
      margin-top:20px;
    }

    th, td {
      padding:15px;
      font-size:18px;
      text-align:left;
    }

    th {
      background:var(--primary);
      color:var(--bg);
      font-size:20px;
    }

    tr:nth-child(even) {
      background:#eee;
    }
  </style>

</head>

<body>
<div class="container">
<a class="back-btn" href="gerenciaProdutos.php">Voltar</a>

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
      include 'conecta.php';

   

          $sql = "SELECT nome_produto, preco_atual, descricao FROM produto";
          $resultado = mysqli_query($conexao, $sql);

          if ($resultado && mysqli_num_rows($resultado) > 0) {
              while ($linha = mysqli_fetch_assoc($resultado)) {
                  echo "<tr>";
                  echo "<td>" . $linha['nome_produto'] . "</td>";
                  echo "<td>R$ " . number_format($linha['preco_atual'], 2, ',', '.') . "</td>";
                  echo "<td>" . $linha['descricao'] . "</td>";
                  echo "<td>". "<button class='btn' type='submit'data-tab='listar' onclick=window.location='editaProduto.php'>Editar Produto</button>"."</td>";
                  echo "<td>". "<button class='btn' type='submit'data-tab='listar' onclick=window.location='excluiProduto.php'>Exclui Produto</button>"."</td>";

                  echo "</tr>";
              }
          } else {
              echo "<tr><td colspan='3'>Nenhum produto cadastrado.</td></tr>";
          }

          mysqli_close($conexao);
      
    ?>
  </tbody>
</table>
<div/>



</body>
</html>
