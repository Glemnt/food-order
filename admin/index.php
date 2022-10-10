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
            <h1>5</h1>
            <br />
            Categorias
        </div>

        <div class="col-4 text-center">
            <h1>5</h1>
            <br />
            Categorias
        </div>

        <div class="col-4 text-center">
            <h1>5</h1>
            <br />
            Categorias
        </div>

        <div class="col-4 text-center">
            <h1>5</h1>
            <br />
            Categorias
        </div>

        <div class="clearfix"></div>

    </div>
</div>
<!-- MAIN Acaba Aqui !-->

<?php include('partes/footer.php') ?>