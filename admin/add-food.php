<?php include('partes/menu.php'); ?>


<div class="main">
    <div class="wrapper">
        <h1>Add Food</h1>

        <br><br>

        <?php 
            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">

                <tr>
                    <td>Título: </td>
                    <td>
                        <input type="text" name="title" placeholder="Nome da Refeição">
                    </td>
                </tr>

                <tr>
                    <td>Descrição: </td>
                    <td>
                        <textarea name="description" cols="25" rows="5" placeholder="Descrição da Refeição"></textarea>
                    </td>
                </tr>

                <tr>
                    <td>Preço: </td>
                    <td>
                        <input type="number" name="price">
                    </td>
                </tr>

                <tr>
                    <td>Selecionar Imagem: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Categoria: </td>
                    <td>
                        <select name="category">

                            <?php 
                                // Criar código em PHP para mostrar categorias do Banco de Dados
                                // 1. Criar SQL para pegar todas as categorias ativas do Banco
                                $sql = "SELECT * FROM tbm_category WHERE active='Sim'";

                                // Executando a QUERY
                                $res = mysqli_query($conn, $sql);

                                // Contar linhas para verificar se vai ter categorias ou não
                                $count = mysqli_num_rows($res);
                                
                                // Se a contagem for maior que zero, teremos categoria, se não, não teremos
                                if($count > 0)
                                {
                                    // Tem Categoria
                                    while($row = mysqli_fetch_assoc($res))
                                    {
                                        // Pegar os detalhes da categoria
                                        $id = $row['id'];
                                        $title = $row['title'];

                                        ?>

                                        <option value="<?php echo $id; ?>"><?php echo $title; ?></option>
                                        
                                        <?php
                                    }
                                }
                                else
                                {
                                    // Não tem categoria
                                    ?>
                                    <option value="0">Categoria não encontrada</option>
                                    <?php
                                }

                                // 2. Mostrar no Dropdown 
                            ?>

                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Destaque: </td>
                    <td>
                        <input type="radio" name="featured" Value="Sim"> Sim
                        <input type="radio" name="featured" Value="Não"> Não
                    </td>
                </tr>

                <tr>
                    <td>Ativo: </td>
                    <td>
                    <input type="radio" name="active" Value="Sim"> Sim
                        <input type="radio" name="active" Value="Não"> Não
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Food" class="btn-dois">
                    </td>
                </tr>

            </table>
        </form>

        <?php 
            
            //Verificar quando o botão foi apertado ou não
            if(isset($_POST['submit']))
            {
                // Adicionar a comida no Banco de Dados
                // echo "Clicked";

                // 1. Pegar os Dados do Formulário
                $title = $_POST['title'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $category = $_POST['category'];

                // Verificar quando o radio do "Destaque" e do "Ativo" for Selecionado ou Não
                if(isset($_POST['featured']))
                {
                    $featured = $_POST['featured'];
                }
                else
                {
                    $featured = "Não"; // Definindo um valor Default
                }

                if(isset($_POST['active']))
                {
                    $active = $_POST['active'];
                }
                else
                {
                    $active = "Não"; // Definindo um valor Default
                }

                // 2. Dar Upload na Imagem se Selecioada
                // Verificar se o botão "Selecionar Imagem" foi clicado ou Não, e dar upload apenas se a imagem foi selecionada
                if(isset($_FILES['image']['name']))
                {
                    // Pegar os Detalhes da Imagem Selecionada
                    $image_name = $_FILES['image']['name'];

                    // Verificar se a Imagem foi Selecionada ou Não e Adicionar Apenas se Selecionada
                    if($image_name != "")
                    {
                        // Imagem foi Selecionada
                        // A. Renomear a Imagem
                        // Obter a Extenção da Imagem Selecionada jpg, png, gif, etc..
                        $ext = end(explode('.', $image_name));

                        // Definir Novo Nome para a Imagem
                        $image_name = "Food-Name-".rand(0000,9999).".".$ext;

                        // B. Dar Upload na Imagem
                        // Obter o Caminho de Origem e o de Destino

                        // O caminho de Origem é a Localização Atual da Imagem
                        $src = $_FILES['image']['tmp_name'];

                        // Caminho de Destino para que a Imagem seja Carregada
                        $dst = "../images/food/".$image_name;

                        // Finalmente dar Upload na Imagem
                        $upload = move_uploaded_file($src, $dst);

                        // Verificar se a Imagem foi Carregada ou Não
                        if($upload == false)
                        {
                            // ERRO ao Carregar Imagem

                            // Redirecionar para a Página "add-food" com MEnsagem de ERROR
                            $_SESSION['upload'] = "<div class='error'>Erro ao carregar imagem</div>";
                            header('location:'.SITEURL.'admin/add-food.php');

                            // Encerrar o Processo
                            die();
                        }

                    }
                }
                else
                {
                    $image_name = ""; // Definindo o Valor Default em Branco
                }

                // 3. Inserir no Banco de Dados

                // Criar um SQL QUERY para salvar ou Adicionar Comidas
                // Para Valores Numéricos Não tem Necessidade de Colocar aspas simples '' Mas para Strings é Necessário que coloque ''
                $sql2 = "INSERT INTO tbl_food SET 
                    title = '$title',
                    description = '$description',
                    price = $price,
                    image_name = '$image_name',
                    category_id = $category,
                    featured = '$featured',
                    active = '$active'
                ";

                // Executar a QUERY
                $res2 = mysqli_query($conn, $sql2);

                //Verificar se os dados foram Inseridos ou Não              
                // 4. Redirecionar com Mensagem para a Página "manage-food"
                if($res2 == true)
                {
                    // Dados Inceridos Corretamente
                    $_SESSION['add'] = "<div class='success'>Refeição adicionada com sucesso!</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }
                else
                {
                    // ERRO ao Inserir Dados
                    $_SESSION['add'] = "<div class='error'>Erro ao adicionar refeição</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }


            }

        ?>

    </div>
</div>


<?php include('partes/footer.php'); ?>