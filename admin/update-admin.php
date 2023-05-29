<?php include('partes/menu.php'); ?>

<div class="main">
    <div class="wrapper">
        <h1>Update Admin</h1>

        <br><br>

        <?php
        // 1. Pegar o ID do Admin Selecionado
        $id = $_GET['id'];

        // 2. Criar um SQL Query para pegar os Detalhes
        $sql = "SELECT * FROM tbl_admin WHERE id=$id";

        // Executar a Query
        $res = mysqli_query($conn, $sql);

        // Verificar se a Query foi executada ou não
        if ($res == true) {
            // Checar se os dados estão disponíveis ou não
            $count = mysqli_num_rows($res);
            // Checar se tem dados de Admin ou não
            if ($count == 1) {
                // Pegar os Detalhes
                //echo "Admin Disponível";
                $row = mysqli_fetch_assoc($res);

                $full_name = $row['full_name'];
                $username = $row['username'];
            } else {
                // Redirecionar para a Página "manage-admin"
                header('location:' . SITEURL . 'admin/manage-admin.php');
            }
        }

        ?>

        <form action="" method="POST">

            <table class="tbl-30">
                <tr>
                    <td>Nome Completo: </td>
                    <td>
                        <input type="text" name="full_name" value="<?php echo $full_name; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Username: </td>
                    <td>
                        <input type="text" name="username" value="<?php echo $username; ?>">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Admin" class="btn-dois">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php

// Checar Quando o Botão de Submit foi Clicado ou não
if (isset($_POST['submit'])) {
    // echo "Botão Clicado";
    // Pegar todos os valores do formulário para o Update
    $id = $_POST['id'];
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];

    // Criar um SQL Query para dar Update Admin
    $sql = "UPDATE tbl_admin SET
            full_name = '$full_name',
            username = '$username' 
            WHERE id='$id'
            ";

    // Executar a Query
    $res = mysqli_query($conn, $sql);

    // Checar se a Query está sendo executada corretamente ou não
    if ($res == true) 
    {
        // Query Executada e Admin Atualizado
        $_SESSION['update'] = "<div class='success'>Admin atualizado com sucesso!</div>";
        // Redirecionar para a página "manage-admin"
        header('location:'.SITEURL.'admin/manage-admin.php');

    } else 
    {
        // Erro no Update do Admin
        $_SESSION['update'] = "<div class='error'>ERROR ao deletar Admin</div>";
        // Redirecionar para a página "manage-admin"
        header('location:'.SITEURL.'admin/manage-admin.php');
    }
}

?>

<?php include('partes/footer.php'); ?>