<?php
session_start();
include("../bd/conecta.php");



$idCliente = $_SESSION["usuario_id"];

// busca produtos
$sql = "SELECT * FROM produto";
$produtos = mysqli_query($conexao, $sql);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Fazer Pedido</title>
    <style>
        :root {
  --bg:#06092a;
  --primary:#E06A24;
  --primary-hover:#ff7f3a;
  --text:#ffffff;
  --card:rgba(255,255,255,0.07);
}

        /* ======== ESTILO GERAL ======== */
        body {
            font-family: Arial, sans-serif;
            background-color: #0b0e27;
            /* Fundo escuro igual na imagem */
            color: #ffffff;
            padding: 20px;
            text-align: center;
            justify-content :center;
            display :flex;
        }

        /* Títulos */
        h2 {
            font-size: 32px;
            margin-bottom: 20px;
            font-weight: bold;
        }

        /* ======== CAIXA DE PRODUTO ======== */
        .produto {
            background-color: #161a33;
            border: 1px solid #252b50;
            padding: 20px;
            border-radius: 10px;
            width: 60%;
            margin: 20px auto;
            text-align: left;
        }

        .produto strong {
            font-size: 20px;
            color: #ffffff;
        }

        /* Input de quantidade */
        input[type="number"] {
            padding: 6px;
            width: 80px;
            border-radius: 5px;
            border: none;
            outline: none;
            background-color: #0d112b;
            color: #ffffff;
            font-size: 14px;
        }

        /* ======== INPUT OBSERVAÇÕES ======== */
        input[type="text"] {
            width: 60%;
            padding: 10px;
            margin-top: 20px;
            border-radius: 8px;
            border: none;
            background-color: #161a33;
            color: white;
        }

        /* Placeholder */
        input::placeholder {
            color: #cccccc;
        }

        /* ======== BOTÃO ENVIAR ======== */
        button {
            margin-top: 25px;
            background-color: #d66b23;
            border: none;
            padding: 12px 30px;
            border-radius: 10px;
            color: white;
            cursor: pointer;
            font-size: 18px;
            transition: 0.2s;
        }

        button:hover {
            background-color: #b8581d;
        }

        /* ======== TABELA (CASO QUEIRA USAR DEPOIS) ======== */
        table {
            width: 80%;
            margin: 0 auto;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 12px;
            border-bottom: 1px solid #2c325c;
        }

        th {
            background-color: #1c2140;
            color: white;
        }

        td {
            background-color: #161a33;
        }

        /* ======== BOTÕES DA TABELA ======== */
        .btn {
            padding: 8px 18px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
        }

        .btn-editar {
            background-color: #d66b23;
            color: white;
        }

        .btn-excluir {
            background-color: #b8382b;
            color: white;
        }

        .btn-editar:hover {
            background-color: #b8581d;
        }

        .btn-excluir:hover {
            background-color: #922a22;
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
     font-size:14px; margin-top:20px;
    }
      .container{
      width:100%;
      max-width:900px;

    }
    .back-btn2{
  margin-right :700px;
    padding: 8px 16px;
    background:#E06A24;
    color:#10183e;
    font-weight:bold;
    border-radius:8px;
    text-decoration:none;
    transition:0.3s;
    box-shadow:0 3px 8px rgba(0,0,0,0.25);
}

/* ===== MODAL ===== */
.modal-bg {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.7);
    justify-content: center;
    align-items: center;
    z-index: 999;
}

.modal-box {
    background-color: #161a33;
    padding: 30px;
    border-radius: 12px;
    width: 90%;
    max-width: 400px;
    text-align: center;
    box-shadow: 0 0 10px #00000088;
}

.modal-box h2 {
    font-size: 18px;
    margin-bottom: 20px;
}

.modal-buttons {
    display: flex;
    justify-content: space-between;
    gap: 20px;
}

.modal-btn {
    flex: 1;
    padding: 10px;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    font-weight: bold;
    transition: 0.2s;
}

.modal-btn.sim {
    background-color: #E06A24;
    color: #fff;
}

.modal-btn.sim:hover {
    background-color: #b8581d;
}

.modal-btn.nao {
    background-color: #444b7a;
    color: white;
}

.modal-btn.nao:hover {
    background-color: #30365d;
}

   </style>
</head>

<body>  


      <div class ='container'>
<a id="openExitModal" class="back-btn2" href="#">Voltar</a>
<h2>Montar Pedido</h2>

<a class="back-btn" href="pedidoFeito.php" >
    Acompanhar Pedidos
</a>

    <form action="processa_pedido.php" method="post">

        <?php while ($p = mysqli_fetch_assoc($produtos)): ?>
            <div class="produto">
                <strong><?= $p['nome_produto'] ?></strong><br>
                Preço: R$ <?= number_format($p['preco_atual'], 2, ',', '.') ?><br><br>

                Quantidade:
                <input type="number" name="produto[<?= $p['idProduto'] ?>]" min="0" value="0">



            </div>
        <?php endwhile; ?>

        Observações :
        <input type="text" name="observacoes" placeholder="Faça suas observações">

        <button type="submit">Enviar Pedido</button>

    </form>
</div>
<!-- Modal de confirmação -->
<div class="modal-bg" id="exitModal">
  <div class="modal-box">
    <h2>Tem certeza que deseja sair?</h2>

    <div class="modal-buttons">
      <button class="modal-btn sim" id="confirmExit">Sim, sair</button>
      <button class="modal-btn nao" id="cancelExit">Cancelar</button>
    </div>
  </div>
</div>
<script>
const openModal = document.getElementById('openExitModal');
const modal = document.getElementById('exitModal');
const cancel = document.getElementById('cancelExit');
const confirmExit = document.getElementById('confirmExit');

openModal.addEventListener('click', (e) => {
    e.preventDefault(); // impedir que o link funcione antes do modal
    modal.style.display = 'flex';
});

cancel.addEventListener('click', () => {
    modal.style.display = 'none';
});

confirmExit.addEventListener('click', () => {
    window.location.href = "../index.html"; // caminho correto
});


</script>
</body>

</html>