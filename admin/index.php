<?php include('partes/menu.php'); ?>

<!-- MAIN Começa Aqui !-->
<div class="main">
    <div class="wrapper">
        <h1>Dashboard</h1>

        <br><br>
        <?php
            if (isset($_SESSION['login'])) 
            {
                echo $_SESSION['login'];
                unset($_SESSION['login']);
            }
        ?>
        <br><br>

        <div class="col-4 text-center">



        <?php  
            // SQL QUERY
            $sql = "SELECT * FROM categoria_produto";
            // Executar a QUERY
            $res = mysqli_query($conn, $sql);
            // Contar as Linhas
            $count = mysqli_num_rows($res);
        ?>

        <h1><?php echo $count; ?></h1>
        <br />
        Categorias

        </div>

        <div class="col-4 text-center">

            <?php  
                // SQL QUERY
                $sql2 = "SELECT * FROM tbl_food";
                // Executar a QUERY
                $res2 = mysqli_query($conn, $sql2);
                // Contar as Linhas
                $count2 = mysqli_num_rows($res2);
            ?>

            <h1><?php echo $count2; ?></h1>
            <br />
            Refeições
        </div>

        <div class="col-4 text-center">

            <?php  
                // SQL QUERY
                $sql3 = "SELECT * FROM tbm_order";
                // Executar a QUERY
                $res3 = mysqli_query($conn, $sql3);
                // Contar as Linhas
                $count3 = mysqli_num_rows($res3);
            ?>

            <h1><?php echo $count3; ?></h1>
            <br />
            Pedidos Totais
        </div>

        <div class="col-4 text-center">

            <?php 
                // Criar SQL QUERY para pegar a Receita Gerada
                // Agregar função no SQL
                $sql4 = "SELECT SUM(total) AS Total FROM tbm_order WHERE status='Entregue'";

                // Executar a QUERY
                $res4 = mysqli_query($conn, $sql4);

                // Pegar o Valor 
                $row4 = mysqli_fetch_assoc($res4);

                // Pegar o valor da Receita total
                $receita_total = $row4['Total'];
            ?>

            <h1> R$ <?php echo $receita_total; ?></h1>
            <br />
            Receita Gerada
        </div>

        <div class="clearfix"></div>

    </div>
</div>
<!-- MAIN Acaba Aqui !-->

<?php include('partes/footer.php') ?>