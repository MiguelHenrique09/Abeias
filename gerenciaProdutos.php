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
  flex-direction:column;   /* Coloca um botão em cada linha */
  gap:12px;
  margin-bottom:20px;
}

/* Botões estilo tabela */
.tabs .btn{
  width:100%;
  padding:18px;            /* Aumenta altura */
  font-size:18px;          /* Texto maior */
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

  <a class="back-btn" href="admin.php"> Voltar</a>

  <h1>Gerenciar Produtos</h1>

  <!-- ABAS -->
  <div class="tabs">
    
<button class="btn" onclick="window.location='insereProduto.php'">Inserir Produtos</button>    
<button class="btn" onclick="window.location='listaProduto.php'"> Ver e modificar Produtos</button>    


  </div>
 </div>
  
</body>
</html>