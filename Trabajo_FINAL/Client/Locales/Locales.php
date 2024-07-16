<?php
  session_start();
  include("../../successMail.php");
?>
<!DOCTYPE html>
<html lang="es">
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
    <title>Locales | Rosario Shopping Center</title>
</head>
<body>
  <!-- Módulo de barra de navegación -->

  <?php
    include("../../Barra_Navegacion/Nav-bar.php");
  ?>

  <!-- Título de Locales-->
  <main>
        <h1 class="page_title">Locales</h1>

    <!-- Barra de búsqueda de locales -->
        <form class="filtrado_locales" method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>">
          <label class="search_label" for="select_parametro" id="select_label"><b>Búsqueda de local:</b>
            <select name="parametro" id="select_parametro" class="form-search__select" aria-label="Seleccion de opciones" aria-labelledby="select_label">
                <option value="nombreLocal">Por nombre</option>
                <option value="ubicacionLocal">Por ubicación</option>
                <option value="rubroLocal">Por rubro</option>
                <option value="codUsuario">Por código de Dueño</option>
            </select>
          </label>
          <input id="lupa_local" type="text" class="busqueda_local" name="busqueda" placeholder="¿Qué desea buscar?" title="Busqueda de local" aria-label="Campo de texto, ingresar el dato para buscar">
          <label for="enviar_busqueda" class="label_busqueda">
            <button type="submit" class="lupa_input" id="enviar_busqueda" name="busqued" aria-label="Botón Buscar">
                <img class="lupa_busqueda" src="../../Imagenes-Videos/lupa.png" alt="Lupa de búsqueda">
            </button>
          </label>
        </form>

      <div class="iteracion">  
        <?php
        include("../../database.php");
          if(empty($_GET["busqueda"])){
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
                                <a class='link_promociones' href='$URL' aria-label='Enlace a Promociones del local' title='Promociones del Local'>Promociones</a>
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
            $parame = $_GET["parametro"];
            $busqueda = $_GET["busqueda"];
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
                              <a class='link_promociones' href='$URL' aria-label='Enlace a Promociones del local' title='Promociones del Local'>Promociones</a>
                            </div>
                      </div>";
              };
            }
            else{
              echo"
                <div class = 'error_box'>
                  <p class = 'error'>No se encontraron locales</p>
                </div>

              ";
            }
          };
        ?>
      </div>
  </main>
    <?php
      include("../../Pie_De_Pagina/footer.php");
    ?>
    <?php
        successMail();
        if($_SESSION["mailEnviado"] == 1){
            header("Location: {$_SERVER["PHP_SELF"]}");
        }
        $_SESSION["mailEnviado"] = 0;
    ?>
</body>