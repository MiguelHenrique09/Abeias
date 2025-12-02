<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <title>Admin — Abeias Burguer</title>

  <style>
    :root {
      --bg:#06092a;
      --primary:#E06A24;
      --primary-hover:#ff7f3a;
      --text:#ffffff;
    }

    * {
      margin:0;
      padding:0;
      box-sizing:border-box;
    }

    body {
      font-family:Arial, sans-serif;
      background:var(--bg);
      color:var(--text);
      height:100vh;
      width:100vw;
      display:flex;
      flex-direction:column;
      justify-content:center;
      align-items:center;
      overflow:hidden;
    }

    h1 {
      font-size:38px;
      font-weight:700;
      margin-bottom:40px;
      text-transform:uppercase;
      letter-spacing:2px;
    }

    .buttons {
      display:flex;
      flex-direction:column;
      gap:25px;
      width:100%;
      max-width:500px;
      padding:0 20px;
    }

    .btn-link {
      display:flex;
      justify-content:center;
      align-items:center;
      background:var(--primary);
      padding:20px;
      border-radius:14px;
      color:var(--bg);
      text-decoration:none;
      font-size:22px;
      font-weight:bold;
      width:100%;
      transition:.2s;
      box-shadow:0 6px 20px rgba(0,0,0,0.4);
    }

    .btn-link:hover {
      background:var(--primary-hover);
      transform:translateY(-4px);
    }

    .btn-link:active {
      transform:scale(.97);
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
    .modal-bg{
  position:fixed;
  top:0;
  left:0;
  width:100%;
  height:100%;
  background:rgba(0,0,0,0.75);
  display:none;
  justify-content:center;
  align-items:center;
  z-index:9999;
}

.modal-box{
  background:#fff;
  color:#000;
  border-radius:14px;
  padding:30px;
  width:90%;
  max-width:420px;
  text-align:center;
  box-shadow:0 0 20px rgba(0,0,0,0.4);
}

.modal-buttons{
  margin-top:25px;
  display:flex;
  justify-content:center;
  gap:15px;
}

.modal-btn{
  padding:10px 18px;
  border:none;
  border-radius:10px;
  font-weight:bold;
  cursor:pointer;
  transition:.2s;
}

.modal-btn.sim{
  background:var(--primary);
  color:#fff;
}

.modal-btn.sim:hover{
  background:var(--primary-hover);
}

.modal-btn.nao{
  background:#ccc;
}

.modal-btn.nao:hover{
  background:#bbb;
}

  </style>

</head>

<body>
<div class="container">
  <h1>Painel Administrativo</h1>
<a class="back-btn" href="#" id="openExitModal">Voltar</a>
</div>
  <div class="buttons">
    
   

    <a href="pedidos.php" class="btn-link">
      Gerenciar Pedidos
  </a>
    <a href="produtos/gerenciaProdutos.php" class="btn-link">
      Gerenciar Produtos
    </a>
  </div>

<!-- Modal de confirmação -->
<div class="modal-bg" id="exitModal">
  <div class="modal-box">
    <h2>Tem certeza que deseja sair da aba administrativa?</h2>
   

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

  openModal.addEventListener('click', () => {
    modal.style.display = 'flex';
  });

  cancel.addEventListener('click', () => {
    modal.style.display = 'none';
  });

  confirmExit.addEventListener('click', () => {
    window.location.href = "login.php";
  });
</script>

</body>
</html>
