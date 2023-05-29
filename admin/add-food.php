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
                        <input type="text" name="nome" placeholder="Nome da Refeição">
                    </td>
                </tr>

                <tr>
                    <td>Descrição: </td>
                    <td>
                        <textarea name="descricao" cols="25" rows="5" placeholder="Descrição da Refeição"></textarea>
                    </td>
                </tr>

                <tr>
                    <td>Preço: </td>
                    <td>
                        <input type="double" name="preco">
                    </td>
                </tr>

                <tr>
                    <td>Selecionar Imagem: </td>
                    <td>
                        <input type="file" name="nome_imagem">
                    </td>
                </tr>

                <tr>
                    <td>Categoria: </td>
                    <td>
                        <select name="categorias">

                            <?php 
                                // Criar código em PHP para mostrar categorias do Banco de Dados
                                // 1. Criar SQL para pegar todas as categorias ativas do Banco
                                $sql = "SELECT * FROM categoria_produto WHERE ativo='Sim'";

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
                                        $idCategorias = $row['idCategorias'];
                                        $nome = $row['nome'];

                                        ?>

                                        <option value="<?php echo $idCategorias; ?>"><?php echo $nome; ?></option>
                                        
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
                        <input type="radio" name="destaque" Value="Sim"> Sim
                        <input type="radio" name="destaque" Value="Nao"> Não
                    </td>
                </tr>

                <tr>
                    <td>Ativo: </td>
                    <td>
                    <input type="radio" name="ativo" Value="Sim"> Sim
                        <input type="radio" name="ativo" Value="Nao"> Não
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
                $nome = $_POST['nome'];
                $descricao = $_POST['descricao'];
                $preco = $_POST['preco'];
                $categorias_produtos_idCategorias = $_POST['categorias'];

                // Verificar quando o radio do "Destaque" e do "Ativo" for Selecionado ou Não
                if(isset($_POST['destaque']))
                {
                    $destaque = $_POST['destaque'];
                }
                else
                {
                    $destaque = "Nao"; // Definindo um valor Default
                }

                if(isset($_POST['ativo']))
                {
                    $ativo = $_POST['ativo'];
                }
                else
                {
                    $ativo = "Nao"; // Definindo um valor Default
                }

                // 2. Dar Upload na Imagem se Selecioada
                // Verificar se o botão "Selecionar Imagem" foi clicado ou Não, e dar upload apenas se a imagem foi selecionada
                if(isset($_FILES['nome_imagem']['name']))
                {
                    // Pegar os Detalhes da Imagem Selecionada
                    $nome_imagem = $_FILES['nome_imagem']['name'];

                    // Verificar se a Imagem foi Selecionada ou Não e Adicionar Apenas se Selecionada
                    if($nome_imagem != "")
                    {
                        // Imagem foi Selecionada
                        // A. Renomear a Imagem
                        // Obter a Extenção da Imagem Selecionada jpg, png, gif, etc..
                        $ext = pathinfo($nome_imagem, PATHINFO_EXTENSION);
                        //$ext = end(explode('.', $image_name));
                        

                        // Definir Novo Nome para a Imagem
                        $nome_imagem = "Produto".rand(0000,9999).".".$ext;

                        // B. Dar Upload na Imagem
                        // Obter o Caminho de Origem e o de Destino

                        // O caminho de Origem é a Localização Atual da Imagem
                        $src = $_FILES['nome_imagem']['tmp_name'];

                        // Caminho de Destino para que a Imagem seja Carregada
                        $dst = "../images/food/".$nome_imagem;

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
                    $nome_imagem = ""; // Definindo o Valor Default em Branco
                }

                // 3. Inserir no Banco de Dados

                // Criar um SQL QUERY para salvar ou Adicionar Comidas
                // Para Valores Numéricos Não tem Necessidade de Colocar aspas simples '' Mas para Strings é Necessário que coloque ''
                $sql2 = "INSERT INTO menu SET 
                    nome = '$nome',
                    descricao = '$descricao',
                    preco = $preco,
                    nome_imagem = '$nome_imagem',
                    categorias_produtos_idCategorias = $categorias_produtos_idCategorias,
                    destaque = '$destaque',
                    ativo = '$ativo'
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