<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../Barra_Navegacion/Bar-style.css">

    <title>Document</title>
</head>
<body>
<header class="header">
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">

    <!-- Navbar del Cliente Modularizada -->

    <?php 
          if($_SESSION["tipoUsuario"] == "Cliente"){
    ?>
            <div class="navbar-style">
                <a class="navbar-brand" href="../Home/Home.php"><img title="Inicio" class="icon" src="../../Imagenes-Videos/bolsas-de-compra.png" alt="Inicio"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse" id="navbarScroll">
                <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
                  <li class="nav-item">
                    <a class="nav-link active locales-active" aria-current="page" href="../Locales/Locales.php">Locales</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="../Promociones/Promociones.php">Promociones</a>
                  </li>
                  <li class="nav-item dropdown">
                    <a class="nav-link active" aria-current="page" href="../Novedades/Novedades.php">Novedades</a>
                  </li>
                  <li class="nav-item dropdown">
                    <a class="nav-link active" aria-current="page" href="../Home/Home.php#About us">Sobre Nosotros</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#Contacto">Contacto</a>
                  </li>
                </ul>
                <form class="d-flex align-items-center form-style" role="search" method="post">
                  <li class="nav-item dropdown list-item">
                    <a class="nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><img class="avatar-style icon" src="../../Imagenes-Videos/avatar.png" alt="Logo de usuario"><?php echo"{$_SESSION['tipoUsuario']}";?></a>
                  </li>
                  <a class="btn btn-outline-danger log_out" href="../../inicio_de_sesion/inicio_sesion.php"><img class="icon cerrar-sesion btn-delete" src="../../Imagenes-Videos/Cerrar-sesion.png" alt="Imagen de puerta para cerrar sesion">Cerrar Sesion</a>
                </form>
            </div>
          </div>
            <?php  
                }
            ?>




    <!-- Navbar del UNR  Modularizada -->

    <?php 
        if($_SESSION["tipoUsuario"] == "UNR"){
          if($_SERVER["PHP_SELF"] == "/Home-UNR/index.php"){
    ?>
              <div class="navbar-style">
                <a class="navbar-brand" href="../Home-UNR/index.php"><img title="Inicio" class="icon" src="../Imagenes-Videos/bolsas-de-compra.png" alt="Inicio"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
              </div>
              <div class="collapse navbar-collapse" id="navbarScroll">
                  <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
                    <li class="nav-item">
                      <a class="nav-link active locales-active" aria-current="page" href="../Client/Locales/Locales.php">Locales</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link active" aria-current="page" href="../Client/Promociones/Promociones.php">Promociones</a>
                    </li>
                    <li class="nav-item dropdown">
                      <a class="nav-link active" aria-current="page" href="../Client/Novedades/Novedades.php">Novedades</a>
                    </li>
                    <li class="nav-item dropdown">
                      <a class="nav-link active" aria-current="page" href="../Home-UNR/index.php#About us">Sobre Nosotros</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link active" aria-current="page" href="#Contacto">Contacto</a>
                    </li>
                  </ul>
                  <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"])   ?>" method="post" class="d-flex align-items-center form-style" role="search">
                      <input class="btn btn-outline-success" name="Iniciar-Sesion" value="Iniciar Sesión" type="submit">
                      <input class="btn btn-outline-success success" name="Registrarse" value="Registrarse" type="submit">
                  </form>
              </div>
            </div>
              <?php
                if(isset($_POST["Iniciar-Sesion"])){
                  header("LOCATION: ../inicio_de_sesion/inicio_sesion.php");
                }
                if(isset($_POST["Registrarse"])){
                  header("LOCATION: ../inicio_de_sesion/sign_up.php");
                }
              ?>
              <?php  
              }
              elseif($_SERVER["PHP_SELF"] == "/Client/Locales/Locales.php" || $_SERVER["PHP_SELF"] == "/Client/Promociones/Promociones.php"){
              ?>
              <div class="navbar-style">
                <a class="navbar-brand" href="../../Home-UNR/index.php"><img title="Inicio" class="icon" src="../../Imagenes-Videos/bolsas-de-compra.png" alt="Inicio"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
              </div>
              <div class="collapse navbar-collapse" id="navbarScroll">
                  <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
                    <li class="nav-item">
                      <a class="nav-link active locales-active" aria-current="page" href="../../Client/Locales/Locales.php">Locales</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link active" aria-current="page" href="../../Client/Promociones/Promociones.php">Promociones</a>
                    </li>
                    <li class="nav-item dropdown">
                      <a class="nav-link active" aria-current="page" href="../../Client/Novedades/Novedades.php">Novedades</a>
                    </li>
                    <li class="nav-item dropdown">
                      <a class="nav-link active" aria-current="page" href="../../Home-UNR/index.php#About us">Sobre Nosotros</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link active" aria-current="page" href="#Contacto">Contacto</a>
                    </li>
                  </ul>
                  <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"])   ?>" method="post" class="d-flex align-items-center form-style" role="search">
                      <input class="btn btn-outline-success" name="Iniciar-Sesion" value="Iniciar Sesión" type="submit">
                      <input class="btn btn-outline-success success" name="Registrarse" value="Registrarse" type="submit">
                  </form>
              </div>
          </div>
              <?php
                if(isset($_POST["Iniciar-Sesion"])){
                  header("LOCATION: ../../inicio_de_sesion/inicio_sesion.php");
                }
                if(isset($_POST["Registrarse"])){
                  header("LOCATION: ../../inicio_de_sesion/sign_up.php");
                }
              ?>
              <?php
              }
              ?>
          <?php
            }
          ?>


    <!-- Navbar del Dueño Modularizada -->

    <?php 
        if($_SESSION["tipoUsuario"] == "Dueño de local"){
    ?>
            <div class="navbar-style">
                <a class="navbar-brand" href="../Home/Home.php"><img title="Inicio" class="icon" src="../../Imagenes-Videos/bolsas-de-compra.png" alt="Inicio"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse" id="navbarScroll">
                <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
                  <li class="nav-item">
                    <a class="nav-link active locales-active" aria-current="page" href="../Promociones/Promociones.php">Promociones</a>
                  </li>
                  <li class="nav-item dropdown">
                    <a class="nav-link active" aria-current="page" href="../Reportes/Reporte-Usos.php">Reportes de Promociones</a>
                  </li>
                </ul>
                <form class="d-flex align-items-center form-style" role="search" method="post">
                  <li class="nav-item dropdown list-item">
                    <a class="nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><img class="avatar-style icon" src="../../Imagenes-Videos/avatar.png" alt="Logo de Usuario"><?php echo"{$_SESSION['tipoUsuario']}";?></a>
                  </li>
                  <a class="btn btn-outline-danger log_out" href="../../inicio_de_sesion/inicio_sesion.php"><img class="icon cerrar-sesion btn-delete" src="../../Imagenes-Videos/Cerrar-sesion.png" alt="Imagen de puerta para cerrar sesion">Cerrar Sesion</a>
                </form>
            </div>
          </div>
            <?php  
              }
            ?> 
        

          <!-- Navbar del Administrador  Modularizada -->

    <?php 
        if($_SESSION["tipoUsuario"] == "Administrador"){
    ?>
                <div class="navbar-style">
                  <a class="navbar-brand" href="../home/home_page_admin.php"><img title="Inicio" class="icon" src="../../Imagenes-Videos/bolsas-de-compra.png" alt="Inicio"></a>
                  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                  </button>
                </div>
                <div class="collapse navbar-collapse" id="navbarScroll">
                  <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
                    <li class="nav-item">
                      <a class="nav-link active" aria-current="page" href="../locales_menu/admin_locales.php">Locales</a>
                    </li>
                    <li class="nav-item dropdown list-item">
                      <a class="nav-link active dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Usuarios</a>
                      <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="../users_menu/admin_users.php">Usuarios Registrados</a></li>
                        <li><a class="dropdown-item" href="../users_menu/admin_owner.php">Validar/Denegar Cuentas de Dueño</a></li>
                      </ul>
                    </li>
                    <li class="nav-item dropdown">
                      <a class="nav-link active" aria-current="page" href="../novedades_menu/admin_nov.php">Novedades</a>
                    </li>
                    <li class="nav-item dropdown list-item">
                      <a class="nav-link active dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Promociones</a>
                      <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="../promociones_menu/admin_lista_promo.php">Promociones Cargadas</a></li>
                        <li><a class="dropdown-item" href="../promociones_menu/admin_promo.php">Aceptar/Rechazar Promociones</a></li>
                      </ul>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link active" aria-current="page" href="../uso_promociones/uso_promo.php">Uso de Promociones</a>
                    </li>
                  </ul>
                  <span class="nav-item dropdown list-item">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><img class="avatar-style icon" src="../../Imagenes-Videos/avatar.png" alt="Logo de usuario">Administrador</a>
                  </span>
                  <a class="btn btn-outline-danger log_out" href="../../inicio_de_sesion/inicio_sesion.php"><img class="icon cerrar-sesion btn-delete" src="../../Imagenes-Videos/Cerrar-sesion.png" alt="Imagen de puerta para cerrar sesion">Cerrar Sesion</a>
                </div>
            </div>
    <?php  
        }
    ?> 
    

    </nav>
  </header> 
</body>
</html>
