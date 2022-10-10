<?php 
    // Incluir o Arquivo Constantes.php
    include('../config/constantes.php');
    
    // echo "Delete Page";
    // Verificar se o id e o image_name esta setado ou não 
    if(isset($_GET['id']) AND isset($_GET['image_name']))
    {
        // Pegar o valor e Deletar
        // echo "Get Value and Delete";
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        // Remover a imagem Física se Disponível
        if($image_name != "")
        {
            // Imagem está disponível. Então irá Remover a Imagem
            $path = "../images/category/".$image_name;
            // Remover a Imagem
            $remove = unlink($path);

            // Se der ERRO para remover a imagem, então aparecer Mensagem de ERRO e Encerrar o Processo
            if($remove == false)
            {
                // Setar a Mensagem
                $_SESSION['remove'] = "<div class='error'>Erro ao deletar imagem</div>";
                
                // Redirecionar para a Página "manage-category"
                header('location:'.SITEURL.'admin/manage-category.php');
                
                // Encerrar o Processo
                die();
            }
        }

        // Remover os Dados do Banco
        // SQL Query para Deletar os Dados do Banco
        $sql = "DELETE FROM tbm_category WHERE id=$id";

        // Executar a Query
        $res = mysqli_query($conn, $sql);

        // Verificar se os Dados Foram Deletados do Banco ou Não
        if($res == true)
        {
            // Aparecer Mensagem de Sucesso e Redirecionar 
            $_SESSION['delete'] = "<div class='success'>Categoria deletada com sucesso!</div>";
            // Redirecionar para a página "manage-category"
            header('location:'.SITEURL.'admin/manage-category.php');
        }
        else
        {
            // Aparecer mensagem de ERRO e Redirecionar
            $_SESSION['delete'] = "<div class='error'>Erro ao deletar categoria</div>";
            // Redirecionar para a página "manage-category"
            header('location:'.SITEURL.'admin/manage-category.php');
        }


    }
    else
    {
        // Redirecionar para a Página "manage-category"
        header('location:'.SITEURL.'admin/manage-category.php');
    }
?>