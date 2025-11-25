

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
  </style>

</head>

<body>

<div class="container">

  <!-- HEADER -->
  <header>
    <div class="brand">
      <div class="logo">AB</div>
      <div>
        <h1>Setor Administrativo</h1>
      </div>
    </div>
  </header>

  <!-- NAV -->
  <div class="tabs">
    <button class="tab-btn active" data-tab="pedidos">Ver pedidos</button>
    <button class="tab-btn" data-tab="produtos">Gerenciar produtos</button>
  </div>

  <!-- ================= PAINEL PEDIDOS ================= -->
  <section class="panel active" id="pedidos">
    <h2>Pedidos</h2>

    <form method="post">
      <div class="form-row">
        <input id="dataPedido" placeholder="dd/mm/aaaa">
        <button type="submit" class="btn" name="enviar">Enviar</button>
      </div>
    </form>

    <div class="table-box">
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Cliente</th>
            <th>Total</th>
          </tr>
        </thead>
        <tbody id="listaPedidos"></tbody>
      </table>
    </div>
  </section>

  <!-- ================= PAINEL PRODUTOS ================= -->
  <section class="panel" id="produtos">
    <h2>Produtos</h2>

    <form class="form-row" method="post">
      <input id="nomeProduto" placeholder="Produto">
      <input id="precoProduto" type="number" placeholder="Preço" step="0.01">
      <button class="btn">Adicionar</button>
  </form>

    <div class="table-box">
      <table>
        <thead>
          <tr>
            <th>Produto</th>
            <th>Preço</th>
          </tr>
        </thead>
        <tbody id="listaProdutos"></tbody>
      </table>
    </div>
  </section>

</div>

<!-- ================= JS ================= -->
<script>
  // Troca abas
  const tabButtons = document.querySelectorAll('.tab-btn');
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







?>



>>>>>>> Miguel
