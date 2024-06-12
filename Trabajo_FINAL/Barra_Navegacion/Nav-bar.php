<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                <a class="navbar-brand" href="../Home/Home.php"><img class="icon" src="../../Imagenes-Videos/bolsas-de-compra.png" alt="Icono"></a>
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
                    <a class="nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><img class="avatar-style icon" src="../../Imagenes-Videos/avatar.png" alt=""><?php echo"{$_SESSION['tipoUsuario']}";?></a>
                  </li>
                  <img class="icon cerrar-sesion btn-delete" src="../../Imagenes-Videos/Cerrar-sesion.png" alt="">
                  <input class="btn btn-outline-danger log_out" value="Cerrar Sesión" name="submit" type="submit">
                </form>
            </div>
            <?php  
                if (!empty($_POST["submit"])){
                    $_POST = array();
                    header("LOCATION: ../../inicio_de_sesion/inicio_sesion.php");
                    }
                }
            ?>




    <!-- Navbar del UNR  Modularizada -->

    <?php 
        if($_SESSION["tipoUsuario"] == "UNR"){
          if($_SERVER["PHP_SELF"] == "/Home-UNR/index.php"){
    ?>
              <div class="navbar-style">
                <a class="navbar-brand" href="../Home-UNR/index.php"><img class="icon" src="../Imagenes-Videos/bolsas-de-compra.png" alt="Icono"></a>
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
                <a class="navbar-brand" href="../../Home-UNR/index.php"><img class="icon" src="../../Imagenes-Videos/bolsas-de-compra.png" alt="Icono"></a>
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


    <!-- Navbar del UNR  Modularizada -->

    <?php 
        if($_SESSION["tipoUsuario"] == "Dueño"){
    ?>
            <div class="navbar-style">
                <a class="navbar-brand" href="../Home/Home.php"><img class="icon" src="../../Imagenes-Videos/bolsas-de-compra.png" alt="Icono"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse" id="navbarScroll">
                <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
                  <li class="nav-item">
                    <a class="nav-link active locales-active" aria-current="page" href="../Locales/Locales.php">Promociones</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="../Promociones/Promociones.php">Solicitudes de Promociones</a>
                  </li>
                  <li class="nav-item dropdown">
                    <a class="nav-link active" aria-current="page" href="../Novedades/Novedades.php">Reportes</a>
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
                    <a class="nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><img class="avatar-style icon" src="../../Imagenes-Videos/avatar.png" alt=""><?php echo"{$_SESSION['tipoUsuario']}";?></a>
                  </li>
                  <img class="icon cerrar-sesion btn-delete" src="../../Imagenes-Videos/Cerrar-sesion.png" alt="">
                  <input class="btn btn-outline-danger log_out" value="Cerrar Sesión" name="submit" type="submit">
                </form>
            </div>
            <?php  
                if (!empty($_POST["submit"])){
                    $_POST = array();
                    header("LOCATION: ../../inicio_de_sesion/inicio_sesion.php");
                    }
                }
            ?> 
        </div>
      </div>



    </nav>
  </header> 
</body>
</html>
