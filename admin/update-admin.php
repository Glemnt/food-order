<?php include('partes/menu.php'); ?>

<div class="main">
    <div class="wrapper">
        <h1>Update Admin</h1>

        <br><br>

        <?php
        // 1. Pegar o ID do Admin Selecionado
        $idAdmin = $_GET['idAdmin'];

        // 2. Criar um SQL Query para pegar os Detalhes
        $sql = "SELECT * FROM tb_admin WHERE idAdmin=$idAdmin";

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

                $nome = $row['nome'];
                $usuario = $row['usuario'];
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
                        <input type="text" name="nome" value="<?php echo $nome; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Usuário: </td>
                    <td>
                        <input type="text" name="usuario" value="<?php echo $usuario; ?>">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="idAdmin" value="<?php echo $idAdmin; ?>">
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
    $idAdmin = $_POST['idAdmin'];
    $nome = $_POST['nome'];
    $usuario = $_POST['usuario'];

    // Criar um SQL Query para dar Update Admin
    $sql = "UPDATE tb_admin SET
            nome = '$nome',
            usuario = '$usuario' 
            WHERE idAdmin='$idAdmin'
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