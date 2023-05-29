<?php include('partes/menu.php'); ?>

<div class="main">
    <div class="wrapper">
        <h1>Update Food</h1>

        <br><br>

        <?php

        // Verificar se o id está setado ou Não
        if (isset($_GET['idProduto'])) {
            // Pegar o id e todos os outros detalhes
            // echo "Getting the data";
            $idProduto = $_GET['idProduto'];
            // Criar SQL Query para pegar os outros Detalhes
            $sql2 = "SELECT * FROM menu WHERE idProduto=$idProduto";

            // Executar a Query
            $res2 = mysqli_query($conn, $sql2);

            // Contar as linhas para Verificar se o id é válido ou Não
            $count = mysqli_num_rows($res2);

            if ($count == 1) {
                // Pegar todos os Dados
                $row2 = mysqli_fetch_assoc($res2);
                $nome = $row2['nome'];
                $descricao = $row2['descricao'];
                $preco = $row2['preco'];
                $imagem_atual = $row2['nome_imagem'];
                $categorias_produtos_idCategorias = $row2['categorias_produtos_idCategorias'];
                $destaque = $row2['destaque'];
                $ativo = $row2['ativo'];
            } else {
                // Redirecionar para a página "manage-category" com mensagem
                $_SESSION['no-food-found'] = "<div class='error'>Refeição não encontrada</div>";
                header('location:' . SITEURL . 'admin/manage-food.php');
                die();
            }

        } else {
            // Redirecionar para a página "manage-category"
            header('location:' . SITEURL . 'admin/manage-food.php');
            die();
        }


        ?>

        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">

                <tr>
                    <td>Título: </td>
                    <td>
                        <input type="text" name="nome" value="<?php echo $nome; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Descrição: </td>
                    <td>
                        <textarea name="descricao" cols="30" rows="5"><?php echo $descricao; ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td>Preço: </td>
                    <td>
                        <input type="number" name="preco" value="<?php echo $preco; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Imagem atual: </td>
                    <td>
                        <?php
                        if ($imagem_atual == "") {
                            // Imagem não disponivel 
                            echo "<div class='error'>Imagem não disponível</div>";
                        } else {
                            // Imagem Disponivel
                            ?>
                            <img src="<?php echo SITEURL; ?>images/food/<?php echo $imagem_atual; ?>" width="150px">
                            <?php
                        }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>Selecionar nova imagem: </td>
                    <td>
                        <input type="file" name="nova_imagem">
                    </td>
                </tr>

                <tr>
                    <td>Categoria: </td>
                    <td>
                        <select name="categorias_produtos_idCategorias">

                            <?php
                            // Query para deixar categorias ativas
                            $sql = "SELECT * FROM categoria_produto WHERE ativo='Sim'";
                            // Executar a query
                            $res = mysqli_query($conn, $sql);
                            // Contar as linhas
                            $count = mysqli_num_rows($res);

                            // Verificar quando a categoria está disponivel ou não 
                            if ($count > 0) {
                                // Categoria disponível
                                while ($row = mysqli_fetch_assoc($res)) {
                                    $nome_categoria = $row['nome'];
                                    $idCategorias = $row['idCategorias'];

                                    // echo "<option value='$category_id'>$category_title</option>";  **Também pode ser Utilizado**
                                    ?>
                                    <option <?php if ($categorias_produtos_idCategorias == $idCategorias) {
                                        echo "selected";
                                    } ?>
                                        value="<?php echo $idCategorias; ?>"><?php echo $nome_categoria; ?></option>
                                    <?php

                                }
                            } else {
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
                        <input <?php if ($destaque == "Sim") {
                            echo "checked";
                        } ?> type="radio" name="destaque" value="Sim">
                        Sim

                        <input <?php if ($destaque == "Nao") {
                            echo "checked";
                        } ?> type="radio" name="destaque" value="Nao">
                        Não
                    </td>
                </tr>

                <tr>
                    <td>Ativo: </td>
                    <td>
                        <input <?php if ($ativo == "Sim") {
                            echo "checked";
                        } ?> type="radio" name="ativo" value="Sim"> Sim

                        <input <?php if ($ativo == "Nao") {
                            echo "checked";
                        } ?> type="radio" name="ativo" value="Nao"> Não
                    </td>
                </tr>

                <tr>
                    <td>
                        <input type="hidden" name="imagem_atual" value="<?php echo $imagem_atual; ?>">
                        <input type="hidden" name="idProduto" value="<?php echo $idProduto; ?>">
                        <input type="submit" name="submit" value="Update Food" class="btn-dois">
                    </td>
                </tr>

            </table>

        </form>

        <?php

        if (isset($_POST['submit'])) {
            // echo "Clicked";
            // 1. Pegar todos os valores do formulário
            $idProduto = $_POST['idProduto'];
            $nome = $_POST['nome'];
            $descricao = $_POST['descricao'];
            $preco = $_POST['preco'];
            $imagem_atual = $_POST['imagem_atual'];
            $categorias_produtos_idCategorias = $_POST['categorias_produtos_idCategorias'];
            $destaque = $_POST['destaque'];
            $ativo = $_POST['ativo'];

            // 2. Dar Upload em uma nova imagem se selecionada
            // Verificar quando a imagem foi selecionada ou não
            if (isset($_FILES['nova_imagem']['name'])) {
                // Pegar os detalhes da imagem
                $nome_imagem = $_FILES['nova_imagem']['name'];

                // Verificar se a imagem está disponível ou não
                if ($nome_imagem != "") {
                    // Imagem Disponível
                    // A. Dar Upload na nova Imagem
        
                    // Auto Renomear Imagem
                    // Verificar a extenção da imagem (jpg, png, gif, etc..) e.g. "specialfood1.jpg"
                    $ext = pathinfo($nome_imagem, PATHINFO_EXTENSION);
                    //$ext = end(explode('.', $image_name));
        
                    // Renomear a Imagem
                    $nome_imagem = "Produto_" . rand(000, 999) . '.' . $ext; // e.g. "Food_Category_834.jpg
        
                    $src_path = $_FILES['nova_imagem']['tmp_name'];

                    $dest_path = "../images/food/" . $nome_imagem;

                    // Upload Imagem
                    $upload = move_uploaded_file($src_path, $dest_path);

                    // Verificar se a Imagem foi Adicionada ou Não
                    // e se a imagem não foi adicionada irá encerrar o processo e redirecionar com msg de ERRO
                    if ($upload == false) {
                        // Definir Mensagem
                        $_SESSION['upload'] = "<div class='error'>Erro ao dar Upload na imagem</div>";
                        // Redirecionar para a página "manage-category"
                        header('location:' . SITEURL . 'admin/manage-food.php');
                        // Parar o Processo 
                        die();
                    }

                    // B. Remover a Imagem Atual se Disponível
                    if ($imagem_atual != "") {
                        $remove_path = "../images/food/" . $imagem_atual;

                        $remove = unlink($remove_path);

                        // Verificar quando a imagem foi removida ou não
                        // Se tiver ERRO para remover a imagem então exibir mensagem e encerrar o processo
                        if ($remove == false) {
                            // ERROR ao remover imagem
                            $_SESSION['failed-remove'] = "<div class='error'>Erro ao remover imagem atual</div>";
                            header('location:' . SITEURL . 'admin/manage-food.php');
                            die(); // Encerrar o processo 
                        }
                    }

                } else {
                    $nome_imagem = $imagem_atual;
                }
            } else {
                $nome_imagem = $imagem_atual;
            }

            // 3. Dar Update no Banco de Dados
            $sql3 = "UPDATE menu SET 
                    nome = '$nome',
                    descricao = '$descricao',
                    preco = $preco,
                    nome_imagem = '$nome_imagem',
                    categorias_produtos_idCategorias = $categorias_produtos_idCategorias,
                    destaque = '$destaque',
                    ativo = '$ativo'
                    WHERE idProduto = $idProduto
                ";

            // Executar a QUERY
            $res3 = mysqli_query($conn, $sql3);

            // 4. Redirecionar para a página "manage category" com Mensagem
            // Verificar quando executado ou não
            if ($res3 == true) {
                // Categoria Atualizada
                $_SESSION['update'] = "<div class='success'>Refeição atualizada com sucesso!</div>";
                header('location:' . SITEURL . 'admin/manage-food.php');

            } else {
                // ERRO ao Atualizar Categoria
                $_SESSION['update'] = "<div class='error'>Erro ao atualizar Refeição</div>";
                header('location:' . SITEURL . 'admin/manage-food.php');
            }

        }

        ?>

    </div>
</div>

<?php include('partes/footer.php'); ?>