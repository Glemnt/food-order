<?php
    // Incluir a Página "constantes"
    include('../config/constantes.php');

    //echo "Delete Food Page";

    if(isset($_GET['idProduto']) && isset($_GET['nome_imagem'])) // Pode Usar tanto '&&' quanto 'AND'  
    {
        // Processo para Deletar
        // echo "Process to Delete";

        // 1. Pegar o ID e o Nome da Imagem
        $idProduto = $_GET['idProduto'];
        $nome_imagem = $_GET['nome_imagem'];

        // 2. Remover a Imagem se Disponível
        // Verificar se a Imagem está disponível ou Não e deletar se Disponível
        if($nome_imagem != "")
        {
            // Tem Imagem e Precisa Remover da Pasta
            // Buscar o Caminho de Origem
            $path = "../images/food/".$nome_imagem;

            // Remover o Arquivo de Imagem da Pasta
            $remove = unlink($path);

            // Verificar se a Imagem foi Removida ou Não
            if($remove == false)
            {
                // Falha ao Remover Imagem
                $_SESSION['upload'] = "<div class='error'>Erro ao remover imagem</div>";
                // Redirecionar para a Página "manage-food"
                header('location:'.SITEURL.'admin/manage-food.php');
                // Encerrar o Processo de Deletar Comida
                die();
            }
        }

        // 3. Remover Refeição do Banco de Dados
        $sql = "DELETE FROM menu WHERE idProduto=$idProduto";
        //Executar a QUERY
        $res = mysqli_query($conn, $sql);

        // Verificar quando a QUERY foi executada ou não
        // 4. Redirecionar para a Página "manage-food" com Mensagem
        if($res == true)
        {
            // Aparecer Mensagem de Sucesso e Redirecionar 
            $_SESSION['delete'] = "<div class='success'>Refeição deletada com sucesso!</div>";
            // Redirecionar para a página "manage-food"
            header('location:'.SITEURL.'admin/manage-food.php');
        }
        else
        {
            // Aparecer mensagem de ERRO e Redirecionar
            $_SESSION['delete'] = "<div class='error'>Erro ao deletar Refeição</div>";
            // Redirecionar para a página "manage-food"
            header('location:'.SITEURL.'admin/manage-food.php');
        }
        
        
       
    }
    else
    {
        // Redirecionar para a Página "manage-food"
        // echo "Redirect";
        $_SESSION['unauthorize'] = "<div class='error'>Acesso Negado</div>";
        header('location:'.SITEURL.'admin/manage-food.php');  
    }

?>