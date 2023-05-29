<?php 
    // Incluir o Arquivo Constantes.php
    include('../config/constantes.php');
    
    // Verificar se o idCategorias está setado ou não 
    if(isset($_GET['idCategorias']))
    {
        // Pegar o valor e Deletar
        $idCategorias = $_GET['idCategorias'];

        // Remover os Dados do Banco
        // SQL Query para Deletar os Dados do Banco
        $sql = "DELETE FROM categoria_produto WHERE idCategorias=$idCategorias";

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
