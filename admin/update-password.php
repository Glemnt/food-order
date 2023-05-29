<?php include('partes/menu.php') ?>

<div class="main">
    <div class="wrapper">
        <h1>Change Password</h1>
        <br><br>

        <?php
        if (isset($_GET['idAdmin'])) 
        {
            $idAdmin = $_GET['idAdmin'];
        }
        ?>

        <form action="" method="POST">

            <table class="tbl-30">
                <tr>
                    <td>Senha Atual: </td>
                    <td>
                        <input type="password" name="senha_atual" placeholder="Senha atual">
                    </td>
                </tr>

                <tr>
                    <td>Nova Senha: </td>
                    <td>
                        <input type="password" name="nova_senha" placeholder="Nova senha">
                    </td>
                </tr>

                <tr>
                    <td>Confirmar Senha: </td>
                    <td>
                        <input type="password" name="confirmacao_nova_senha" placeholder="Confirmar senha">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="idAdmin" value="<?php echo $idAdmin; ?>">
                        <input type="submit" name="submit" value="Mudar Senha" class="btn-dois">
                    </td>
                </tr>
            </table>

        </form>

    </div>
</div>

<?php
// Checar quando o botão de Submit foi clicado ou não
if (isset($_POST['submit'])) 
{
    // echo "Clicked";

    // 1. Pegar os dados do formulário
    $idAdmin = $_POST['idAdmin'];
    $senha_atual = md5($_POST['senha_atual']);
    $nova_senha = md5($_POST['nova_senha']);
    $confirmacao_nova_senha = md5($_POST['confirmacao_nova_senha']);

    // 2. Verificar se o ID de Usuário e Senha atuais Existem ou não
    $sql = "SELECT * FROM tb_admin WHERE idAdmin=$idAdmin AND senha='$senha_atual'";

    // Executar a QUERY
    $res = mysqli_query($conn, $sql);

    if ($res == true) 
    {
        // Verificar se os dados estão disponíveis ou não
        $count = mysqli_num_rows($res);

        if ($count == 1) 
        {
            // Usuário Existe e a Senha pode ser Trocada
            // echo "Usuário Encontrado";

            // Verificar se a Nova senha e confirmar senha são iguais ou não
            if ($nova_senha == $confirmacao_nova_senha) 
            {
                // Atualizar a Senha
                $sql2 = "UPDATE tb_admin SET
                    senha = '$nova_senha'
                    WHERE idAdmin=$idAdmin
                ";

                // Executar a QUERY
                $res2 = mysqli_query($conn, $sql2);

                // Verificar se a QUERY foi executada ou não
                if ($res2 == true) 
                {
                    // Mostrar mensagem de Validação
                    // Redirecionar para "manage-admin" com mensagem de Validação
                    $_SESSION['change-pwd'] = "<div class='success'>Senha atualizada com sucesso. </div>";
                    // Redirecionar o Usuário
                    header('location:' . SITEURL . 'admin/manage-admin.php');
                }
                else 
                {
                    // Mostrar Mensagem de ERRo
                    // Redirecionar para "manage-admin" com mensagem de ERRO
                    $_SESSION['change-pwd'] = "<div class='error'>Falha ao tentar mudar senha. </div>";
                    // Redirecionar o Usuário
                    header('location:' . SITEURL . 'admin/manage-admin.php');
                }
            } 
            else 
            {
                // Redirecionar para "manage-admin" com mensagem e ERRO
                $_SESSION['pwd-not-match'] = "<div class='error'>Senhas não combinam. </div>";
                // Redirecionar o Usuário
                header('location:' . SITEURL . 'admin/manage-admin.php');
            }
        } 
        else 
        {
            // Usuário não Existe, mandar mensagem e redirecionar
            $_SESSION['user-not-found'] = "<div class='error'>Usuário não encontrado. </div>";
            // Redirecionar o Usuário
            header('location:' . SITEURL . 'admin/manage-admin.php');
        }
    }

    // 3. Verificar se a nova senha e confirmar senha são iguais ou não

    // 4. Mudar a senha se todos acima forem VERDADEIROS 
}
?>

<?php include('partes/footer.php') ?>