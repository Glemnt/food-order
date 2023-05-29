<?php include('partes/menu.php'); ?>

<div class="main-content">
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

        <!-- Adicionar inícios de formulário de categoria -->
        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">
                <tr>
                    <td>nome: </td>
                    <td>
                        <input type="text" name="nome" placeholder="Nome da categoria">
                    </td>
                </tr>

                <tr>
                    <td>Selecionar imagem: </td>
                    <td>
                        <input type="file" name="nome_imagem">
                    </td>
                </tr>

                <tr>
                    <td>Destaque: </td>
                    <td>
                        <input type="radio" name="destaque" value="Sim"> Sim 
                        <input type="radio" name="destaque" value="Nao"> Não 
                    </td>
                </tr>

                <tr>
                    <td>Ativo: </td>
                    <td>
                        <input type="radio" name="ativo" value="Sim"> Sim 
                        <input type="radio" name="ativo" value="Nao"> Não 
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Adicionar Categoria" class="btn-secondary">
                    </td>
                </tr>

            </table>

        </form>
        <!-- Adicionar fim de formulário de categoria -->

        <?php 
        
            //Verifica se o botão Enviar foi clicado ou não
            if(isset($_POST['submit']))
            {
                //echo "Cliquei";

                //1. Obter o valor do formulário CAtegory
                $nome = $_POST['nome'];

                //Para entrada de rádio, precisamos verificar se o botão está selecionado ou não
                if(isset($_POST['destaque']))
                {
                    //Obtém o valor do formulário
                    $destaque = $_POST['destaque'];
                }
                else
                {
                    //Define o valor padrão
                    $destaque = "Nao";
                }

                if(isset($_POST['ativo']))
                {
                    $ativo = $_POST['ativo'];
                }
                else
                {
                    $ativo = "Nao";
                }

                //Verifique se a imagem está selecionada ou não e defina o valor para o nome da imagem de acordo
                //print_r($_FILES['imagem']);

                //die();//quebre o código aqui

                if(isset($_FILES['nome_imagem']['name']))
                {
                    //Envia a imagem
                    //Para carregar a imagem, precisamos do nome da imagem, caminho de origem e caminho de destino
                    $nome_imagem = $_FILES['nome_imagem']['name'];
                    
                    // Carrega a imagem somente se a imagem for selecionada
                    if($nome_imagem != "")
                    {

                        //Auto renomear nossa imagem
                        //Obter a extensão da nossa imagem (jpg, png, gif, etc) por ex. "comida especial1.jpg"

                        $ext = pathinfo($nome_imagem, PATHINFO_EXTENSION);
                        //$ext = end(explode('.', $image_name));

                        //Renomear a imagem
                        $nome_imagem = "Categoria_".rand(000, 999).'.'.$ext; // e.g. Food_Category_834.jpg
                        

                        $source_path = $_FILES['nome_imagem']['tmp_name'];

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
                            header('location:'.SITEURL.'admin/add-category.php');
                            //parar o processo
                            die();
                        }

                    }
                }
                else
                {
                   //Não faça upload de imagem e defina o valor image_name como em branco
                    $nome_imagem="";
                }

                //2. Criar consulta SQL para inserir CAtegory no banco de dados
                $sql = "INSERT INTO categoria_produto SET 
                    nome='$nome',
                    nome_imagem='$nome_imagem',
                    destaque='$destaque',
                    ativo='$ativo'
                ";

                //3. Execute a consulta e salve no banco de dados
                $res = mysqli_query($conn, $sql);

                //4. Verifique se a consulta foi executada ou não e os dados adicionados ou não
                if($res==true)
                {
                    //Consulta executada e categoria adicionada
                    $_SESSION['add'] = "<div class='success'>Categoria adicionada com sucesso.</div>";
                    //Redirecionar para Gerenciar Página de Categoria
                    header('location:'.SITEURL.'admin/manage-category.php');
                }
                else
                {
                    //Falha ao adicionar categoria
                    $_SESSION['add'] = "<div class='error'>Erro ao adicionar categoria.</div>";
                    //Redirecionar para Gerenciar Página de Categoria
                    header('location:'.SITEURL.'admin/add-category.php');
                }
            }
        
        ?>

    </div>
</div>

<?php include('partes/footer.php'); ?>