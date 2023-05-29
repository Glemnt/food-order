<?php 
    // Verificar se o id foi passado ou não
    if(isset($_GET['idCategorias']))
    {
        // ID da categoria foi setado, pegar o id
        $idCategorias = $_GET['idCategorias'];

        // Pegar os dados da categoria baseado no ID
        $sql = "SELECT nome, nome_imagem, destaque, ativo FROM categoria_produto WHERE idCategorias=$idCategorias";

        // Executar a query
        $res = mysqli_query($conn, $sql);

        // Pegar o valor do banco de dados
        $row = mysqli_fetch_assoc($res);

        // Pegar os dados da categoria
        $nome = $row['nome'];
        $imagem = $row['nome_imagem'];
        $destaque = $row['destaque'];
        $ativo = $row['ativo'];
    }
    else
    {
        // ID da categoria não foi passado
        // Redirecionar para a HOME PAGE
        header('location:'.SITEURL);
    }
?>


<!-- Pesquisa de comida começa aqui -->
<section class="food-search text-center">
    <div class="container">
        <h3>Comidas em</h3>
        <h1><a href="#" class="text-white">"<?php echo $categoria_produto; ?>"</a></h1>
    </div>
</section>
<!-- Pesquisa de comida acaba aqui -->

<!-- Menu de comidas começa aqui -->
<section class="food-menu">
    <div class="container">
        <h2 class="text-center">Menu</h2>

        <?php
            // Criar um SQL QUERY para puxar Refeições baseadas na sua Categoria
            $sql2 = "SELECT * FROM categoria_produto WHERE idCategorias = $category_id AND ativo = 1 ORDER BY destaque DESC";

            // Executar a QUERY
            $res2 = mysqli_query($conn, $sql2);

            // Contar as Linhas
            $count2 = mysqli_num_rows($res2);

            // Verificar se Refeição esta disponivel ou nao
            if($count2 > 0)
            {
                // Refeição disponivel
                while($row2 = mysqli_fetch_assoc($res2))
                {
                    $idCategorias = $row2['idCategorias'];
                    $nome = $row2['nome'];
                    $image_name = $row2['nome_imagem'];
                    ?>

                    <div class="food-menu-box">
                        <div class="food-menu-img">
                            <?php 
                                if($image_name == "")
                                {
                                    // Imagem não disponvel
                                    echo "<div class='error'>Imagem não disponível</div>";
                                }
                                else
                                {
                                    // Imagem Disponivel
                                    ?>
                                    <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="<?php echo $title; ?>" class="img-responsive img-curve">
                                    <?php
                                }
                            ?>
                        </div>

                        <div class="food-menu-desc">
                            <h4><?php echo $title; ?></h4>
                            <p class="food-price">R$<?php echo $row2['preco']; ?></p>
                            <p class="food-detail">
                                <?php echo $row2['descricao']; ?>
                            </p>
                            <br>
                            <a href="<?php echo SITEURL; ?>order.php?food_id=<?php echo $id; ?>" class="btn btn-primeiro">Order Now</a>
                        </div>
                    </div>

                    <?php
                }
            }
            else
            {
                // Refeição Não disponivel
                echo "<div class='error'>Refeição não disponível</div>";
            }
        ?>

        <div class="clearfix"></div>
    </div>
</section>
<!-- Menu de comidas acaba aqui -->


    <?php include('partes-front/footer.php'); ?>