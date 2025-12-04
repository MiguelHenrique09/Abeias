<?php
session_start();

// ====================
// ADMINs FIXOS
// ====================
$admins = [
    "miguelifmg24@gmail.com" => "777",
    "arthurrr778@gmail.com" => "777"
];

// ====================
// CONEXÃO COM BANCO
// ====================
$conn = new mysqli("localhost", "root", "Mhs2009.", "cardapiovirtual");
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// ====================
// RECEBE FORMULÁRIO
// ====================
$email = trim($_POST["email"] ?? "");
$senha = trim($_POST["senha"] ?? "");

// SE CAMPO VIER VAZIO
if ($email === "" || $senha === "") {
    echo "<div class='alert alert-danger'>Preencha tudo certim!</div>";
    exit;
}

// ====================
// LOGIN COMO ADMIN
// ====================
if (array_key_exists($email, $admins) && $admins[$email] === $senha) {

    $_SESSION['admin_logado'] = true;
    $_SESSION['email'] = $email;

    header("Location: ../admin.php");
    exit;
}

// ====================
// LOGIN COMO USUÁRIO NORMAL
// ====================
$sql = "SELECT idCliente, username, password_ FROM cliente WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

// Se achou o usuário
if ($result->num_rows > 0) {
    $usuario = $result->fetch_assoc();

    // Comparação simples (SEM HASH)
    if ($senha === $usuario['password_']) {

        $_SESSION['usuario_id'] = $usuario['idCliente'];
        $_SESSION['usuario_email'] = $usuario['username'];

        header("Location: ../Pedido/pedidos.php");
        exit;

    } else {
     
             echo "<script>alert('Senha incorreta !!!'); window.location.href='login.php';</script>";
        exit;
    }

} else {
       echo "<script>alert('Email inexistente!!!'); window.location.href='login.php';</script>";
    exit;
}

$stmt->close();
$conn->close();
?>
