<?php include('partes-front/menu.php'); ?>

    <!-- Pesquisa Começa aqui -->
    <section class="food-search text-center">
        <div class="container">
            
            <form action="<?php echo SITEURL; ?>food-search.php" method="POST">
                <input type="search" name="search" placeholder="Pesquise seu prato..." required>
                <input type="submit" name="submit" value="Pesquisar" class="btn btn-primeiro">
            </form>

        </div>
    </section>
    <!-- Pesquisa acaba aqui -->



    <!-- MENU de comidas começa aqui -->    
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Menu</h2>

            <?php 
            
                // Mostrar Comidas que estão ativas
                $sql = "SELECT * FROM tbl_food WHERE active='Sim'";

                // Executar a QUERY
                $res = mysqli_query($conn, $sql);

                // Contar as Linhas
                $count = mysqli_num_rows($res);

                // Verificar quando as refeições estão disponiveis ou não
                if($count > 0)
                {
                    // Refeição Disponivel
                    while($row=mysqli_fetch_assoc($res))
                    {
                        // Pegar o Valor
                        $idProduto = $row['id'];
                        $nome = $row['title'];
                        $descricao = $row['description'];
                        $preco = $row['price'];
                        $nome_imagem = $row['image_name'];
                        ?>

                        <div class="food-menu-box">
                            <div class="food-menu-img">
                                <?php 
                                    // Verificar se imagem esta disponivel ou não
                                    if($nome_imagem == "")
                                    {
                                        // Imagem Não disponivel
                                        echo "<div class='error'>Imagem não disponível</div>";
                                    }
                                    else
                                    {
                                        // Imagem Disponivel
                                        ?>
                                        <img src="<?php echo SITEURL; ?>images/food/<?php echo $nome_imagem; ?>" alt="Chicke Hawain Pizza" class="img-responsive img-curve">
                                        <?php
                                    }
                                ?>
                                
                            </div>

                            <div class="food-menu-desc">
                                <h4><?php echo $nome; ?></h4>
                                <p class="food-price">R$<?php echo $preco; ?></p>
                                <p class="food-detail">
                                    <?php echo $descricao; ?>
                                </p>
                                <br>

                                <a href="<?php echo SITEURL; ?>order.php?idProduto=<?php echo $idProduto; ?>" class="btn btn-primeiro">Peça Agora</a>
                            </div>
                        </div>

                        <?php
                    }
                }
                else
                {
                    // Refeição Não disponivel
                    echo "<div class='error'>Refeição não encontrada</div>";
                }

            ?>


            <div class="clearfix"></div>

            

        </div>

    </section>
    <!-- Menu de comidas acaba aqui -->

<?php include('partes-front/footer.php'); ?>
