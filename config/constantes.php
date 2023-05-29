<?php

    // Iniciando Sessão
    session_start();

    // Criar constantes para armazenar valores não repetidos
    define('SITEURL', 'http://localhost/');
    define('LOCALHOST', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'restaurantex');

    $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error()); // Conexão com o Banco --$conn--
    $db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error()); // Selecionando o Banco              --$conn--

?>