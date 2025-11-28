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
  </style>

</head>

<body>
<div class="container">
  <h1>Painel Administrativo</h1>
   <a class="back-btn" href="login.php">Voltar</a>
</div>
  <div class="buttons">
    
   

    <a href="gerenciaProdutos.php" class="btn-link">
      Gerenciar Pedidos
  </a>
    <a href="gerenciaProdutos.php" class="btn-link">
      Gerenciar Produtos
    </a>
  </div>

</body>
</html>
