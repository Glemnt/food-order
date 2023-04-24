<?php include('config/constantes.php'); ?>

<!DOCTYPE html>
<html>

<head>
  <title>Restaurante</title>
  <meta charset="UTF-8" />
  <!-- Importante para fazer o site responsivo -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- Linkagem -->
  <link rel="stylesheet" href="css/style.css" />
</head>

<body>
  <!-- Nav bar começa aqui -->
  <section class="navBar">
    <div class="container">
      <div class="logo">
        <a href="<?php echo SITEURL; ?>" title="Logo">
          <img src="images/logo2.png" alt="Logo Restaurante" class="img-responsive" />
        </a>
      </div>

      <div class="menu text-right">
        <ul>
          <li>
            <a href="<?php echo SITEURL; ?>">Home</a>
          </li>
          <li>
            <a href="<?php echo SITEURL; ?>categorias.php">Categorias</a>
          </li>
          <li>
            <a href="<?php echo SITEURL; ?>comidas.php">Comidas</a>
          </li>
          <li>
            <a href="#">Contato</a>
          </li>
          <li>
            <a href="<?php echo SITEURL; ?>admin/login.php">Adm Login</a>
          </li>
        </ul>
      </div>

      <div class="clearfix"></div>
    </div>
  </section>
  <!-- Nav bar acaba aqui -->