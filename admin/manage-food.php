<?php include('partes/menu.php'); ?>

<div class="main">
    <div class="wrapper">
        <h1>Manage Food</h1>

        <br /><br />

        <!-- Botão para adicionar o Admin -->
        <a href="<?php echo SITEURL; ?>admin/add-food.php" class="btn-um">Add Food</a>

        <br /><br /><br />

        <?php 
            if(isset($_SESSION['add']))
            {
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }

            if(isset($_SESSION['delete']))
            {
                echo $_SESSION['delete'];
                unset($_SESSION['delete']);
            }

            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }

            if(isset($_SESSION['unauthorize']))
            {
                echo $_SESSION['unauthorize'];
                unset($_SESSION['unauthorize']);
            }

            if(isset($_SESSION['update']))
            {
                echo $_SESSION['update'];
                unset($_SESSION['update']);
            }

        ?>

                <table class="tbl-full">
                    <tr>
                        <th>S.N</th>
                        <th>Título</th>
                        <th>Preço</th>
                        <th>Imagem</th>
                        <th>Destaque</th>
                        <th>Ativo</th>
                        <th>Ações</th>
                    </tr>

                    <?php 

                        // Criar SQL Query para Pegar todas as Refeições
                        $sql = "SELECT * FROM menu";

                        // Executar a QUERY
                        $res = mysqli_query($conn, $sql);

                        // Contar as Linhas para Verificar se tem Refeição ou Não
                        $count = mysqli_num_rows($res);

                        // Criar uma Variável de Número de Serial e Definir um valor Defalt
                        $sn = 1;

                        if($count > 0)
                        {
                            // Tem Refeição no Banco de Dados
                            // Exibir a Refeição do Banco de Dados
                            while($row = mysqli_fetch_assoc($res))
                            {
                                // Pegar os Valores de Colunas Individuais
                                $idProduto = $row['idProduto'];
                                $nome = $row['nome'];
                                $preco = $row['preco'];
                                $nome_imagem = $row['nome_imagem'];
                                $destaque = $row['destaque'];
                                $ativo = $row['ativo'];
                                ?>

                                <tr>
                                    <td><?php echo $sn++; ?>. </td>
                                    <td><?php echo $nome; ?></td>
                                    <td>R$<?php echo $preco; ?></td>
                                    <td>
                                        <?php  
                                            // Verificar Quando se Tem Imagem ou Não
                                            if($nome_imagem == "")
                                            {
                                                // Não Temos Imagem, Mostrar Mensagem de ERROR
                                                echo "<div class='error'>Imagem não adicionada</div>";
                                            }
                                            else
                                            {
                                                // Temos Imagem, Mostrar Imagem
                                                ?>
                                                <img src="<?php echo SITEURL; ?>images/food/<?php echo $nome_imagem; ?>" width = "100px">
                                                <?php
                                            }
                                        ?>
                                    </td>
                                    <td><?php echo $destaque; ?></td>
                                    <td><?php echo $ativo; ?></td>
                                    <td>
                                        <a href="<?php echo SITEURL; ?>admin/update-food.php?idProduto=<?php echo $idProduto; ?>" class="btn-dois">Update Food</a>
                                        <a href="<?php echo SITEURL; ?>admin/delete-food.php?idProduto=<?php echo $idProduto; ?>&nome_imagem=<?php echo $nome_imagem; ?>" class="btn-danger">Delete Food</a>
                                    </td>
                                </tr>

                                <?php
                            }
                        }
                        else
                        {
                            // Refeição Não Adicionada no Banco de Dados
                            echo "<tr> <td colspan='7' class='error'> Refeição não adicionada </td> </tr>";
                        }

                    ?>

                </table>
    </div>

</div>

<?php include('partes/footer.php'); ?>