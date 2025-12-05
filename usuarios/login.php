
 <?php
 
                // Constantes do login de admin
                define("miguelifmg24@gmail.com", "777");
                define("arthurrr778@gmail.com", "777");

                    $mensagem = "";
            

                // Se o formulário foi enviado:
                if (isset($_POST["enviar"]) ) {
              
                $email = $_POST["email"] ?? "";
                $senha = $_POST["senha"] ?? "";

                if ($email == "miguelifmg24@gmail.com" && $senha == 777 || $email == "arthurrr778@gmail.com" && $senha == 777) {
                $mensagem = " "; 
                // Redireciona para a página de admin
header("Location: ../admin.php");           
     exit;

                } else {
        $mensagem = "<div class='alert alert-danger mt-2'>Email ou senha incorretos!</div>";
    }

                }
           
                ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Abeias Burguer - Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    <style>
        body{
            background: linear-gradient(135deg, #4c5483ff, #080d2b);
            color: #fff;
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card{
            background-color: #0b123a;
            border-radius: 12px;
            padding: 35px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 0 12px rgba(255, 132, 0, .15);
        }

        .login-title{
            font-weight: 700;
            color: #ff9300;
            font-size: 1.8rem;
            margin-bottom: 25px;
            text-align: center;
        }

        .form-control{
            background-color: #10183e;
            border: 1px solid #1f2a55;
            color: #fff;
        }

        .form-control:focus{
            border-color: #ff9300;
            box-shadow: 0 0 4px rgba(255, 147, 0, .5);
        }

        .btn-login{
            background-color: #ff9300;
            border: none;
            font-weight: 600;
        }

        .btn-login:hover{
            background-color: #ffa726;
        }

        a{
            color: #ff9300;
            text-decoration: none;
        }

        a:hover{
            text-decoration: underline;
        }
.page-container {
    position: relative;
    width: 100%;
    max-width: 450px;
}

.back-btn{
    position: absolute;
    top: -60px;     /* move para cima */
    left: 0;
    padding: 8px 16px;
    background:#E06A24;
    color:#10183e;
    font-weight:bold;
    border-radius:8px;
    text-decoration:none;
    transition:0.3s;
    box-shadow:0 3px 8px rgba(0,0,0,0.25);
}

.back-btn:hover{
    transform:translateX(-3px);
}
    </style>
</head>
<body>
<div class="page-container">

    <a class="back-btn" href="cadastro.html"> Voltar</a>
    <div class="login-card">
        

        <h1 class="login-title">Entrar no Abeias Burguer</h1>

        <form method="POST" action="processa_login.php">
            <div class="mb-3">
                <label class="form-label">E-mail</label>
                <input type="email" class="form-control" placeholder="Digite seu e-mail" name="email">
            </div>

            <div class="mb-4">
                <label class="form-label">Senha</label>
                <input type="password" class="form-control" placeholder="Digite sua senha" name ="senha">
            </div>

            <button type="submit" class="btn btn-login w-100 mb-3" name ="enviar" href= "../admin.php"
            >Entrar</button>
            <?php
    echo $mensagem; // ← exibe o alerta
?>
               

            <p class="text-center">
                Não tem conta? <a href="cadastro.html">Cadastre-se aqui</a>
            </p>
        </form>
       

    </div>

</body>
</html>


