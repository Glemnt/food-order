<?php 
    // Incluir "constantes.php. para 'SITEURL'
    include('../config/constantes.php');

    // 1. Desfaça a Sessão
    session_destroy();     // Unsets $_SESSION['user']

    // Redirecionar para Página de Login
    header('location:'.SITEURL.'admin/login.php');
?>