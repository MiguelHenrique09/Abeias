<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <title>Gerenciar Produtos — Abeias Burguer</title>

  <style>
    :root {
      --bg:#06092a;
      --primary:#E06A24;
      --primary-hover:#ff7f3a;
      --text:#ffffff;
      --card:rgba(255,255,255,0.07);
    }
    *{margin:0;padding:0;box-sizing:border-box;}
    body{background:var(--bg);color:var(--text);font-family:Arial,sans-serif;padding:40px 20px;min-height:100vh;display:flex;justify-content:center;}
    .container{width:100%;max-width:900px;}
    .back-btn{display:inline-block;margin-bottom:25px;padding:12px 18px;background:var(--primary);color:var(--bg);border-radius:10px;text-decoration:none;font-weight:bold;transition:.2s;}
    .back-btn:hover{background:var(--primary-hover);transform:translateY(-2px);}
    h1{margin-bottom:25px;font-size:34px;text-align:center;}
    table{width:100%;border-collapse:collapse;margin-top:10px;}
    th, td{padding:12px;border-bottom:1px solid rgba(255,255,255,0.1);}
    th{background:rgba(255,255,255,0.1);text-align:left;}
    .btn{background:var(--primary);color:var(--bg);padding:12px 18px;border:none;border-radius:8px;cursor:pointer;font-weight:bold;transition:.2s;}
    .btn:hover{background:var(--primary-hover);transform:translateY(-2px);}
    /* MODAL */
    .modal-bg{position:fixed;inset:0;background:rgba(0,0,0,0.7);display:none;justify-content:center;align-items:center;z-index:200;}
    .modal-box{background:#fff;color:#000;padding:30px;border-radius:12px;max-width:400px;text-align:center;}
    .modal-buttons{margin-top:20px;display:flex;justify-content:space-between;}
    .modal-btn{padding:10px 18px;border:none;border-radius:8px;cursor:pointer;font-weight:bold;}
    .sim{background:#d9534f;color:#fff;}
    .nao{background:#ccc;}
  </style>
</head>

<body>
<div class="container">
  <a class="back-btn" href="../admin.php">Voltar</a>
  <h1>Gerenciar Produtos</h1>

  <button class="btn" onclick="window.location='insereProduto.php'">Inserir Produtos</button>

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
      $sql = "SELECT nome_produto, preco_atual, descricao, idProduto FROM produto";
      $resultado = mysqli_query($conexao, $sql);

      if ($resultado && mysqli_num_rows($resultado) > 0) {
        while ($linha = mysqli_fetch_assoc($resultado)) {
          $nome = $linha['nome_produto'];
          $preco = number_format($linha['preco_atual'],2,',','.');
          $desc = $linha['descricao'];
          $id = $linha['idProduto'];
          echo "<tr>
                  <td>$nome</td>
                  <td>R$ $preco</td>
                  <td>$desc</td>
                  <td><button class='btn' onclick=\"abrirModalEdicao('$id','$preco','$desc')\">Editar</button></td>
                  <td><button class='btn' onclick=\"abrirModalExcluir('$id','$nome')\">Excluir</button></td>
                </tr>";
        }
      } else {
        echo "<tr><td colspan='5'>Nenhum produto cadastrado.</td></tr>";
      }
      mysqli_close($conexao);
    ?>
    </tbody>
  </table>

  <!-- MODAL EXCLUIR -->
  <div class="modal-bg" id="modalExcluir">
    <div class="modal-box">
      <h2>Tem certeza?</h2>
      <p>Deseja excluir o produto <strong id="nomeExcluir"></strong>?</p>
      <form method="POST" class="modal-buttons">
        <input type="hidden" name="idProdutoExcluir" id="idProdutoExcluir">
        <button type="submit" name="excluir" class="modal-btn sim">Excluir</button>
        <button type="button" class="modal-btn nao" onclick="fecharModalExcluir()">Cancelar</button>
      </form>
    </div>
  </div>

  <!-- MODAL EDITAR -->
  <div class="modal-bg" id="modalEditar">
    <div class="modal-box">
      <h2>Editando o produto</h2>
      <form method="POST">
        <input type="hidden" name="idProdutoEditar" id="idProdutoEditar">
        <div><input type="text" name="novoPreco" id="novoPreco" placeholder="Digite o novo preço" required></div><br>
        <div><input type="text" name="novaDesc" id="novaDesc" placeholder="Digite a nova descrição" required></div><br>
        <button type="submit" name="editar" class="btn">Salvar</button>
        <button type="button" class="btn" onclick="fecharModalEditar()">Cancelar</button>
      </form>
    </div>
  </div>

<?php
include __DIR__ . '/../bd/conecta.php';

// EXCLUSÃO SEGURA
if(isset($_POST['excluir'])){
    $id = (int)$_POST['idProdutoExcluir'];

    $check = mysqli_query($conexao,"SELECT COUNT(*) AS qtd FROM produto_pedido WHERE produto_idProduto = $id");
    $qtd = mysqli_fetch_assoc($check)['qtd'];

    if($qtd>0){
        echo "<script>alert('Este produto não pode ser excluído, pois já possui pedidos.'); window.location.href='gerenciaProdutos.php';</script>";
        exit;
    }

    $del = mysqli_query($conexao,"DELETE FROM produto WHERE idProduto = $id");
    if($del){
        echo "<script>alert('Produto excluído com sucesso!'); window.location.href='gerenciaProdutos.php';</script>";
    }else{
        echo "<script>alert('Erro ao excluir produto!');</script>";
    }
}

// EDIÇÃO SEGURA
if(isset($_POST['editar'])){
    $id = (int)$_POST['idProdutoEditar'];
    $preco = (float)str_replace(',','.',$_POST['novoPreco']);
    $desc = mysqli_real_escape_string($conexao,$_POST['novaDesc']);

    $upd = mysqli_query($conexao,"UPDATE produto SET preco_atual = $preco, descricao = '$desc' WHERE idProduto = $id");
    if($upd){
        echo "<script>alert('Produto editado com sucesso!'); window.location.href='gerenciaProdutos.php';</script>";
    }else{
        echo "<script>alert('Erro ao editar produto!');</script>";
    }
}

mysqli_close($conexao);
?>

<script>
function abrirModalExcluir(id,nome){
    document.getElementById('idProdutoExcluir').value = id;
    document.getElementById('nomeExcluir').innerText = nome;
    document.getElementById('modalExcluir').style.display = 'flex';
}
function fecharModalExcluir(){
    document.getElementById('modalExcluir').style.display = 'none';
}
function abrirModalEdicao(id,preco,desc){
    document.getElementById('idProdutoEditar').value = id;
    document.getElementById('novoPreco').value = preco;
    document.getElementById('novaDesc').value = desc;
    document.getElementById('modalEditar').style.display = 'flex';
}
function fecharModalEditar(){
    document.getElementById('modalEditar').style.display = 'none';
}
</script>
</div>
</body>
</html>
