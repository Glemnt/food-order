<?php include('partes/menu.php'); ?>

<div class="main">
    <div class="wrapper">
        <h1>Atualizar Categoria</h1>

        <br><br>

        <?php

            // Verificar se o id está definido ou não
            if (isset($_GET['idCategorias'])) 
            {
                // Obter o id e todos os outros detalhes
                $idCategorias = $_GET['idCategorias'];
                // Criar SQL Query para obter os outros detalhes
                $sql = "SELECT * FROM categoria_produto WHERE idCategorias=$idCategorias";

                // Executar a Query
                $res = mysqli_query($conn, $sql);

                // Contar as linhas para verificar se o id é válido ou não
                $count = mysqli_num_rows($res);

                if($count == 1)
                {
                    // Obter todos os dados
                    $row = mysqli_fetch_assoc($res);
                    $nome = $row['nome'];
                    $nome_imagem = $row['nome_imagem'];
                    $destaque = $row['destaque'];
                    $ativo = $row['ativo'];
                }
                else
                {
                    // Redirecionar para a página "manage-category" com mensagem
                    $_SESSION['no-category-found'] = "<div class='error'>Categoria não encontrada</div>";
                    header('location:'.SITEURL.'admin/manage-category.php');
                }

            }
            else
            {
                // Redirecionar para a página "manage-category"
                header('location:'.SITEURL.'admin/manage-category.php');
            }
        ?>
    </div>
</div>


<form action="" method="POST" enctype="multipart/form-data">
    <table class="tbl-30">
        <tr>
            <td>Nome: </td>
            <td>
                <input type="text" name="nome" value="<?php echo $nome; ?>">
            </td>
        </tr>
        <tr>
            <td>Imagem Atual: </td>
            <td>
                <?php 
                    if($nome_imagem != "")
                    {
                        // Mostrar imagem
                        ?>
                            <img src="<?php echo SITEURL; ?>images/category/<?php echo $nome_imagem; ?>" width = "150px">
                        <?php
                    }
                    else
                    {
                        // Mostrar mensagem de erro
                        echo "<div class='error'>Erro ao adicionar imagem</div>";
                    }
                ?>
            </td>
        </tr>
        <tr>
            <td>Nova Imagem: </td>
            <td>
                <input type="file" name="nome_imagem">
            </td>
        </tr>
        <tr>
            <td>Destaque: </td>
            <td>
                <input <?php if($destaque == "Sim"){echo "checked";} ?> type="radio" name="destaque" value="Sim"> Sim
                <input <?php if($destaque == "Não"){echo "checked";} ?> type="radio" name="destaque" value="Não"> Não
            </td>
        </tr>
        <tr>
            <td>Ativo: </td>
            <td>
                <input <?php if($ativo == "Sim"){echo "checked";} ?> type="radio" name="ativo" value="Sim"> Sim
                <input <?php if($ativo == "Não"){echo "checked";} ?> type="radio" name="ativo" value="Não"> Não
            </td>
        </tr>
        <tr>
            <td>
                <input type="hidden" name="nome_imagem_atual" value="<?php echo $nome_imagem; ?>">
                <input type="hidden" name="idCategorias" value="<?php echo $idCategorias; ?>">
                <input type="submit" name="submit" value="Atualizar Categoria" class="btn-dois">
            </td>
        </tr>
    </table>
</form>

<?php
if(isset($_POST['submit']))
{
    // Pegar todos os valores do formulário
    $idCategorias = $_POST['idCategorias'];
    $nome = $_POST['nome'];
    $nome_imagem = $_POST['nome_imagem'];
    $destaque = $_POST['destaque'];
    $ativo = $_POST['ativo'];

    // Verificar se a imagem foi selecionada ou não
    if(isset($_FILES['imagem']['name']))
    {
        // Pegar os detalhes da imagem
        $nome_imagem = $_FILES['imagem']['name'];

        // Verificar se a imagem está disponível ou não
        if($nome_imagem != "")
        {
            // Imagem Disponível
            // A. Dar Upload na nova Imagem

            // Auto Renomear Imagem
            $extensao = end(explode('.', $nome_imagem));

            // Renomear a Imagem
            $nome_imagem = "Categoria_".rand(000, 999).'.'.$extensao;

            $source_path = $_FILES['imagem']['tmp_name'];

            $destination_path = "../images/categoria/".$nome_imagem;

            // Upload Imagem
            $upload = move_uploaded_file($source_path, $destination_path);

            // Verificar se a Imagem foi Adicionada ou Não
            if($upload == false)
            {
                // Erro ao dar Upload na imagem
                $_SESSION['upload'] = "<div class='error'>Erro ao dar Upload na imagem</div>";
                header('location:'.SITEURL.'admin/manage-category.php');
                die();
            }

            // B. Remover a Imagem Atual se Disponível
            if($nome_imagem != "")
            {
                $remove_path = "../images/categoria/".$nome_imagem;

                $remove = unlink($remove_path);

                // Verificar quando a imagem foi removida ou não
                // Se tiver ERRO para remover a imagem então exibir mensagem e encerrar o processo
                if($remove == false)
                {
                    // ERROR ao remover imagem
                    $_SESSION['failed-remove'] = "<div class='error'>Erro ao remover imagem atual</div>";
                    header('location:'.SITEURL.'admin/manage-category.php');
                    die();
                }
            }

        }
        else
        {
            $nome_imagem = $nome_imagem_atual;
        }
    }
    else
    {
        $nome_imagem = $nome_imagem_atual;
    }

    // Dar Update no Banco de Dados
    $sql2 = "UPDATE categoria_produto SET
        nome = '$nome',
        nome_imagem = '$nome_imagem',
        destaque = '$destaque',
        ativo = '$ativo'
        WHERE idCategorias = $idCategorias
    ";

    // Executar a QUERY
    $res2 = mysqli_query($conn,$sql2);

    // Redirecionar para a página "manage category" com Mensagem
    if($res2 == true)
    {
        // Categoria Atualizada
        $_SESSION['update'] = "<div class='success'>Categoria atualizada com sucesso!</div>";
        header('location:'.SITEURL.'admin/manage-category.php');

    }
    else
    {
        // ERRO ao Atualizar Categoria
        $_SESSION['update'] = "<div class='error'>Erro ao atualizar categoria</div>";
        header('location:'.SITEURL.'admin/manage-category.php');
    }

}
?>


    </div>
</div>

<?php include('partes/footer.php'); ?>