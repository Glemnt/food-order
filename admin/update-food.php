<?php include('partes/menu.php'); ?>

<div class="main">
    <div class="wrapper">
        <h1>Update Food</h1>

        <br><br>

        <?php

            // Verificar se o id está setado ou Não
            if (isset($_GET['id'])) 
            {
                // Pegar o id e todos os outros detalhes
                // echo "Getting the data";
                $id = $_GET['id'];
                // Criar SQL Query para pegar os outros Detalhes
                $sql2 = "SELECT * FROM tbl_food WHERE id=$id";

                // Executar a Query
                $res2 = mysqli_query($conn, $sql2);

                // Contar as linhas para Verificar se o id é válido ou Não
                $count = mysqli_num_rows($res2);
                
                if($count == 1)
                {
                    // Pegar todos os Dados
                    $row2 = mysqli_fetch_assoc($res2);
                    $title = $row2['title'];
                    $description = $row2['description'];
                    $price = $row2['price'];
                    $current_image = $row2['image_name'];
                    $current_category = $row2['category_id'];
                    $featured = $row2['featured'];
                    $active = $row2['active'];
                }
                else
                {
                    // Redirecionar para a página "manage-category" com mensagem
                    $_SESSION['no-food-found'] = "<div class='error'>Refeição não encontrada</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }

            }
            else
            {
                // Redirecionar para a página "manage-category"
                header('location:'.SITEURL.'admin/manage-food.php');
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
                <td>Descrição: </td>
                <td>
                    <textarea name="description" cols="30" rows="5"><?php echo $description; ?></textarea>     
                </td>
            </tr>

            <tr>
                <td>Preço: </td>
                <td>
                    <input type="number" name="price" value="<?php echo $price; ?>">
                </td>
            </tr>

            <tr>
                <td>Imagem atual: </td>
                <td>
                    <?php
                        if($current_image == "")
                        {
                            // Imagem não disponivel 
                            echo "<div class='error'>Imagem não disponível</div>";
                        } 
                        else
                        {
                            // Imagem Disponivel
                            ?>
                            <img src="<?php echo SITEURL; ?>images/food/<?php echo $current_image; ?>" width="150px">
                            <?php
                        }
                    ?>
                </td>
            </tr>

            <tr>
                <td>Selecionar nova imagem: </td>
                <td>
                    <input type="file" name="image">
                </td>
            </tr>

            <tr>
                <td>Categoria: </td>
                <td>
                    <select name="category">

                        <?php 
                            // Query para deixar categorias ativas
                            $sql = "SELECT * FROM tbm_category WHERE active='Sim'";
                            // Executar a query
                            $res = mysqli_query($conn, $sql);
                            // Contar as linhas
                            $count = mysqli_num_rows($res);

                            // Verificar quando a categoria está disponivel ou não 
                            if($count > 0)
                            {
                                // Categoria disponível
                                while($row = mysqli_fetch_assoc($res))
                                {
                                    $category_title = $row['title'];
                                    $category_id = $row['id'];
                                    
                                    // echo "<option value='$category_id'>$category_title</option>";  **Também pode ser Utilizado**
                                    ?>
                                    <option <?php if($current_category == $category_id){echo "selected";} ?> value="<?php echo $category_id; ?>"><?php echo $category_title; ?></option>
                                    <?php

                                }
                            }
                            else
                            {
                                // Categoria não disponível
                                echo "<option value='0'>Categoria não disponível</option>";
                            }
                        ?>

                    </select>
                </td>
            </tr>

            <tr>
                <td>Destaque: </td>
                <td>
                    <input <?php if($featured == "Sim") {echo "checked";} ?> type="radio" name="featured" value="Sim"> Sim

                    <input <?php if($featured == "Não") {echo "checked";} ?> type="radio" name="featured" value="Não"> Não
                </td>
            </tr>

            <tr>
                <td>Ativo: </td>
                <td>
                    <input <?php if($active == "Sim") {echo "checked";} ?> type="radio" name="active" value="Sim"> Sim
                        
                    <input <?php if($active == "Não") {echo "checked";} ?> type="radio" name="active" value="Não"> Não
                </td>
            </tr>

            <tr>
                <td>
                    <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="submit" name="submit" value="Update Food" class="btn-dois">
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
                $description = $_POST['description'];
                $price = $_POST['price'];
                $current_image = $_POST['current_image'];
                $category = $_POST['category'];
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
                        $image_name = "Food_Name_".rand(000, 999).'.'.$ext; // e.g. "Food_Category_834.jpg

                        $src_path = $_FILES['image']['tmp_name'];

                        $dest_path = "../images/food/".$image_name;

                        // Upload Imagem
                        $upload = move_uploaded_file($src_path, $dest_path);

                        // Verificar se a Imagem foi Adicionada ou Não
                        // e se a imagem não foi adicionada irá encerrar o processo e redirecionar com msg de ERRO
                        if($upload == false)
                        {
                            // Definir Mensagem
                            $_SESSION['upload'] = "<div class='error'>Erro ao dar Upload na imagem</div>";
                            // Redirecionar para a página "manage-category"
                            header('location:'.SITEURL.'admin/manage-food.php'); 
                            // Parar o Processo 
                            die();
                        }

                        // B. Remover a Imagem Atual se Disponível
                        if($current_image != "")
                        {
                            $remove_path = "../images/food/".$current_image;

                            $remove = unlink($remove_path);
                            
                            // Verificar quando a imagem foi removida ou não
                            // Se tiver ERRO para remover a imagem então exibir mensagem e encerrar o processo
                            if($remove == false)
                            {
                                // ERROR ao remover imagem
                                $_SESSION['failed-remove'] = "<div class='error'>Erro ao remover imagem atual</div>";
                                header('location:'.SITEURL.'admin/manage-food.php');
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
                $sql3 = "UPDATE tbl_food SET 
                    title = '$title',
                    description = '$description',
                    price = $price,
                    image_name = '$image_name',
                    category_id = '$category',
                    featured = '$featured',
                    active = '$active'
                    WHERE id = $id 
                ";

                // Executar a QUERY
                $res3 = mysqli_query($conn,$sql3);

                // 4. Redirecionar para a página "manage category" com Mensagem
                // Verificar quando executado ou não
                if($res3 == true)
                {
                    // Categoria Atualizada
                    $_SESSION['update'] = "<div class='success'>Refeição atualizada com sucesso!</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');

                }
                else
                {
                    // ERRO ao Atualizar Categoria
                    $_SESSION['update'] = "<div class='error'>Erro ao atualizar Refeição</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }

            }

        ?>

    </div>
</div>

<?php include('partes/footer.php'); ?>