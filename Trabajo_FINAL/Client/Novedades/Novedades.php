<?php
  ob_start();
  session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Locales</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
    crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
    integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
    crossorigin="anonymous"></script>
    <link rel="stylesheet" href="Novedades.css">
</head>
<body>
<header class="header">
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
      <div class="container-fluid">
        <div class="navbar-style">
          <a class="navbar-brand" href="../Home/Home.php"><img class="icon" src="../Imagenes-Videos/bolsas-de-compra.png" alt="Icono"></a>
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
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><img class="avatar-style icon" src="../Imagenes-Videos/avatar.png" alt=""><?php
                echo"{$_SESSION['tipoUsuario']}";
              ?></a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item dropdown-item-delete" href="../inicio_de_sesion/inicio_sesion.php">Iniciar Sesión</a></li>
                <li><a class="dropdown-item dropdown-item-delete" href="../inicio_de_sesion/sign_up.php">Registrarse</a></li>
                <li>
                  <hr class="dropdown-divider dropdown-item-delete">
                </li>
                <li><a class="dropdown-item" href="../../inicio_de_sesion/inicio_sesion.php">Cerrar Sesión</a></li>
              </ul>
            </li>
            <img class="icon cerrar-sesion" src="../Imagenes-Videos/Cerrar-sesion.png" alt="">
            <input class="btn btn-outline-danger btn-delete" value="Cerrar Sesión" name="submit" type="submit">
          </form>
            <?php
              if (!empty($_POST["submit"])){
                $_POST = array();
                header("LOCATION: ../../inicio_de_sesion/inicio_sesion.php");
              }
            ?>
        </div>
      </div>
    </nav>
  </header>
    <div class="fondo_titulo">
      <div class="lineas_title">
        <h1>Novedades</h1>
        <p>Nuevas tiendas, experiencias exclusivas y ofertas irresistibles te esperan para hacer de tu visita una aventura inolvidable.</p>
      </div>
    </div>
    <div class="iteracion">  
      <?php
      include("../../database.php");
      $sql = "SELECT * FROM Novedades";
      $result = mysqli_query($conn, $sql);
      $fecha_actual = date("Y-m-d");
      $fecha_actual = strtotime($fecha_actual);
      $search_usu = 'SELECT * FROM usuarios WHERE codusuario = "'.$_SESSION["codusuario"].'"';
      $result_usu = mysqli_query($conn, $search_usu);
      $row_usu = mysqli_fetch_assoc($result_usu);
      if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
          if(strtolower($row_usu["categoriaCliente"]) == "premium"){
            $row["fechaDesdeNov"] = strtotime($row["fechaDesdeNov"]);
            $diferencia = ($fecha_actual - $row["fechaDesdeNov"]) / 86400; 
            if($diferencia == 0){
              echo"
              <div class='card text-center '>
              <div class='card-header top_card'>
                {$row['tipoUsuario']}
              </div>
              <div class='card-body'>
                <h5 class='card-title'></h5>
                <p class='card-text'>{$row['textoNovedad']}</p>
              </div>
              <div class='card-footer text-body-secondary green'>
                Nueva
              </div>
            </div>
              ";
            }
            else{
              echo"
              <div class='card text-center '>
              <div class='card-header top_card'>
                {$row['tipoUsuario']}
              </div>
              <div class='card-body'>
                <h5 class='card-title'></h5>
                <p class='card-text'>{$row['textoNovedad']}</p>
              </div>
              <div class='card-footer text-body-secondary bottom_card'>
                Hace unos dias
              </div>
            </div>
              ";

            }
          }
          elseif(strtolower($row_usu["categoriaCliente"]) == "medium"){
            if(strtolower($row["tipoUsuario"]) != "premium"){
              $row["fechaDesdeNov"] = strtotime($row["fechaDesdeNov"]);
              $diferencia = ($fecha_actual - $row["fechaDesdeNov"]) / 86400; 
              if($diferencia == 0){
                echo"
                <div class='card text-center '>
                <div class='card-header top_card'>
                  {$row['tipoUsuario']}
                </div>
                <div class='card-body'>
                  <h5 class='card-title'></h5>
                  <p class='card-text'>{$row['textoNovedad']}</p>
                </div>
                <div class='card-footer text-body-secondary green'>
                  Nueva
                </div>
              </div>
                ";
              }
              else{
                echo"
                <div class='card text-center '>
                <div class='card-header top_card'>
                  {$row['tipoUsuario']}
                </div>
                <div class='card-body'>
                  <h5 class='card-title'></h5>
                  <p class='card-text'>{$row['textoNovedad']}</p>
                </div>
                <div class='card-footer text-body-secondary bottom_card'>
                  Hace unos dias
                </div>
              </div>
                ";

              }
            }
          }
          elseif(strtolower($row_usu["categoriaCliente"])  == "inicial"){
            if(strtolower($row["tipoUsuario"]) == "inicial"){
              $row["fechaDesdeNov"] = strtotime($row["fechaDesdeNov"]);
              $diferencia = ($fecha_actual - $row["fechaDesdeNov"]) / 86400; 
              if($diferencia == 0){
                echo"
                <div class='card text-center '>
                <div class='card-header top_card'>
                  {$row['tipoUsuario']}
                </div>
                <div class='card-body'>
                  <h5 class='card-title'>asdasd</h5>
                  <p class='card-text'>{$row['textoNovedad']}</p>
                </div>
                <div class='card-footer text-body-secondary green'>
                  Nueva
                </div>
              </div>
                ";
              }
              else{
                echo"
                <div class='card text-center '>
                <div class='card-header top_card'>
                  {$row['tipoUsuario']}
                </div>
                <div class='card-body'>
                  <h5 class='card-title'>Novedad</h5>
                  <p class='card-text'>{$row['textoNovedad']}</p>
                </div>
                <div class='card-footer text-body-secondary bottom_card'>
                  Hace unos dias
                </div>
              </div>
                ";

              }
            }
          }
        }
      }
      ?>
    </div>
    <footer class="footer" id="Contacto">
    <div class="f1">
      <h3 class="footer-titles">Ubicación: Junín 501</h3>
      <div class="img_mapa">
        <a href="https://www.google.com/maps/place/Alto+Rosario+Shopping/@-32.9282706,-60.674688,15z/data=!4m6!3m5!1s0x95b654abc3ab1d5f:0x2f90ce97db2c5a6!8m2!3d-32.9274658!4d-60.6690017!16s%2Fg%2F1tdvlb_y?entry=ttu" target="_blank">
          <img src="../Imagenes-Videos/Captura de pantalla 2024-05-02 100702.png" alt="Ubicación en Google Maps"></a>
      </div>
    </div>

    <div class="f2">
      <div class="contact_container">
        <h3 class="footer-titles">Información</h3>

        <div class="logo_footer">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telephone" viewBox="0 0 16 16">
            <path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.6 17.6 0 0 0 4.168 6.608 17.6 17.6 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.68.68 0 0 0-.58-.122l-2.19.547a1.75 1.75 0 0 1-1.657-.459L5.482 8.062a1.75 1.75 0 0 1-.46-1.657l.548-2.19a.68.68 0 0 0-.122-.58zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877z" />
          </svg>
          <a href="">
            (+54)341-644-1810
          </a>
        </div>
        <div class="logo_footer">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-instagram" viewBox="0 0 16 16">
            <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.9 3.9 0 0 0-1.417.923A3.9 3.9 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.9 3.9 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.9 3.9 0 0 0-.923-1.417A3.9 3.9 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599s.453.546.598.92c.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.5 2.5 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.5 2.5 0 0 1-.92-.598 2.5 2.5 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233s.008-2.388.046-3.231c.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92s.546-.453.92-.598c.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92m-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217m0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334" />
          </svg>
          <a href="https://instagram.com" target="_blank">
            Nuestro Instagram!!
          </a>

        </div>


        <div class="logo_footer">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope-open" viewBox="0 0 16 16">
            <path d="M8.47 1.318a1 1 0 0 0-.94 0l-6 3.2A1 1 0 0 0 1 5.4v.817l5.75 3.45L8 8.917l1.25.75L15 6.217V5.4a1 1 0 0 0-.53-.882zM15 7.383l-4.778 2.867L15 13.117zm-.035 6.88L8 10.082l-6.965 4.18A1 1 0 0 0 2 15h12a1 1 0 0 0 .965-.738ZM1 13.116l4.778-2.867L1 7.383v5.734ZM7.059.435a2 2 0 0 1 1.882 0l6 3.2A2 2 0 0 1 16 5.4V14a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V5.4a2 2 0 0 1 1.059-1.765z" />
          </svg>
          <a href="https://gmail.com" target="_blank">
            Hablanos para consultas!!
          </a>

        </div>
      </div>
    </div>

    <div class="f4">
      <h3 class="footer-titles">Mapa del Sitio</h3>
      <ul class="site_map">
        <li> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16">
            <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0" />
          </svg><a href="../Locales/Locales.php">Locales</a></li>
        <li> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16">
            <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0" />
          </svg><a href="#">Dueños</a></li>
        <li> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16">
            <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0" />
          </svg><a href="#">Novedades</a></li>
        <li> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16">
            <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0" />
          </svg><a href="#">Verificar promociones</a></li>
        <li> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16">
            <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0" />
          </svg><a href="#">Utilización de promociones</a></li>
      </ul>
    </div>

    <div class="f3">
      <h3 class="footer-titles">Contáctanos</h3>
      <div class="logo_footer_form">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-card-list" viewBox="0 0 16 16">
          <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2z" />
          <path d="M5 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 5 8m0-2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m0 5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m-1-5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0M4 8a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0m0 2.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0" />
        </svg>
        <a href="Formulario_contacto.html" target="_blank">Formulario de Contacto</a>
      </div>
    </div>

  </footer>
</body>
<?php
  ob_end_flush();
?>