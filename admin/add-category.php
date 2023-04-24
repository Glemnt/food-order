<?php include('partes/menu.php'); ?>

<div class="main">
    <div class="wrapper">
        <h1>Adicionar Categoria</h1>

        <br><br>

        <?php
            if(isset($_SESSION['add'])){
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }

            if(isset($_SESSION['upload'])){
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
        ?>

        <br><br>

        <!-- Formulário de adicionar categoria -->
        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">
                <tr>
                    <td>Título: </td>
                    <td>
                        <input type="text" name="nome" placeholder="Título da Categoria">
                    </td>
                </tr>

                <tr>
                    <td>Selecionar Imagem: </td>
                    <td>
                        <input type="file" name="nome_imagem">
                    </td>
                </tr>

                <tr>
                    <td>Destaque: </td>
                    <td>
                        <input type="radio" name="destaque" value="1"> Sim
                        <input type="radio" name="destaque" value="0" checked> Não
                    </td>
                </tr>

                <tr>
                    <td>Ativo: </td>
                    <td>
                        <input type="radio" name="ativo" value="1" checked> Sim
                        <input type="radio" name="ativo" value="0"> Não
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Adicionar Categoria" class="btn-dois">
                    </td>
                </tr>

            </table>

        </form>
        <!-- Formulário de adicionar categoria termina aqui -->

        <?php
            // Verificar se o botão submit foi clicado
            if (isset($_POST['submit'])) {
                // Pegar o valor do formulário de Categoria
                $nome = $_POST['nome'];

                // Verificar se a imagem foi selecionada
                if (isset($_FILES['nome_imagem']['nome'])) {
                    // Upload da Imagem
                    // Para fazer upload da imagem, precisamos do nome da imagem, caminho de origem e destino 
                    $nome_imagem = $_FILES['nome_imagem']['nome'];

                    // Verificar se o nome da imagem não está vazio
                    if ($nome_imagem != "") { 
                        // Renomear a Imagem
                        $extensao = end(explode('.', $nome_imagem));
                        $nome_imagem = "Food_Category_".rand(000, 999).'.'.$extensao; 

                        $caminho_origem = $_FILES['nome_imagem']['tmp_name'];
                        $caminho_destino = "../images/category/".$nome_imagem;

                        // Upload da Imagem
                        $upload = move_uploaded_file($caminho_origem, $caminho_destino);

                        // Verificar se a imagem foi adicionada ou não
                        // Se a imagem não for adicionada, o processo é encerrado e a página é redirecionada com uma mensagem de erro
                        if ($upload == false) {
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
                    $nome_imagem = "";
                }

                // 2. Criar a SQL Query para Inserir Categoria no Banco de Dados
                $sql = "INSERT INTO categoria_produto SET
                            nome = '$nome',
                            nome_imagem = '$nome_imagem',
                            destaque = '$destaque',
                            ativo = '$ativo'
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