<?php include('partes/menu.php'); ?>

<div class="main">
    <div class="wrapper">
        <h1>Add Admin</h1>

        <br><br>

        <?php 
            if(isset($_SESSION['add'])) // Verificar se a sessão está definida ou não
            {
                echo $_SESSION['add'];      // Exibir Mensagem de Aviso se Setada
                unset($_SESSION['add']);   // Remover Mensagem de Aviso 
            }
        ?>

        <form action="" method="POST">

            <table class="tbl-30">
                <tr>
                    <td>Nome Completo: </td>
                    <td><input type="text" name="full_name" placeholder="Escreva Seu Nome"></td>
                </tr>

                <tr>
                    <td>Username: </td>
                    <td><input type="text" name="username" placeholder="Seu Usuário"></td>
                </tr>

                <tr>
                    <td>Senha: </td>
                    <td><input type="password" name="password" placeholder="Sua Senha"></td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Admin" class="btn-dois">
                    </td>
                </tr>

            </table>

        </form>
    </div>
</div>

<?php include('partes/footer.php'); ?>

<?php
// Processar o valor de um Formulário e salvar no banco de dados

// Checar quando o botão de Submit foi apertado ou não

if (isset($_POST['submit'])) 
{
    // Botão Clicado
    // echo "Botão Clicado";

    // 1. Pegar os Dados do Formulário
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];
    $password = md5($_POST['password']); // Senha Encriptada com MD5

    // 2. SQL Query para salvar os dados no Banco de Dados
    $sql = "INSERT INTO tbl_admin SET
        full_name = '$full_name',
        username = '$username',
        password = '$password'
    ";

    // 3. Exectando a Query e salvando os Dados no Banco 
    $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

    // 4. Verificando se os Dados (Query sendo executada) estão inseridos ou Não e mostrando uma mensagem apropriada
    if($res==TRUE)
    {
        // Dados Inseridos
        // echo "Dados Inseridos";

        // Criando uma Vaiável de Sessão para exibir a Mensagem
        $_SESSION['add'] = "<div class='success'>Admin adicionado com sucesso!</div>";
       
        // Redirecionar Página para 'manage-admin'
        header("location:".SITEURL.'admin/manage-admin.php');
    }
    else
    {
        // Erro na Inserção de Dados
        // echo "Falha na Inserção de Dados";

        // Criando uma Vaiável de Sessão para exibir a Mensagem
        $_SESSION['add'] = "<div class='error'>Erro ao adicionar admin!</div>";
       
        // Redirecionar Página para 'add-admin'
        header("location:".SITEURL.'admin/add-admin.php');
    }
}

?>