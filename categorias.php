<?php include('partes-front/menu.php'); ?>

<!-- categorias começa aqui -->
<section class="categorias">
    <div class="container">
        <h2 class="text-center">Por Categoria</h2>

        <?php  
            // Mostar todas as Categorias que estão ativas  
            // SQL QUERY
            $sql = "SELECT * FROM categoria_produto WHERE ativo='Sim'";

            // Executar a QUERY
            $res = mysqli_query($conn, $sql);

            // Contar as Linhas
            $count = mysqli_num_rows($res);

            // Verificar se a Categorias está disponível ou não
            if($count > 0)
            {
                // Categoria Disponivel
                while($row = mysqli_fetch_assoc($res))
                {
                    // Pegar os Valores
                    $idCategorias = $row['idCategorias'];
                    $nome = $row['nome'];
                    $nome_imagem = $row['nome_imagem'];
                    $destaque = $row['destaque'];
                    $ativo = $row['ativo'];
                    ?>

                    <a href="<?php echo SITEURL; ?>categoria-comidas.php?category_id=<?php echo $idCategorias; ?>">
                        <div class="box-3 float-container">
                            <?php 
                                if($nome_imagem == "")
                                {
                                    // Imagem Não disponivel
                                    echo "<div class='error'>Imagem não encontrada</div>";
                                }
                                else
                                {
                                    // Imagem Disponivel
                                    ?>
                                    
                                    <img src="<?php echo SITEURL; ?>images/category/<?php echo $nome_imagem; ?>" alt="<?php echo $nome; ?>" class="img-responsive img-curve">

                                    <?php
                                }
                            ?>

                            <h3 class="float-text text-white"><?php echo $nome; ?></h3>
                        </div>
                    </a>

                    <?php
                }
            }
            else
            {
                // Categoria Não disponivel
                echo "<div class='error'>Categoria não encontrada</div>";
            }

        ?>

        <div class="clearfix"></div>
    </div>
</section>
<!-- categorias acaba aqui -->

<?php include('partes-front/footer.php'); ?>
