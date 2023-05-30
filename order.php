<?php include('partes-front/menu.php'); ?>

    <?php 
    
        // Verificar quando a refeição esta setada ou não
        if(isset($_GET['food_id']))
        {
            // Pegar o id da Refeição Selecionada
            $idProduto = $_GET['food_id'];

            // Pegar os Detalhes da Refeição Selecionada
            $sql = "SELECT * FROM tbl_food WHERE id=$food_id";

            // Executar a QUEY
            $res = mysqli_query($conn, $sql);

            // Contar as Linhas
            $count = mysqli_num_rows($res);

            // Verificar quando os dados estão disponiveis ou Não
            if($count == 1)
            {
                // Temos Dados
                // Pegar os Dados do Banco
                $row = mysqli_fetch_assoc($res);

                $nome = $row['title'];
                $preco = $row['price'];
                $nome_imagem = $row['image_name'];
            }
            else
            {
                // Refeição nao disponivel
                // Redirecionar para a Home Page
                header('location:'.SITEURL);
            }
        }
        else
        {
            // Redirecionar para a Home Page
            header('location:'.SITEURL);
        }
    
    ?>

    <!-- Pesquisa de comida começa aqui -->
    <section class="food-search">
        <div class="container">
            
            <h2 class="text-center text-white">Falta Pouco!</h2>

            <form action="" method="POST" class="order">
                <fieldset>
                    <legend>Comida Selecionada</legend>

                    <div class="food-menu-img">
                        <?php 
                            // Verificar se a Imagem está Disponivel ou não
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
                        <h3><?php echo $title; ?></h3>
                        <input type="hidden" name="food" value="<?php echo $title; ?>"> 

                        <p class="food-price">R$<?php echo $price; ?></p>
                        <input type="hidden" name="price" value="<?php echo $price; ?>">

                        <div class="order-label">Quantidade</div>
                        <input type="number" name="qty" class="input-responsive" value="1" required>
                        
                    </div>

                </fieldset>
                
                <fieldset>
                    <legend>Informações de Entrega</legend>
                    <div class="order-label">Nome Completo</div>
                    <input type="text" name="full-name" placeholder="Ex. Guilherme Monteiro" class="input-responsive" required>

                    <div class="order-label">Numero de Telefone</div>
                    <input type="tel" name="contact" placeholder="(xx) xxxxx-xxxx" class="input-responsive" required>

                    <div class="order-label">Email</div>
                    <input type="email" name="email" placeholder="meunome@exemplo.com" class="input-responsive" required>

                    <div class="order-label">Endereço</div>
                    <textarea name="address" rows="10" placeholder="Ex. Rua, Cidade, País..." class="input-responsive" required></textarea>

                    <input type="submit" name="submit" value="Confirmar Compra" class="btn btn-primeiro">
                </fieldset>

            </form>

            <?php 
            
                // Verificar quando o Botão de Submit foi clicado Ou não
                if(isset($_POST['submit']))
                {
                    // Pegar todos os detalhes do Formulário
                    $food = $_POST['food'];
                    $price = $_POST['price'];
                    $qty = $_POST['qty'];

                    $total = $price * $qty;  // Total = Preço x Quantidade

                    $order_date = date('Y-m-d h:i:sa');  // Data do Pedido

                    $status = "Confirmado";  // Confirmado, A Caminho, Entregue, Cancelado

                    $customer_name = $_POST['full-name'];
                    $customer_contact = $_POST['contact'];
                    $customer_email = $_POST['email'];
                    $customer_address = $_POST['address'];

                    // Salvar o Pedido no Banco de Dados
                    // Criar SQL para Salvar os Dados
                    $sql2 = "INSERT INTO tbm_order SET 
                        food = '$food',
                        price = $price,
                        qty = $qty,
                        total = $total,
                        order_date = '$order_date',
                        status = '$status',
                        customer_name = '$customer_name',
                        customer_contact = '$customer_contact',
                        customer_email = '$customer_email',
                        customer_address = '$customer_address'
                    ";

                    // echo $sql2; die();  

                    // Executar a QUERY
                    $res2 = mysqli_query($conn, $sql2);

                    // Verificar se a QUERY foi executada com Sucesso ou Não
                    if($res2 == true)
                    {
                        // QUERY executada e pedido SEtado
                        $_SESSION['order'] = "<div class='success text-center'>Pedido confirmado!</div>";
                        header('location:'.SITEURL);
                    }
                    else
                    {
                        // ERRO ao Salvar Pedido
                        $_SESSION['order'] = "<div class='error text-center'>Erro ao confirmar pedido</div>";
                        header('location:'.SITEURL);
                    }
                }
            
            ?>

        </div>
    </section>
   <!-- Pesquisa de comida acaba aqui -->

<?php include('partes-front/footer.php'); ?>
