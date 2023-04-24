<?php include('partes/menu.php'); ?>

<div class="main">
    <div class="wrapper">
        <h1>Update Order</h1>
        <br><br>

        <?php 
            // Verificar quando o ID esta setado ou Não
            if(isset($_GET['id']))
            {
                // Pegar os Detalhes do Pedido
                $id = $_GET['id'];

                // Pegar todos os outros detalhes baseado
                // SQL Query para Pegar os Detalhes do Pedido
                $sql = "SELECT * FROM tbm_order WHERE id=$id";

                // Executar a QUERY
                $res = mysqli_query($conn, $sql);

                // Contar as Linhas
                $count = mysqli_num_rows($res);

                if($count == 1)
                {
                    // Detalhes Disponivel
                    $row = mysqli_fetch_assoc($res);

                    $food = $row['food'];
                    $price = $row['price'];
                    $qty = $row['qty'];
                    $status = $row['status'];
                    $customer_name = $row['customer_name'];
                    $customer_contact = $row['customer_contact'];
                    $customer_email = $row['customer_email'];
                    $customer_address = $row['customer_address'];
                }
                else
                {
                    // Detalhes não Disponivel | Redirecionar para a Página 'manage-order'
                    header('location:'.SITEURL.'admin/manage-order.php');
                }
            }
            else
            {
                // Redirecionar para a página 'manage-order'
                header('location:'.SITEURL.'admin/manage-order.php');
            }
        ?> 
        

        <form action="" method="POST">

            <table class="tbl-30">
                <tr>
                    <td>Nome da Refeição</td>
                    <td><b><?php echo $food; ?> </b></td>
                </tr>

                <tr>
                    <td>Preço</td>
                    <td><b> R$ <?php echo $price; ?></b></td>
                </tr>

                <tr>
                    <td>Qty</td>
                    <td>
                        <input type="number" name="qty" value="<?php echo $qty; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Status</td>
                    <td>
                        <select name="status">
                            <option <?php if($status == "Confirmado"){echo "selected";} ?> value="Confirmado">Confirmado</option>
                            <option <?php if($status == "A Caminho"){echo "selected";} ?> value="A Caminho">A Caminho</option>
                            <option <?php if($status == "Entregue"){echo "selected";} ?> value="Entregue">Entregue</option>
                            <option <?php if($status == "Cancelado"){echo "selected";} ?> value="Cancelado">Cancelado</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Nome do Cliente: </td>
                    <td>
                        <input type="text" name="customer_name" value="<?php echo $customer_name; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Contato do Cliente: </td>
                    <td>
                        <input type="text" name="customer_contact" value="<?php echo $customer_contact; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Email do Cliente: </td>
                    <td>
                        <input type="text" name="customer_email" value="<?php echo $customer_email; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Endereço do Cliente: </td>
                    <td>
                        <textarea name="customer_address" cols="30" rows="5"><?php echo $customer_address; ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="price" value="<?php echo $price; ?>">

                        <input type="submit" name="submit" value="Update Order" class="btn-dois">
                    </td>
                </tr>

            </table>

        </form>

        <?php 
        
            // Verificar quando o Botao de update foi clicado ou não
            if(isset($_POST['submit']))
            {
                // echo "Clicado";
                // Pegar todos os Valores do Formulario
                $id = $_POST['id'];
                $price = $_POST['price'];
                $qty = $_POST['qty'];

                $total = $price * $qty;

                $status = $_POST['status'];
                
                $customer_name = $_POST['customer_name'];
                $customer_contact = $_POST['customer_contact'];
                $customer_email = $_POST['customer_email'];
                $customer_address = $_POST['customer_address']; 
                
                // Atualizar os Valores
                $sql2 = "UPDATE tbm_order SET
                    qty = $qty,
                    total = $total,
                    status = '$status',
                    customer_name = '$customer_name',
                    customer_contact = '$customer_contact',
                    customer_email = '$customer_email',
                    customer_address = '$customer_address'
                    WHERE id=$id
                "; 

                // Executar a QUERY
                $res2 = mysqli_query($conn, $sql2);

                // Verificar quando Atualizou ou Não
                // e Redirecionar para a página 'manage-order' com Mensagem
                if($res2 == true)
                {
                    // Atualizou
                    $_SESSION['update'] = "<div class='success'>Pedido atualizado com sucesso!</div>";
                    header('location:'.SITEURL.'admin/manage-order.php');
                }
                else
                {
                    // Não Atualizou
                    $_SESSION['update'] = "<div class='error'>Erro ao atualizar pedido</div>";
                    header('location:'.SITEURL.'admin/manage-order.php');
                }

            }
        
        ?>

    </div>
</div>




<?php include('partes/footer.php'); ?>