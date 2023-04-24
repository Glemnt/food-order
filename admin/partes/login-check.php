<?php 
    // Autorização // Access Control 
    //Verificar quando o Usuário está logado ou não
    if(!isset($_SESSION['user'])) // ! = Se a sessão do usuário não estiver definida
    {
        // Usuário não está logado
        // Redirecionar para página de login com mensagem
        $_SESSION['no-login-message'] = "<div class='error text-center'>Login to access admin panel</div>";

        // Redirecionar para página de login
        header('location:'.SITEURL.'admin/login.php');
    }
?>