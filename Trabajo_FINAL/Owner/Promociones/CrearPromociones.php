<?php
    ob_start();
    session_start();
    include("../../database.php");
    include("../../admin/successMensajes.php");
    include("../../successMail.php");
    
    if (!isset($_SESSION["codUsuario"]) || $_SESSION["tipoUsuario"] != "Dueño de local") {
        header("Location: ../../inicio_de_sesion/inicio_sesion.php");
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../Imagenes-Videos/bolsas-de-compra.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="owner_crear_promociones.css">
    <link rel="stylesheet" href="../../Pie_De_Pagina/footer.css">
    <link rel="stylesheet" href="../../Barra_Navegacion/Bar-style.css">
    <title>Crear Promociones | Rosario Shopping Center</title>
</head>
<body>
    <?php
        include("../../Barra_Navegacion/Nav-bar.php");
    ?>

    <section>
        <h2 class="page_title">Promociones</h2>
        <div class="form_back">
            <button class="btn btn-outline-secondary">
                <svg class="arrow_symbol" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/>
                </svg>
                <a href="Promociones.php" class="volver_btn" aria-label="Volver a la pagina anterior"></a>
                Volver
            </button>
        </div>
        <?php
            successMensaje();
            $_SESSION["promocionCreadaDueño"] = 0;
            $_SESSION["fechavalida"] = 0;
            $_SESSION["no_dueño"] = 0;
        ?>
        <div class="create_box">
            <form action="<?php $_SERVER["PHP_SELF"]?>" method="post" class="form_create">
                <h3 class="create_subtitle">Crear Promoción</h3>
                <label class="create_label" for="TextoPromocion">Texto de la Promoción:</label>
                <input type="text" placeholder="..." id="TextoPromocion" class="form-create__input" name="textPromo" maxlength="200" required>
                <label class="create_label" for="fecha">Fecha de Expiración: </label>
                <input type="date" placeholder="..." id="fecha" class="form-create__input" name="fechaHast" required>
                <label class="create_label" for="codigo">Codigo de Local: </label>
                <input type="number" placeholder="..." id="codigo" class="form-create__input" name="codlocal" min="1" required>
                <label class="create_label" for="categoria">Categoria de Cliente: </label>
                <select name="categoria" class="form-create__input" id="categoria">
                    <option value="Inicial">Inicial</option>
                    <option value="Medium">Medium</option>
                    <option value="Premium">Premium</option>
                </select>
                <fieldset>
                    <legend>Selecciona los dias que estara activa</legend>
                        <div class="checkbox_box">
                            <input type="checkbox" class="checkbox" name="luness" value="Lunes" id="lunes">
                            <label for="lunes" class="checkbox_label">Lunes</label><br>
                            <input type="checkbox" class="checkbox" name="martess" value="Martes" id="martes">
                            <label for="martes" class="checkbox_label">Martes</label><br>
                            <input type="checkbox" class="checkbox" name="miercoless" value="Miercoles" id="miercoles">
                            <label for="miercoles" class="checkbox_label">Miércoles</label><br>
                            <input type="checkbox" class="checkbox" name="juevess" value="Jueves" id="jueves">
                            <label for="jueves" class="checkbox_label">Jueves</label><br>
                            <input type="checkbox" class="checkbox" name="vierness" value="Viernes" id="viernes">
                            <label for="viernes" class="checkbox_label">Viernes</label><br>
                            <input type="checkbox" class="checkbox" name="sabados" value="Sabado" id="sabado">
                            <label for="sabado" class="checkbox_label">Sábado</label><br>
                            <input type="checkbox" class="checkbox" name="domingos" value="Domingo" id="domingo">
                            <label for="domingo" class="checkbox_label">Domingo</label><br>
                        </div>
                        <button id="dropdownBtn"><span class="icon_drop"></span><span class="icon_drop_2"></span></button>
                        <div id="dropdownContent">
                            <input type="checkbox" class="checkbox" name="luness" value="Lunes" id="lunesdrop">
                            <label for="lunesdrop" class="checkbox_label">Lunes</label><br>
                            <input type="checkbox" class="checkbox" name="martess" value="Martes" id="martesdrop">
                            <label for="martesdrop" class="checkbox_label">Martes</label><br>
                            <input type="checkbox" class="checkbox" name="miercoless" value="Miercoles" id="miercolesdrop">
                            <label for="miercolesdrop" class="checkbox_label">Miércoles</label><br>
                            <input type="checkbox" class="checkbox" name="juevess" value="Jueves" id="juevesdrop">
                            <label for="juevesdrop" class="checkbox_label">Jueves</label><br>
                            <input type="checkbox" class="checkbox" name="vierness" value="Viernes" id="viernesdrop">
                            <label for="viernesdrop" class="checkbox_label">Viernes</label><br>
                            <input type="checkbox" class="checkbox" name="sabados" value="Sabado" id="sabadodrop">
                            <label for="sabadodrop" class="checkbox_label">Sábado</label><br>
                            <input type="checkbox" class="checkbox" name="domingos" value="Domingo" id="domingodrop">
                            <label for="domingodrop" class="checkbox_label">Domingo</label><br>
                        </div>
                </fieldset>
                <input type="submit" value="Crear Promoción" class="form-create__button" name="sumbit">
            </form>
            <script>
                document.getElementById('dropdownBtn').addEventListener('click', function() {
                  var dropdownContent = document.getElementById('dropdownContent');
                  if (dropdownContent.style.maxHeight) {
                    dropdownContent.style.maxHeight = null; // Ocultar contenido
                    dropdownContent.style.opacity = 0;
                  } else {
                    dropdownContent.style.maxHeight = dropdownContent.scrollHeight + "px";
                    dropdownContent.style.opacity = 1;
                  }
                });
            </script>
        </div>
    </section>
    <?php
        if(isset($_POST["luness"]) || isset($_POST["martess"]) || isset($_POST["miercoless"]) || isset($_POST["juevess"]) || isset($_POST["vierness"]) ||
            isset($_POST["sabados"]) ||isset($_POST["domingos"])){
            if(!empty($_POST["sumbit"])) {
                $search_local = "SELECT * FROM locales WHERE (codLocal, codUsuario) = ('{$_POST["codlocal"]}', '{$_SESSION["codUsuario"]}')";
                $result_local = mysqli_query($conn, $search_local);
                if(mysqli_num_rows($result_local) > 0){ 
                    $fecha_actual = date("Y-m-d");
                    $textoPromo = filter_input(INPUT_POST, "textPromo", FILTER_SANITIZE_SPECIAL_CHARS);
                    $fecha = $_POST["fechaHast"];
                    $fecha_hasta = date('Y-m-d', strtotime($fecha));
                    $categoriaCliente = filter_input(INPUT_POST, "categoria", FILTER_SANITIZE_SPECIAL_CHARS);
                    $codLocal = filter_input(INPUT_POST, "codlocal", FILTER_SANITIZE_NUMBER_INT);
                    if($fecha_actual < $_POST["fechaHast"]){
                        $_POST["luness"] = isset($_POST["luness"]) ? 'Lunes':'';
                        $_POST["martess"] = isset($_POST["martess"]) ? 'Martes':'';
                        $_POST["miercoless"] = isset($_POST["miercoless"]) ? 'Miercoles':'';
                        $_POST["juevess"] = isset($_POST["juevess"]) ? 'Jueves':'';
                        $_POST["vierness"] = isset($_POST["vierness"]) ? 'Viernes':'';
                        $_POST["sabados"] = isset($_POST["sabados"]) ? 'Sabado':'';
                        $_POST["domingos"] = isset($_POST["domingos"]) ? 'Domingo':'';
                        $diasSemana = "";
                        $dias_semana = array("Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado", "Domingo");
                        $dias = array($_POST["luness"], $_POST["martess"], $_POST["miercoless"], $_POST["juevess"], $_POST["vierness"], $_POST["sabados"], $_POST["domingos"]);
                        for($i = 0; $i < 7; $i++){
                            if($dias_semana[$i] == $dias[$i]){
                                $diasSemana = $diasSemana . "1";
                            }
                            else{
                                $diasSemana = $diasSemana . "0";
                            }
                        }
                        $search_promo = "INSERT INTO promociones (textoPromo, fechaDesdePromo, fechaHastaPromo, categoriaCliente, diasSemana, estadoPromo, codLocal) VALUES ('$textoPromo', '$fecha_actual', '$fecha_hasta', '$categoriaCliente', '$diasSemana', 'pendiente', $codLocal)";
                        try{
                            mysqli_query($conn, $search_promo);
                            $_SESSION["promocionCreadaDueño"] = 1;
                            header("LOCATION: CrearPromociones.php");
                        }
                        catch(mysqli_sql_exception){
                            echo"No se pudo lograr";
                        }
                    }
                    else{
                        $_SESSION["fechavalida"] = 1;
                        header("LOCATION: CrearPromociones.php");
                    }
                }
                else{
                    $_SESSION["no_dueño"] = 1;
                    header("LOCATION: CrearPromociones.php");
                }
            } 
        }
    ?>
    <?php
        successMail();
        $_SESSION["mailEnviado"] = 0;
    ?>
    <?php
        include("../../Pie_De_Pagina/footer.php");
    ?>
</body>
</html>
<?php
    ob_end_flush();
?>