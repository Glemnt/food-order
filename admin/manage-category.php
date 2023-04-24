<?php include('partes/menu.php'); ?>

<div class="main">
    <div class="wrapper">
        <h1>Manage Category</h1>

        <br /><br />

        <?php

            if (isset($_SESSION['add'])) 
            {
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }

            if (isset($_SESSION['remove'])) 
            {
                echo $_SESSION['remove'];
                unset($_SESSION['remove']);
            }

            if (isset($_SESSION['delete'])) 
            {
                echo $_SESSION['delete'];
                unset($_SESSION['delete']);
            }

            if (isset($_SESSION['no-category-found'])) 
            {
                echo $_SESSION['no-category-found'];
                unset($_SESSION['no-category-found']);
            }

            if (isset($_SESSION['update']))
            {
                echo $_SESSION['update'];
                unset($_SESSION['update']);
            }

            if (isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }

            if (isset($_SESSION['failed-remove']))
            {
                echo $_SESSION['failed-remove'];
                unset($_SESSION['failed-remove']);
            }

        ?>

        <br><br>

                <!-- Botão para adicionar o Admin -->
                <a href="<?php echo SITEURL; ?>admin/add-category.php" class="btn-um">Add category</a>

                <br /><br /><br />

                <table class="tbl-full">
                    <tr>
                        <th>S.N</th>
                        <th>Título</th>
                        <th>Imagem</th>
                        <th>Destaque</th>
                        <th>Ativo</th>
                        <th>Ações</th>
                    </tr>

                    <?php
    // QUERY para pegar todas as categorias do banco
    $sql = "SELECT * FROM categoria_produto";

    // Executar a QUERY
    $res = mysqli_query($conn, $sql);

    // Contar Linhas
    $count = mysqli_num_rows($res);

    // Criar Variável de Número de Serial e definir valor em 1
    $sn = 1;

    // Verificar se tem dados no banco ou não
    if ($count > 0) 
    {
        // Tem dados no banco
        // Pegar os dados e Mostrar
        while ($row = mysqli_fetch_assoc($res)) 
        {
            $idCategorias = $row['idCategorias'];
            $nome = $row['nome'];
            $nome_imagem = $row['nome_imagem'];
            $destaque = $row['destaque'];
            $ativo = $row['ativo'];

            ?>

            <tr>
                <td><?php echo $sn++; ?>. </td>
                <td><?php echo $nome; ?></td>

                <td>

                    <?php 
                        // Verificar se o nome da imagem esta disponivel ou n
                        if($nome_imagem!="")
                        {
                            // Mostrar Imagem
                            ?>

                            <img src="<?php echo SITEURL; ?>images/category/<?php echo $nome_imagem; ?>" width="100px" >

                            <?php
                        }                    
                        else
                        {
                            // Mostrar Mensagem
                            echo "<div class='error'>Imagem não selecionada</div>";
                        }                 
                    ?>

                </td>

                <td><?php echo $destaque; ?></td>
                <td><?php echo $ativo; ?></td>
                <td>
                    <a href="<?php echo SITEURL; ?>admin/update-category.php?idCategorias=<?php echo $idCategorias; ?>" class="btn-dois">Update Category</a>
                    <a href="<?php echo SITEURL; ?>admin/delete-category.php?idCategorias=<?php echo $idCategorias; ?>&image_name=<?php echo $nome_imagem; ?>" class="btn-danger">Delete Category</a>
                </td>
            </tr>

            <?php

        }
    } 
    else 
    {
        // Não tem dados
        // Mostrar mensagem dentro da table
        ?>

        <tr>
            <td colspan="6">
                <div class="error">Nehuma categoria adicionada</div>
            </td>
        </tr>

        <?php
    }
?>



                </table>
            </div>

        </div>

        <?php include('partes/footer.php'); ?>