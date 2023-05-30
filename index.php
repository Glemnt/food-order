  <?php include('partes-front/menu.php'); ?>
  
  <!-- Pesquisa de comida começa aqui -->
  <section class="food-search text-center">
    <div class="container">

      <form action="<?php echo SITEURL; ?>food-search.php" method="POST">
        <input type="search" name="search" placeholder="Pesquise seu prato..." />
        <input type="submit" name="submit" value="Pesquisar" class="btn btn-primeiro" />
      </form>
    </div>
  </section>
  <!-- Pesquisa de comida acaba aqui -->

  <?php 
  
    if(isset($_SESSION['order']))
    {
      echo $_SESSION['order'];
      unset($_SESSION['order']);
    }
  
  ?>

  <!-- categorias começa aqui -->
<section class="categorias">
  <div class="container">
    <h2 class="text-center">Categorias</h2>

    <?php 
        // Criar SQL QRERY para Mostrar Categorias do Banco de Dados
        $sql = "SELECT * FROM categoria_produto WHERE ativo='Sim' AND destaque='Sim' LIMIT 3"; 
        // Executar a QUERY
        $res = mysqli_query($conn, $sql);
        // Contar Linhas para Verificar se a Categoria está disponível ou não
        $count = mysqli_num_rows($res);

        if($count > 0)
        {
          // Categoria está disponível
          while($row = mysqli_fetch_assoc($res))
          {
            // Pegar os valores como id, nome, nome_imagem, destaque e ativo
            $idCategorias = $row['idCategorias'];
            $nome = $row['nome'];
            $nome_imagem = $row['nome_imagem'];
            $destaque = $row['destaque'];
            $ativo = $row['ativo'];
            ?>

            <a href="<?php echo SITEURL; ?>categoria-comidas.php?idCategorias=<?php echo $idCategorias; ?>">
                <div class="box-3 float-container">
                    <?php 
                      // Verificar se a Imagem está disponível ou Não
                      if($nome_imagem == "")
                      {
                        // Mostrar Mensagem
                        echo "<div class='error'>Imagem não disponível</div>";
                      }
                      else
                      {
                        // Imagem Disponível
                        ?>

                        <img src="<?php echo SITEURL; ?>images/category/<?php echo $nome_imagem; ?>" alt="Pizza" class="img-responsive img-curve" />

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
          // Categoria não está disponível
          echo "<div class'error'>Não foi possível adicionar categoria</div>";
        }
    ?>


    <div class="clearfix"></div>
  </div>
</section>
<!-- categorias acaba aqui -->





  <!-- Menu de comidas começa aqui -->
  <section class="food-menu">
    <div class="container">
      <h2 class="text-center">Menu de Comidas</h2>

      <?php 
      
          // Pegar as Refeições do Banco de Dados que Estão Ativas e em Destaque
          // SQL QUERY
          $sql2 = "SELECT * FROM tbl_food WHERE active='Sim' AND featured='Sim' LIMIT 6";

          // Executar a QUERY
          $res2 = mysqli_query($conn, $sql2);

          // Contar as Linhas
          $count2 = mysqli_num_rows($res2);

          // Verificar quando a Refeição está Disponivel ou não
          if($count2 > 0)
          {
            // Refeição Disponivel
            while($row = mysqli_fetch_assoc($res2))
            {
              // Pegar todos os Valores
              $id = $row['id'];
              $title = $row['title'];
              $price = $row['price'];
              $description = $row['description'];
              $image_name = $row['image_name'];
              ?>

              <div class="food-menu-box">
                  <div class="food-menu-img">
                      <?php 
                      
                        // Veificar se a Imagem está disponivel ou não
                        if($image_name == "")
                        {
                          // Imagem Não disponivel
                          echo "<div class='error'>Imagem não disponível</div>";
                        }
                        else
                        {
                          // Imagem Disponivel
                          ?>

                          <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="Chicken Hawain Pizza" class="img-responsive img-curve">

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

                      <a href="<?php echo SITEURL; ?>order.php?food_id=<?php echo $id; ?>" class="btn btn-primeiro">Peça Agora</a>
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


    <p class="text-center">
      <a href="#">Ver todas as comidas</a>
    </p>

  </section>
  <!-- Menu de comidas acaba aqui -->

  <?php include('partes-front/footer.php'); ?>