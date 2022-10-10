<?php include('partes/menu.php'); ?>

<div class="main">
    <div class="wrapper">
        <h1>Update Category</h1>

        <br><br>

        <?php

            // Verificar se o id está setado ou Não
            if (isset($_GET['id'])) 
            {
                // Pegar o id e todos os outros detalhes
                // echo "Getting the data";
                $id = $_GET['id'];
                // Criar SQL Query para pegar os outros Detalhes
                $sql = "SELECT * FROM tbm_category WHERE id=$id";

                // Executar a Query
                $res = mysqli_query($conn, $sql);

                // Contar as linhas para Verificar se o id é válido ou Não
                $count = mysqli_num_rows($res);
                
                if($count == 1)
                {
                    // Pegar todos os Dados
                    $row = mysqli_fetch_assoc($res);
                    $title = $row['title'];
                    $current_image = $row['image_name'];
                    $featured = $row['featured'];
                    $active = $row['active'];
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

        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">

                <tr>
                    <td>Título: </td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Imagem Atual: </td>
                    <td>
                        <?php 
                            if($current_image != "")
                            {
                                // Mostrar imagem
                                ?>
                                    <img src="<?php echo SITEURL; ?>images/category/<?php echo $current_image; ?>" width = "150px">
                                <?php
                            }
                            else
                            {
                                // Mostrar imagem
                                echo "<div class='error'>Erro ao adicionar imagem</div>";
                            }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>Nova Imagem: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Destaque: </td>
                    <td>
                        <input <?php if($featured == "Sim"){echo "checked";} ?> type="radio" name="featured" value="Sim"> Sim

                        <input <?php if($featured == "Não"){echo "checked";} ?> type="radio" name="featured" value="Não"> Não
                    </td>
                </tr>

                <tr>
                    <td>Ativo: </td>
                    <td>
                        <input <?php if($active == "Sim"){echo "checked";} ?> type="radio" name="active" value="Sim"> Sim

                        <input <?php if($active == "Não"){echo "checked";} ?> type="radio" name="active" value="Não"> Não
                    </td>
                </tr>

                <tr>
                    <td>
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Category" class="btn-dois">
                    </td>
                </tr>

            </table>

        </form>

        <?php 

            if(isset($_POST['submit']))
            {
                // echo "Clicked";
                // 1. Pegar todos os valores do formulário
                $id = $_POST['id'];
                $title = $_POST['title'];
                $current_image = $_POST['current_image'];
                $featured = $_POST['featured'];
                $active = $_POST['active'];
                
                // 2. Dar Upload em uma nova imagem se selecionada
                // Verificar quando a imagem foi selecionada ou não
                if(isset($_FILES['image']['name']))
                {
                    // Pegar os detalhes da imagem
                    $image_name = $_FILES['image']['name'];

                    // Verificar se a imagem está disponível ou não
                    if($image_name != "")
                    {
                        // Imagem Disponível
                        // A. Dar Upload na nova Imagem

                        // Auto Renomear Imagem
                        // Verificar a extenção da imagem (jpg, png, gif, etc..) e.g. "specialfood1.jpg"
                        $ext = end(explode('.', $image_name));

                        // Renomear a Imagem
                        $image_name = "Food_Category_".rand(000, 999).'.'.$ext; // e.g. "Food_Category_834.jpg

                        $source_path = $_FILES['image']['tmp_name'];

                        $destination_path = "../images/category/".$image_name;

                        // Upload Imagem
                        $upload = move_uploaded_file($source_path, $destination_path);

                        // Verificar se a Imagem foi Adicionada ou Não
                        // e se a imagem não foi adicionada irá encerrar o processo e redirecionar com msg de ERRO
                        if($upload == false)
                        {
                            // Definir Mensagem
                            $_SESSION['upload'] = "<div class='error'>Erro ao dar Upload na imagem</div>";
                            // Redirecionar para a página "manage-category"
                            header('location:'.SITEURL.'admin/manage-category.php'); 
                            // Parar o Processo 
                            die();
                        }

                        // B. Remover a Imagem Atual se Disponível
                        if($current_image != "")
                        {
                            $remove_path = "../images/category/".$current_image;

                            $remove = unlink($remove_path);
                            
                            // Verificar quando a imagem foi removida ou não
                            // Se tiver ERRO para remover a imagem então exibir mensagem e encerrar o processo
                            if($remove == false)
                            {
                                // ERROR ao remover imagem
                                $_SESSION['failed-remove'] = "<div class='error'>Erro ao remover imagem atual</div>";
                                header('location:'.SITEURL.'admin/manage-category.php');
                                die(); // Encerrar o processo 
                            } 
                        }
                        
                    }
                    else
                    {
                        $image_name = $current_image;
                    }
                }
                else
                {
                    $image_name = $current_image;
                }

                // 3. Dar Update no Banco de Dados
                $sql2 = "UPDATE tbm_category SET 
                    title = '$title',
                    image_name = '$image_name',
                    featured = '$featured',
                    active = '$active'
                    WHERE id = $id
                ";

                // Executar a QUERY
                $res2 = mysqli_query($conn,$sql2);

                // 4. Redirecionar para a página "manage category" com Mensagem
                // Verificar quando executado ou não
                if($res == true)
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