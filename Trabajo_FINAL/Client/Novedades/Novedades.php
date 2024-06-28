<?php
  ob_start();
  session_start();
  /*if($_SESSION["tipoUsuario"] == "UNR"){
    header("LOCATION: ../../inicio_de_sesion/inicio_sesion.php");
  }*/
  include("../../admin/novedades_menu/verif_nov.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../Imagenes-Videos/bolsas-de-compra.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
    crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
    integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
    crossorigin="anonymous"></script>
    <link rel="stylesheet" href="Novedades.css">
    <link rel="stylesheet" href="../../Pie_De_Pagina/footer.css">
    <link rel="stylesheet" href="../../Barra_Navegacion/Bar-style.css">
    <title>Rosario Shopping Center Novedades</title>
  </head>
<body>
  <?php
    include("../../Barra_Navegacion/Nav-bar.php");
  ?>

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
      date_default_timezone_set('America/Argentina/Buenos_Aires');
      $fecha_actual = date("Y-m-d");
      $fecha_actual = strtotime($fecha_actual);
      $search_usu = 'SELECT * FROM usuarios WHERE codUsuario = "'.$_SESSION["codUsuario"].'"';
      $result_usu = mysqli_query($conn, $search_usu);
      $row_usu = mysqli_fetch_assoc($result_usu);
      if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
          if($row["estadoNovedad"] == "A"){
            if(strtolower($row_usu["categoriaCliente"]) == "premium"){
              $row["fechaDesdeNov"] = strtotime($row["fechaDesdeNov"]);
              $diferencia = ($fecha_actual - $row["fechaDesdeNov"]) / 86400; 
              if($diferencia <= 0){
                echo"
                <div class='card text-center '>
                <div class='card-header top_card'>
                  {$row['tipoUsuario']}
                </div>
                <div class='card-body'>
                  <h5 class='card-title'>{$row['tituloNovedad']}</h5>
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
                  <h5 class='card-title'>{$row['tituloNovedad']}</h5>
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
                if($diferencia <= 0){
                  echo"
                  <div class='card text-center '>
                  <div class='card-header top_card'>
                    {$row['tipoUsuario']}
                  </div>
                  <div class='card-body'>
                    <h5 class='card-title'>{$row['tituloNovedad']}</h5>
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
                    <h5 class='card-title'>{$row['tituloNovedad']}</h5>
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
                if($diferencia <= 0){
                  echo"
                  <div class='card text-center '>
                  <div class='card-header top_card'>
                    {$row['tipoUsuario']}
                  </div>
                  <div class='card-body'>
                    <h5 class='card-title'>{$row['tituloNovedad']}</h5>
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
                    <h5 class='card-title'>{$row['tituloNovedad']}</h5>
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
          else{
            continue;
          } 
        }
      }
      else{
        echo"
              <div class = 'error_box'>
                <p class = 'error'>No hay Novedades</p>
              </div>
            
            ";
      }
      ?>
    </div>
    <?php
      include("../../Pie_De_Pagina/footer.php");
    ?>
</body>
<?php
  ob_end_flush();
?>