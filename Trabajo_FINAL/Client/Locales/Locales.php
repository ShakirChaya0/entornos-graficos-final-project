<?php
  session_start();
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
    <link rel="stylesheet" href="Locales.css">
    <link rel="stylesheet" href="../../Pie_De_Pagina/footer.css">
    <link rel="stylesheet" href="../../Barra_Navegacion/Bar-style.css">
    <title>Rosario Shopping Center Locales</title>
</head>
<body>
  <!-- Módulo de barra de navegación -->

  <?php
    include("../../Barra_Navegacion/Nav-bar.php");
  ?>

  <!-- Título de Locales-->

    <div class="lineas_title">Locales</div>

  <!-- Barra de búsqueda de locales -->

    <section class="section1">
      <form class="filtrado_locales" method="post" action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>">
        <label class="search_label" for="select_parametro"><b>Búsqueda de local:</b>
          <select name="parametro" id="select_parametro" class="form-search__select">
              <option value="nombreLocal">Por nombre</option>
              <option value="ubicacionLocal">Por ubicación</option>
              <option value="rubroLocal">Por rubro</option>
              <option value="codUsuario">Por código de Dueño</option>
          </select>
        </label>
        <input id= "lupa_local" type="text" class="busqueda_local" name="busqueda" placeholder="¿Qué desea buscar?">
        <label for="enviar_busqueda" class="label_busqueda">
          <img class="lupa_busqueda" src="../../Imagenes-Videos/lupa.png" alt="lupa de busqueda"><input type="submit" class="lupa_input" id="enviar_busqueda" name="busqued">
        </label>
      </form>
    </section>

    <div class="iteracion">  
      <?php
      include("../../database.php");
        if(empty($_POST["busqueda"])){
          $sql = "SELECT * FROM locales";
          $result = mysqli_query($conn, $sql);
          if(mysqli_num_rows($result) > 0){
              while($row = mysqli_fetch_assoc($result)){
                $URL= "../Promociones/Promociones.php" . "?Local={$row["nombreLocal"]}";
                  echo"
                      <div class='container'>
                            <div class ='local_data'> Local {$row['codLocal']} <br> {$row['ubicacionLocal']} <br> {$row['rubroLocal']} </div>
                            <div class =  'base-div'>
                              <p class = 'data'> {$row['nombreLocal']}</p>
                            </div>
                            <div class = 'hover-div'>
                              <a class='link_promociones' href='$URL'>Promociones</a>
                            </div>
                      </div>";
              };
          }
          else{
            echo"
              <div class = 'error_box'>
                <p class = 'error'>No hay Locales</p>
              </div>
            
            ";
          }
        }
        else{
          $parame = $_POST["parametro"];
          $busqueda = $_POST["busqueda"];
          $sql = "SELECT * FROM locales WHERE $parame LIKE '$busqueda%'";
          $resp = mysqli_query($conn, $sql);
          if(mysqli_num_rows($resp) > 0){
            while($row = mysqli_fetch_assoc($resp)){
              $URL= "../Promociones/Promociones.php" . "?Local={$row["nombreLocal"]}";
                echo"
                    <div class='container'>
                          <div class ='local_data'> Local {$row['codLocal']} <br> ubi {$row['ubicacionLocal']} <br> {$row['rubroLocal']} </div>
                          <div class = 'base-div'>
                            <p class = 'data'> {$row['nombreLocal']}</p>
                          </div>
                          <div class = 'hover-div'>
                            <a class='link_promociones' href='$URL'>Promociones</a>
                          </div>
                    </div>";
            };
          }
          else{
            echo"
              <div class = 'error_box'>
                <p class = 'error'>No se encontro lo que buscaste</p>
              </div>
            
            ";
          }
        };
      ?>
    </div>
    <?php
      include("../../Pie_De_Pagina/footer.php");
    ?>
</body>