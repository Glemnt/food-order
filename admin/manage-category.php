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
                        $sql = "SELECT * FROM tbm_category";

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
                                $id = $row['id'];
                                $title = $row['title'];
                                $image_name = $row['image_name'];
                                $featured = $row['featured'];
                                $active = $row['active'];

                                ?>

                                    <tr>
                                        <td><?php echo $sn++; ?>. </td>
                                        <td><?php echo $title; ?></td>

                                        <td>

                                            <?php 
                                                // Verificar se o nome da imagem esta disponivel ou n
                                                if($image_name!="")
                                                {
                                                    // Mostrar Imagem
                                                    ?>

                                                    <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" width="100px" >

                                                    <?php
                                                }                    
                                                else
                                                {
                                                    // Mostrar Mensagem
                                                    echo "<div class='error'>Imagem não selecionada</div>";
                                                }                 
                                            ?>

                                        </td>

                                        <td><?php echo $featured; ?></td>
                                        <td><?php echo $active; ?></td>
                                        <td>
                                            <a href="<?php echo SITEURL; ?>admin/update-category.php?id=<?php echo $id; ?>" class="btn-dois">Update Category</a>
                                            <a href="<?php echo SITEURL; ?>admin/delete-category.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-danger">Delete Category</a>
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