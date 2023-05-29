<?php include('../config/constantes.php'); ?>


<html>

<head>
    <title>Login - Food Order System</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>

<section class="navBar">
    <div class="container">
      <div class="logo">
        <a href="<?php echo SITEURL; ?>" title="Logo">
          <img src="../images/logo.png" alt="Logo Restaurante" class="img-responsive" />
        </a>
      </div>
<body>

    <div class="login">
        <h1 class="text-center">Login</h1>
        <br><br>

        <?php
        if (isset($_SESSION['login'])) 
        {
            echo $_SESSION['login'];
            unset($_SESSION['login']);
        }

        if(isset($_SESSION['no-login-message']))
        {
            echo $_SESSION['no-login-message'];
            unset($_SESSION['no-login-message']);
        }
        ?>
        <br><br>

        <!-- Formulário de Login Começa Aqui -->
        <form action="" method="POST" class="text-center">
            Usuário: <br>
            <input type="text" name="usuario" placeholder="Username..."><br><br>

            Senha: <br>
            <input type="password" name="senha" placeholder="Password..."><br><br>

            <input type="submit" name="submit" value="Login" class="btn-um">
            <br><br>
        </form>
        <!-- Formulário de Login Acaba Aqui -->

        <p class="text-center">Created By - <a href="#">X</a></p>
    </div>

</body>

</html>


<?php

// Checar Quando o botão de Submit foi clicado ou não
if (isset($_POST['submit'])) 
{
    // Processo para Login
    // 1. Pegar os Dados do formulário de Login
    
    // $username = $_POST['username'];
    $usuario = mysqli_real_escape_string($conn, $_POST['usuario']);
    
    // $password = md5($_POST['password']);
    $raw_password = md5($_POST['senha']);
    $senha = mysqli_real_escape_string($conn, $raw_password);

    // SQL para Verificar se o Usuário com username e senha existe ou não
    $sql = "SELECT * FROM tb_admin WHERE usuario='$usuario' AND senha='$senha'";

    // Executar a QUERY
    $res = mysqli_query($conn, $sql);

    // Contar as linhas para Verificar se o Usuário Existe ou não
    $count = mysqli_num_rows($res);

    if ($count == 1) 
    {
        // Usuário Existe e Login Funciona
        $_SESSION['login'] = "<div class='success'>Login Successful</div>";
        $_SESSION['user'] = $usuario; // Para Verificar se o Usuário está logado ou não e o Logout vai unsetar ele

        // Redirecionar para Home Page/Dashboard
        header('location:'.SITEURL.'admin/');
    } 
    else 
    {
        // Usuário não Existe e LOgin não funciona
        $_SESSION['login'] = "<div class='error text-center'>Usuário ou senha não combinam</div>";
        // Redirecionar para Home Page/Dashboard
        header('location:'.SITEURL.'admin/login.php');
    }
}

?>



