<?php include('partes/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Category</h1>

        <br><br>


        <?php 
        
            //Verifica se o id está definido ou não
            if(isset($_GET['idCategorias']))
            {
                //Obtém o ID e todos os outros detalhes
                //echo "Obtendo os dados";
                $idCategorias = $_GET['idCategorias'];
                //Criar consulta SQL para obter todos os outros detalhes
                $sql = "SELECT * FROM categoria_produto WHERE idCategorias=$idCategorias";

                // Executa a consulta
                $res = mysqli_query($conn, $sql);

                //Conta as Linhas para verificar se o id é válido ou não
                $count = mysqli_num_rows($res);

                if($count==1)
                {
                    //Pega todos os dados
                    $row = mysqli_fetch_assoc($res);
                    $nome = $row['nome'];
                    $imagem_atual = $row['nome_imagem'];
                    $destaque = $row['destaque'];
                    $ativo = $row['ativo'];
                }
                else
                {
                    //redireciona para gerenciar categoria com mensagem de sessão
                    $_SESSION['no-category-found'] = "<div class='error'>Category not Found.</div>";
                    header('location:'.SITEURL.'admin/manage-category.php');
                }

            }
            else
            {
                //redireciona para Manage Category
                header('location:'.SITEURL.'admin/manage-category.php');
            }
        
        ?>

        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">
                <tr>
                    <td>Nome: </td>
                    <td>
                        <input type="text" name="nome" value="<?php echo $nome; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Imagem atual: </td>
                    <td>
                        <?php 
                            if($imagem_atual != "")
                            {
                                //Mostra a imagem
                                ?>
                                <img src="<?php echo SITEURL; ?>images/category/<?php echo $imagem_atual; ?>" width="150px">
                                <?php
                            }
                            else
                            {
                                //Mostra mensagem
                                echo "<div class='error'>Imagem não adicionada.</div>";
                            }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>Nova Imagem: </td>
                    <td>
                        <input type="file" name="nova_imagem">
                    </td>
                </tr>

                <tr>
                    <td>Destaque: </td>
                    <td>
                        <input <?php if($destaque=="Sim"){echo "checked";} ?> type="radio" name="destaque" value="Sim"> Sim 

                        <input <?php if($destaque=="Nao"){echo "checked";} ?> type="radio" name="destaque" value="Nao"> Não 
                    </td>
                </tr>

                <tr>
                    <td>ativo: </td>
                    <td>
                        <input <?php if($ativo=="Sim"){echo "checked";} ?> type="radio" name="ativo" value="Sim"> Sim 

                        <input <?php if($ativo=="Nao"){echo "checked";} ?> type="radio" name="ativo" value="Nao"> Não 
                    </td>
                </tr>

                <tr>
                    <td>
                        <input type="hidden" name="imagem_atual" value="<?php echo $imagem_atual; ?>">
                        <input type="hidden" name="idCategorias" value="<?php echo $idCategorias; ?>">
                        <input type="submit" name="submit" value="Atualizar Categoria" class="btn-secondary">
                    </td>
                </tr>

            </table>

        </form>

        <?php 
        
            if(isset($_POST['submit']))
            {
                //echo "Cliquei";
                //1. Obtenha todos os valores do nosso formulário
                $idCategorias = $_POST['idCategorias'];
                $nome = $_POST['nome'];
                $imagem_atual = $_POST['imagem_atual'];
                $destaque = $_POST['destaque'];
                $ativo = $_POST['ativo'];

                //2. Atualizando Nova Imagem se selecionado
                //Verifica se a imagem está selecionada ou não
                if(isset($_FILES['nova_imagem']['name']))
                {
                   //Obter os detalhes da imagem
                    $nome_imagem = $_FILES['nova_imagem']['name'];

                    //Verifica se a imagem está disponível ou não
                    if($nome_imagem != "")
                    {
                        //imagem disponível

                        //A. Carregue a Nova Imagem

                        //Auto renomear nossa imagem
                        //Obter a extensão da nossa imagem (jpg, png, gif, etc) por ex. "comida especial1.jpg"

                        $ext = pathinfo($nome_imagem, PATHINFO_EXTENSION);
                        //$ext = end(explode('.', $image_name));

                        //Renomear a imagem
                        $nome_imagem = "Categoria_".rand(000, 999).'.'.$ext; // e.g. Food_Category_834.jpg
                        

                        $source_path = $_FILES['nova_imagem']['tmp_name'];

                        $destination_path = "../images/category/".$nome_imagem;

                        //Finalmente carrega a imagem
                        $upload = move_uploaded_file($source_path, $destination_path);

                        //Verifica se a imagem foi carregada ou não
                        //E se a imagem não for carregada, interromperemos o processo e redirecionaremos com mensagem de erro
                        if($upload==false)
                        {
                            //Definir mensagem
                            $_SESSION['upload'] = "<div class='error'>Failed to Upload Image. </div>";
                            //Redirecionar para adicionar página de categoria
                            header('location:'.SITEURL.'admin/manage-category.php');
                            //parar o processo
                            die();
                        }

                        //B. Remova a imagem atual, se disponível
                        if($imagem_atual!="")
                        {
                            $remove_path = "../images/category/".$imagem_atual;

                            $remove = unlink($remove_path);

                            //Verifica se a imagem foi removida ou não
                            //Se falhou ao remover, exibe a mensagem e interrompe os processos
                            if($remove==false)
                            {
                                //Falha ao remover a imagem
                                $_SESSION['failed-remove'] = "<div class='error'>Failed to remove current Image.</div>";
                                header('location:'.SITEURL.'admin/manage-category.php');
                                die();
                                // Interrompe o processo
                            }
                        }
                        

                    }
                    else
                    {
                        $nome_imagem = $imagem_atual;
                    }
                }
                else
                {
                    $nome_imagem = $imagem_atual;
                }

                //3. Atualizar o banco de dados
                $sql2 = "UPDATE categoria_produto SET 
                    nome = '$nome',
                    nome_imagem = '$nome_imagem',
                    destaque = '$destaque',
                    ativo = '$ativo' 
                    WHERE idCategorias=$idCategorias
                ";

                //Execute the Query
                $res2 = mysqli_query($conn, $sql2);

                //4. Redirecionar para gerenciar categoria com mensagem
                //Verifica se foi executado ou não
                if($res2==true)
                {
                    //Categoria atualizada
                    $_SESSION['update'] = "<div class='success'>Categoria atualizada com sucesso.</div>";
                    header('location:'.SITEURL.'admin/manage-category.php');
                }
                else
                {
                    //Falha ao atualizar a categoria
                    $_SESSION['update'] = "<div class='error'>Falha ao atualizar a categoria.</div>";
                    header('location:'.SITEURL.'admin/manage-category.php');
                }

            }
        
        ?>

    </div>
</div>

<?php include('partes/footer.php'); ?>