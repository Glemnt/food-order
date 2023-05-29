<?php include('partes/menu.php'); ?>

<div class="main">
    <div class="wrapper">
        <h1>Manage Order</h1>

        <br /><br /><br />

        <?php 
        
            if(isset($_SESSION['update']))
            {
                echo $_SESSION['update'];
                unset($_SESSION['update']);
            }

        ?>
        <br><br>

        <table class="tbl-full">
            <tr>
                <th>S.N</th>
                <th>Refeição</th>
                <th>Preço</th>
                <th>Qty.</th>
                <th>Total</th>
                <th>Data do Pedido</th>
                <th>Status</th>
                <th>Nome do Cliente</th>
                <th>Contato do Cliente</th>
                <th>Email</th>
                <th>Endereço</th>
                <th>Ações</th>
            </tr>

            <?php 
                // Pegar todos os Pedidos do Banco de Dados
                $sql = "SELECT * FROM tbm_order ORDER BY id DESC"; // Mostrar o Pedido Mais Antigo Primeiro
                // Executar a QUERY
                $res = mysqli_query($conn, $sql);
                // Contar as Linhas
                $count = mysqli_num_rows($res);

                $sn = 1;  // Criar um Número de Serial e definir o seu numero inicial = a 1
                
                if($count > 0)
                {
                    // Pedido Desponivel
                    while($row = mysqli_fetch_assoc($res))
                    {
                        // Pegar todos os detalhes dos pedidos
                        $id = $row['id'];
                        $food = $row['food'];
                        $price = $row['price'];
                        $qty = $row['qty'];
                        $total = $row['total'];
                        $order_date = $row['order_date'];
                        $status = $row['status'];
                        $customer_name = $row['customer_name'];
                        $customer_contact = $row['customer_contact'];
                        $customer_email = $row['customer_email'];
                        $customer_address = $row['customer_address'];

                        ?>
                            <tr>
                                <td><?php echo $sn++; ?>. </td>
                                <td><?php echo $food; ?></td>
                                <td><?php echo $price; ?></td>
                                <td><?php echo $qty; ?></td>
                                <td><?php echo $total; ?></td>
                                <td><?php echo $order_date; ?></td>

                                <td>
                                    <?php 
                                        // Confirmado | A Caminho | Entregue | Cancelado
                                        if($status == "Confirmado")
                                        {
                                            echo "<label>$status</label>";
                                        }
                                        elseif($status == "A Caminho")
                                        {
                                            echo "<label style='color: orange;'>$status</label>"; 
                                        }
                                        elseif($status == "Entregue")
                                        {
                                            echo "<label style='color: green;'>$status</label>"; 
                                        }
                                        elseif($status == "Cancelado")
                                        {
                                            echo "<label style='color: red;'>$status</label>"; 
                                        }
                                    ?>
                                </td>

                                <td><?php echo $customer_name; ?></td>
                                <td><?php echo $customer_contact; ?></td>
                                <td><?php echo $customer_email; ?></td>
                                <td><?php echo $customer_address; ?></td>
                                <td>
                                    <a href="<?php echo SITEURL; ?>admin/update-order.php?id=<?php echo $id; ?>" class="btn-dois">Update Order</a>
                                    
                                </td>
                            </tr>
                        <?php

                    }
                }
                else
                {
                    // Pedido Não Disponivel
                    echo "<tr><td colspan='12' class='error'>Pedidos não disponíveis</td></tr>";
                }
            ?>

            

        </table>
    </div>

</div>

<?php include('partes/footer.php'); ?>