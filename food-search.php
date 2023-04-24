<?php include('partes-front/menu.php'); ?>

    <!-- Pesquisa de comida começa aqui -->
    <section class="food-search text-center">
        <div class="container">

        <?php 
        
            // Pegar o Texto escrito na barra de pesquisa
            // $search = $_POST['search']; 
            $search = mysqli_real_escape_string($conn, $_POST['search']); // Para proteger contra SQL Injection
        
        ?>
            
            <h3>Comida Pesquisada</h3> <h1><a href="#" class="text-white">"<?php echo $search; ?>"</a></h1>

        </div>
    </section>
    <!-- Pesquisa de comida acaba aqui -->

    

    <!-- Menu de comidas começa aqui -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Menu</h2>

            <?php  

                // SQL QUERY para Encontrar a Refeição baseada no que foi Digitado na Caixa De Pesquisa
                // $search = burguer '; DROP database name;
                // "SELECT * FROM tbl_food WHERE title LIKE '%burger'%' OR description LIKE '%burger'%';
                $sql = "SELECT * FROM tbl_food WHERE title LIKE '%$search%' OR description LIKE '%$search%'";

                // Executar a QUERY
                $res = mysqli_query($conn, $sql);

                // Contar as linhas
                $count = mysqli_num_rows($res);

                // Verificar se a Refeição está Disponivel ou Nao
                if($count > 0)
                {
                    // Refeição Disponivel
                    while($row = mysqli_fetch_assoc($res))
                    {
                        // Pegar os Detalhes
                        $id = $row['id'];
                        $title = $row['title'];
                        $price = $row['price'];
                        $description = $row['description'];
                        $image_name = $row['image_name'];
                        ?>

                        <div class="food-menu-box">
                            <div class="food-menu-img">
                                <?php 
                                    // Verificar se o nome da imagem está disponivel ou não
                                    if($image_name == "")
                                    {
                                        // Imagem Não Disponivel
                                        echo "<div class='error'>Imagem não disponível</div>";
                                    }
                                    else
                                    {
                                        // Imagem Disponivel
                                        ?>
                                        <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="Chicke Hawain Pizza" class="img-responsive img-curve">
                                        <?php
                                    }
                                ?>
                                
                            </div>

                            <div class="food-menu-desc">
                                <h4><?php echo $title; ?></h4>
                                <p class="food-price">R$<?php echo $price; ?></p>
                                <p class="food-detail">
                                    <?php echo $description; ?>
                                </p>
                                <br>

                                <a href="#" class="btn btn-primeiro">Order Now</a>
                            </div>
                        </div>

                        <?php

                    }
                }
                else
                {
                    // Refeição Não Disponivel
                echo "<div class='error'>Refeição não disponível</div>";
                }
            
            ?>


            <div class="clearfix"></div>

            

        </div>

    </section>
    <!-- Menu de comidas acaba aqui -->

<?php include('partes-front/footer.php'); ?>