<?php

    // Incluir o Arquivo "constantes.php" aqui
    include('../config/constantes.php');

    // 1. Pegar o ID do Admin para ser Deletado
    $id = $_GET['id'];

    // 2. Criar SQL Query para Deletar o Admin
    $sql = "DELETE FROM tbl_admin WHERE id = $id";

    // Executar a Query
    $res = mysqli_query($conn, $sql);

    // Verificar se a Query foi executada Corretamente ou não
    if($res==true)
    {
        // Query Executada Corretamente e Admin foi Deletado
        // echo "Admin Deletado";

        // Criar Variável Session para Mostrar a Mensagem
        $_SESSION['delete'] = "<div class='success'>Admin deletado com sucesso!</div>";

        // Redirecionar para a Página "manage-admin"
        header('location:'.SITEURL.'admin/manage-admin.php');
    }
    else
    {
        // ERRO ao Deletar Admin
        // echo "ERRO ao Deletar Admin";

        $_SESSION['delete'] = "<div class='error'>ERRO ao deletar Admin. Tente novamente.</div>";
        header('location:'.SITEURL.'admin/manage-admin.php');
    }

    // 3. Redirecionar para a Página "manage-admin" com Mensagem (success/error)

?>