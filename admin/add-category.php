<?php include('partes/menu.php'); ?>

<div class="main">
    <div class="wrapper">
        <h1>Add Category</h1>

        <br><br>

        <?php

            if(isset($_SESSION['add']))
            {
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }

            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
            
        ?>

        <br><br>

        <!-- Formulário de adicionar categoria Começa Aqui -->
        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">
                <tr>
                    <td>Título: </td>
                    <td>
                        <input type="text" name="title" placeholder="Título da Categoria">
                    </td>
                </tr>

                <tr>
                    <td>Selecionar Imagem: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Destaque: </td>
                    <td>
                        <input type="radio" name="featured" value="Sim"> Sim
                        <input type="radio" name="featured" value="Não"> Não
                    </td>
                </tr>

                <tr>
                    <td>Ativo: </td>
                    <td>
                        <input type="radio" name="active" value="Sim"> Sim
                        <input type="radio" name="active" value="Não"> Não
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Category" class="btn-dois">
                    </td>
                </tr>

            </table>

        </form>
        <!-- Formulário de adicionar categoria Acaba Aqui -->

        <?php
            // Verificar quando o botão de submit foi clicado ou não
            if (isset($_POST['submit'])) 
            {
                // echo "clicked";

                // Pegar o valor do formulário de Categoria
                $title = $_POST['title'];

                // Para o input radio, precisamos ver quando o botão foi selecionado ou não
                if (isset($_POST['featured'])) 
                {
                    // Pegar o valor do formulário
                    $featured = $_POST['featured'];
                } 
                else 
                {
                    // Setar o valor Defalt
                    $featured = "Não";
                }

                if (isset($_POST['active'])) 
                {
                    $active = $_POST['active'];
                } 
                else 
                {
                    $active = "Não";
                }

                // Verificar se a imagem foi selecionada ou não e setar o valor de acordo com o nome da imagem
                //print_r($_FILES['image']);

                //die(); // Quebrar o Código Aqui

                if(isset($_FILES['image']['name']))
                {
                    // Upload na Imagem
                    // Para dar upload na imagem precisamos do nome da imagem, do caminho de origem e o destino 
                    $image_name = $_FILES['image']['name'];

                    // Dar Upload na imagem só se a imagem for selecionada
                    if($image_name != "")
                    { 

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
                            // Redirecionar para a página "add-category"
                            header('location:'.SITEURL.'admin/add-category.php'); 
                            // Parar o Processo 
                            die();

                        }

                    }
                }
                else
                {
                    // Não dar upload na imagem e setar o image_name em branco
                    $image_name = "";
                }

                // 2. Criar a SQL Query para Inserir Categoria no Banco de Dados
                $sql = "INSERT INTO tbm_category SET
                            title = '$title',
                            image_name = '$image_name',
                            featured = '$featured',
                            active = '$active'
                        ";

                // 3. Executar a QUERY e Salvar no Banco de Dados
                $res = mysqli_query($conn, $sql);

                // 4. Verificar se a QUERY foi executada ou não e se os dados foram add ou não
                if($res==true)
                {
                    // QUERY executada e categoria adicionada
                    $_SESSION['add'] = "<div class='success'>Categoria adicionada com sucesso!</div>";
                    //Redirecionar para a página "manage-category"
                    header('location:'.SITEURL.'admin/manage-category.php'); 
                }
                else
                {
                    // ERROR para adicionar Query
                    $_SESSION['add'] = "<div class='error'>Erro ao adicionar categoria</div>";
                    //Redirecionar para a página "manage-category"
                    header('location:'.SITEURL.'admin/add-category.php'); 
                }
            }

        ?>

    </div>
</div>

<?php include('partes/footer.php'); ?>