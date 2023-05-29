<?php include('partes/menu.php') ?>

<!-- MAIN Começa Aqui !-->
<div class="main">
    <div class="wrapper">
        <h1>Manage Admin</h1>

        <br />

        <?php
        if (isset($_SESSION['add'])) {
            echo $_SESSION['add'];      // Exibir Mensagem de Aviso
            unset($_SESSION['add']);   // Remover Mensagem de Aviso
        }

        if (isset($_SESSION['delete'])) {
            echo $_SESSION['delete'];
            unset($_SESSION['delete']);
        }


        if (isset($_SESSION['update'])) {
            echo $_SESSION['update'];
            unset($_SESSION['update']);
        }

        if(isset($_SESSION['user-not-found']))
        {
            echo $_SESSION['user-not-found'];
            unset($_SESSION['user-not-found']);
        }

        if(isset($_SESSION['pwd-not-match']))
        {
            echo $_SESSION['pwd-not-match'];
            unset($_SESSION['pwd-not-match']);
        }

        if(isset($_SESSION['change-pwd']))
        {
            echo $_SESSION['change-pwd'];
            unset($_SESSION['change-pwd']);
        }

        ?>

        <br><br><br>

        <!-- Botão para adicionar o Admin -->
        <a href="add-admin.php" class="btn-um">Add Admin</a>

        <br /><br /><br />

        <table class="tbl-full">
            <tr>
                <th>S.N</th>
                <th>Nome Completo</th>
                <th>Username</th>
                <th>Ações</th>
            </tr>


            <?php
            // Query para definir todos os ADM
            $sql = "SELECT * FROM tb_admin";

            // Executar a Query
            $res = mysqli_query($conn, $sql);

            // Verificar se a Query é Executada ou não
            if ($res == TRUE) 
            {
                // Contar Linhas para verificar se tem Dados no Banco ou Não
                $count = mysqli_num_rows($res); // Função para Obter todas as linhas no Banco

                $sn = 1; // Criar uma Variável e Atribuir o valor

                // Verificar o Número de Linhas
                if ($count > 0) 
                {
                    // Temos Dados no Banco de Dados
                    while ($rows = mysqli_fetch_assoc($res)) 
                    {

                        // Usando o Loop do While para conseguir todos os Dados do Banco
                        // O Loop do while vai rodar desde que se tenha Dados no Banco

                        // Obter Dados Individuais
                        $idAdmin = $rows['idAdmin'];
                        $nome = $rows['nome'];
                        $usuario = $rows['usuario'];

                        // Mostrar os Valores na Tabela
            ?>

                        <tr>
                            <td><?php echo $sn++; ?>. </td>
                            <td><?php echo $nome; ?></td>
                            <td><?php echo $usuario; ?></td>
                            <td>
                                <a href="<?php echo SITEURL; ?>admin/update-password.php?idAdmin=<?php echo $idAdmin; ?>" class="btn-um">Chage Password</a>
                                <a href="<?php echo SITEURL; ?>admin/update-admin.php?idAdmin=<?php echo $idAdmin; ?>" class="btn-dois">Update Admin</a>
                                <a href="<?php echo SITEURL; ?>admin/delete-admin.php?idAdmin=<?php echo $idAdmin; ?>" class="btn-danger">Delete Admin</a>
                            </td>
                        </tr>

            <?php

                    }
                } 
                else 
                {
                    // Não temos Dados no Banco de Dados
                }
            }
            ?>

        </table>

    </div>
</div>
<!-- MAIN Acaba Aqui !-->

<?php include('partes/footer.php') ?>