<?php
    ob_start();
    session_start();
    include("../../database.php");
    include("../../admin/successMensajes.php");
    
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
    <title>Rosario Shopping Center - Crear Promociones</title>
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

    <footer class="footer">
        <div class="f1">
            <h3 class="footer-titles">Ubicación: Junín 501</h3>
            <div class="img_mapa">
                <a href="https://www.google.com/maps/place/Alto+Rosario+Shopping/@-32.9282706,-60.674688,15z/data=!4m6!3m5!1s0x95b654abc3ab1d5f:0x2f90ce97db2c5a6!8m2!3d-32.9274658!4d-60.6690017!16s%2Fg%2F1tdvlb_y?entry=ttu" target="_blank">
                <img src="../../Imagenes-Videos/Captura de pantalla 2024-05-02 100702.png" alt="Ubicación en Google Maps"></a>
            </div>
        </div>
    
        <div class="f2">
            <div class="contact_container">
                <h3 class="footer-titles">Información</h3>
                
                <div class="logo_footer">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telephone" viewBox="0 0 16 16">
                        <path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.6 17.6 0 0 0 4.168 6.608 17.6 17.6 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.68.68 0 0 0-.58-.122l-2.19.547a1.75 1.75 0 0 1-1.657-.459L5.482 8.062a1.75 1.75 0 0 1-.46-1.657l.548-2.19a.68.68 0 0 0-.122-.58zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877z" />
                    </svg>
                    <a href="" class="footer__items">(+54)341-644-1810</a>
                </div>
                <div class="logo_footer">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-instagram" viewBox="0 0 16 16">
                        <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.9 3.9 0 0 0-1.417.923A3.9 3.9 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.9 3.9 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.9 3.9 0 0 0-.923-1.417A3.9 3.9 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599s.453.546.598.92c.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.5 2.5 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.5 2.5 0 0 1-.92-.598 2.5 2.5 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233s.008-2.388.046-3.231c.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92s.546-.453.92-.598c.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92m-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217m0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334" />
                    </svg>
                    <a href="https://instagram.com" target="_blank" class="footer__items"> Nuestro Instagram!</a>
                </div>
            
            
                <div class="logo_footer">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope-open" viewBox="0 0 16 16">
                        <path d="M8.47 1.318a1 1 0 0 0-.94 0l-6 3.2A1 1 0 0 0 1 5.4v.817l5.75 3.45L8 8.917l1.25.75L15 6.217V5.4a1 1 0 0 0-.53-.882zM15 7.383l-4.778 2.867L15 13.117zm-.035 6.88L8 10.082l-6.965 4.18A1 1 0 0 0 2 15h12a1 1 0 0 0 .965-.738ZM1 13.116l4.778-2.867L1 7.383v5.734ZM7.059.435a2 2 0 0 1 1.882 0l6 3.2A2 2 0 0 1 16 5.4V14a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V5.4a2 2 0 0 1 1.059-1.765z" />
                    </svg>
                    <a href="https://gmail.com" target="_blank" class="footer__items">Hablanos para consultas!</a>
                </div>
            </div>
        </div>
    
        <div class="f4">
            <h3 class="footer-titles">Mapa del Sitio</h3>
            <ul class="site_map">
                <li>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16">
                        <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0" />
                    </svg>
                    <a href="../locales_menu/admin_locales.php" class="footer__items">Locales</a>
                </li>
                <li>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16">
                        <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0" />
                    </svg>
                    <a href="../users_menu/admin_owner.php" class="footer__items">Dueños</a>
                </li>
                <li>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16">
                        <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0" />
                    </svg>
                    <a href="../novedades_menu/admin_nov.php" class="footer__items">Novedades</a>
                </li>
                <li>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16">
                        <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0" />
                    </svg>
                    <a href="../promociones_menu/admin_promo.php" class="footer__items">Verificar promociones</a>
                </li>
                <li>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16">
                        <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0" />
                    </svg>
                    <a href="../uso_promociones/uso_promo.php" class="footer__items">Utilización de promociones</a>
                </li>
            </ul>
        </div>
      </footer>
</body>
</html>
<?php
    ob_end_flush();
?>