<?php
    ob_start();
    session_start();
    include("../../database.php");

    if (!isset($_SESSION["codUsuario"]) || $_SESSION["tipoUsuario"] != "Dueño de local") {
        header("Location: ../../inicio_de_sesion/inicio_sesion.php");
    }
    // Función que cuenta la cantidad de usos que tiene cada promo contando las aparciciones del codPromo en la tabla uso_promociones
    function conteo_usos(int $codPromo){
        include("../../database.php");
        $sql_1 = "SELECT * FROM uso_promociones WHERE codPromo = $codPromo";
        $Usos_Promociones = mysqli_query($conn, $sql_1);
        $Cantidad_Usos = mysqli_num_rows($Usos_Promociones);
        return $Cantidad_Usos;
    }

    // Función que ordena las promociones de un local de más usadas a menos usadas
    function mas_usadas_por_local(int $codLocal) {
        include("../../database.php");
        $sql3 = "SELECT * FROM promociones WHERE codLocal = $codLocal";
        $result = mysqli_query($conn, $sql3);
        $Promociones = array();
        while($Promocion = mysqli_fetch_assoc($result)) {
            $Promocion["usos"] = conteo_usos($Promocion["codPromo"]);
            $Promociones[] = $Promocion;
        }
        usort($Promociones, function($a, $b) {
            return $b['usos'] - $a['usos'];
        });
        return $Promociones;
    }
    
    // Función que ordena las promociones de un local de menos usadas a más usadas
    function menos_usadas_por_local(int $codLocal) {
        include("../../database.php");
        $sql3 = "SELECT * FROM promociones WHERE codLocal = $codLocal";
        $result = mysqli_query($conn, $sql3);
        $Promociones = array();
        while($Promocion = mysqli_fetch_assoc($result)) {
            $Promocion["usos"] = conteo_usos($Promocion["codPromo"]);
            $Promociones[] = $Promocion;
        }
        usort($Promociones, function($a, $b) {
            return $a['usos'] - $b['usos'];
        });
        return $Promociones;
    }

    // Función que ordena las promociones de todos los locales de un dueño de más usadas a menos usadas
    function mas_usadas_general() {
        include("../../database.php");
        $sql2= "SELECT * FROM locales WHERE codUsuario = {$_SESSION["codUsuario"]}";
        $result_1 = mysqli_query($conn, $sql2);
        $Promociones = array();
        while($Local = mysqli_fetch_assoc($result_1)) {
            $sql3 = "SELECT * FROM promociones WHERE codLocal = {$Local["codLocal"]}";
            $result_2 = mysqli_query($conn, $sql3);
            while($Promocion = mysqli_fetch_assoc($result_2)) {
                $Promocion["usos"] = conteo_usos($Promocion["codPromo"]);
                $Promociones[] = $Promocion;
            }
        }
        usort($Promociones, function($a, $b) {
            return $b['usos'] - $a['usos'];
        });
        return $Promociones;    
    }

    // Función que ordena las promociones de todos los locales de un dueño de menos usadas a más usadas
    function menos_usadas_general() {
        include("../../database.php");
        $sql2= "SELECT * FROM locales WHERE codUsuario = {$_SESSION["codUsuario"]}";
        $result_1 = mysqli_query($conn, $sql2);
        $Promociones = array();
        while($Local = mysqli_fetch_assoc($result_1)) {
            $sql3 = "SELECT * FROM promociones WHERE codLocal = {$Local["codLocal"]}";
            $result_2 = mysqli_query($conn, $sql3);
            while($Promocion = mysqli_fetch_assoc($result_2)) {
                $Promocion["usos"] = conteo_usos($Promocion["codPromo"]);
                $Promociones[] = $Promocion;
            }
        }
        usort($Promociones, function($a, $b) {
            return $a['usos'] - $b['usos'];
        });
        return $Promociones;   
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
    <link rel="stylesheet" href="./Listado.css">
    <link rel="stylesheet" href="../../Pie_De_Pagina/footer.css">
    <link rel="stylesheet" href="../../Barra_Navegacion/Bar-style.css">
    <title>Reportes de Promociones | Rosario Shopping Center</title>
</head>
<body>
    <?php
    include("../../Barra_Navegacion/Nav-bar.php");
    $sql2= "SELECT * FROM locales WHERE codUsuario = {$_SESSION["codUsuario"]}";
    $Locales = mysqli_query($conn, $sql2);
    $Filas_Locales = mysqli_num_rows($Locales);
    
    if (empty($_POST["Filtrado"])) {
        $_POST["Filtrado"] = "Todos";
    }
    if (empty($_POST["Ordenar"])) {
        $_POST["Ordenar"] = "Mayor";
    }
    ?>
    
    <section>
        <div class="b1">
          <h2 class="title">Uso de Promociones</h2>
        </div>
    </section>
    <div class="back_img">
        <div class="subtitle_box">
                <h2 class="page_subtitle">Listado de usos de promociones:</h2>
                <div class="select">
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                         <div class="select-box">
                            <label class="label">Filtrado:</label>
                            <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="Filtrado" onchange="this.form.submit()">
                                 <option value="Todos" <?php echo ($_POST["Filtrado"] == "Todos") ? "selected" : ""; ?>>Todos</option>
                                 <option value="Local" <?php echo ($_POST["Filtrado"] == "Local") ? "selected" : ""; ?>>Por local</option>
                            </select>
                         </div>
                         <div class="select-box">
                            <label class="label-2">Ordenar de:</label>
                            <select class="form-select form-select-sm select-2" aria-label=".form-select-sm example" name="Ordenar" onchange="this.form.submit()">
                                 <option value="Mayor" <?php echo ($_POST["Ordenar"] == "Mayor") ? "selected" : ""; ?>>Más usadas</option>
                                 <option value="Menor" <?php echo ($_POST["Ordenar"] == "Menor") ? "selected" : ""; ?>>Menos Usadas</option>
                            </select>
                         </div>

                    </form>
                </div>
        </div>
    </div>

<div class="container">

<?php
// Tabla que ordena todos las promociones juntas de todos los locales del dueño de más usadas a menos usadas
if ($Filas_Locales > 0) { 
    if($_POST["Filtrado"] == "Todos" && $_POST["Ordenar"] == "Mayor") {?>
        <table id="promotionsTable">
            <thead>
                <tr>
                    <td class="campos">Promoción</td>
                    <td class="campos">Fecha de inicio</td>
                    <td class="campos">Fecha de fin</td>
                    <td class="campos">Rubro</td>
                    <td class="campos">Usos</td>
                </tr>
            </thead>
            <tbody>
        <?php
        while ($row1 = mysqli_fetch_assoc($Locales)) {
            $sql3 = "SELECT * FROM promociones WHERE codLocal = {$row1["codLocal"]}";
            $Promociones = mysqli_query($conn, $sql3);
            if (mysqli_num_rows($Promociones) > 0) {
                $Promociones_Mas_usadas = mas_usadas_general();
                foreach($Promociones_Mas_usadas as $Promocion){
                    echo "<tr>";
                    echo "<td>" . $Promocion["textoPromo"] . "</td>";
                    echo "<td>" . $Promocion["fechaDesdePromo"] . "</td>";
                    echo "<td>" . $Promocion["fechaHastaPromo"] . "</td>";
                    echo "<td>" . $row1["rubroLocal"] . "</td>";
                    echo "<td>" . $Promocion["usos"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No se encontraron resultados</td></tr>";
            }   
            break;
        }
        ?>
            </tbody>
        </table>
    </div>



<?php    
// Tabla que ordena todos las promociones juntas de todos los locales del dueño de menos usadas a más usadas
}elseif($_POST["Filtrado"] == "Todos" && $_POST["Ordenar"] == "Menor"){     ?>
        <table id="promotionsTable">
            <thead>
                <tr>
                    <td class="campos">Promoción</td>
                    <td class="campos">Fecha de inicio</td>
                    <td class="campos">Fecha de fin</td>
                    <td class="campos">Rubro</td>
                    <td class="campos">Usos</td>
                </tr>
            </thead>
            <tbody>
        <?php
        while ($row1 = mysqli_fetch_assoc($Locales)) {
            $sql3 = "SELECT * FROM promociones WHERE codLocal = {$row1["codLocal"]}";
            $Promociones = mysqli_query($conn, $sql3);
            if (mysqli_num_rows($Promociones) > 0) {
                $Promociones_Mas_usadas = menos_usadas_general();
                foreach($Promociones_Mas_usadas as $Promocion){
                    echo "<tr>";
                    echo "<td>" . $Promocion["textoPromo"] . "</td>";
                    echo "<td>" . $Promocion["fechaDesdePromo"] . "</td>";
                    echo "<td>" . $Promocion["fechaHastaPromo"] . "</td>";
                    echo "<td>" . $row1["rubroLocal"] . "</td>";
                    echo "<td>" . $Promocion["usos"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No se encontraron resultados</td></tr>";
            }
            break;
        }
        ?>
            </tbody>
        </table>
    </div>


<?php
// Tabla que ordena las promociones separadas por local de más usadas a menos usadas
}elseif($_POST["Filtrado"] == "Local" && $_POST["Ordenar"] == "Mayor"){
    while ($row1 = mysqli_fetch_assoc($Locales)) {        ?>
                <table id="promotionsTable">
                    <thead>
                        <?php
                            echo "<th class='Titulo_local' colspan=5 >" . $row1["nombreLocal"] . "</th>";
                        ?>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="campos">Promoción</td>
                            <td class="campos">Fecha de inicio</td>
                            <td class="campos">Fecha de fin</td>
                            <td class="campos">Rubro</td>
                            <td class="campos">Usos</td>
                        </tr>
                        <?php
                                $sql3 = "SELECT * FROM promociones WHERE codLocal = {$row1["codLocal"]}";
                                $Promociones = mysqli_query($conn, $sql3);
                                if (mysqli_num_rows($Promociones) > 0) {
                                    $Promociones_Mas_usadas = mas_usadas_por_local($row1["codLocal"]);
                                    foreach($Promociones_Mas_usadas as $Promocion){
                                        echo "<tr>";
                                        echo "<td>" . $Promocion["textoPromo"] . "</td>";
                                        echo "<td>" . $Promocion["fechaDesdePromo"] . "</td>";
                                        echo "<td>" . $Promocion["fechaHastaPromo"] . "</td>";
                                        echo "<td>" . $row1["rubroLocal"] . "</td>";
                                        echo "<td>" . $Promocion["usos"] . "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='5'>No se encontraron resultados</td></tr>";
                                }
        }
    ?>
                    </tbody>
            </table>
        </div>
<?php
// Tabla que ordena las promociones separadas por local de menos usadas a más usadas  
}elseif($_POST["Filtrado"] == "Local" && $_POST["Ordenar"] == "Menor"){
    while ($row1 = mysqli_fetch_assoc($Locales)) {        ?>
                <table id="promotionsTable">
                    <thead>
                        <?php
                            echo "<th class='Titulo_local' colspan=5 >" . $row1["nombreLocal"] . "</th>";
                        ?>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="campos">Promoción</td>
                            <td class="campos">Fecha de inicio</td>
                            <td class="campos">Fecha de fin</td>
                            <td class="campos">Rubro</td>
                            <td class="campos">Usos</td>
                        </tr>
                        <?php
                                $sql3 = "SELECT * FROM promociones WHERE codLocal = {$row1["codLocal"]}";
                                $Promociones = mysqli_query($conn, $sql3);
                                if (mysqli_num_rows($Promociones) > 0) {
                                    $Promociones_Menos_usadas = menos_usadas_por_local($row1["codLocal"]);
                                    foreach($Promociones_Menos_usadas as $Promocion){
                                        echo "<tr>";
                                        echo "<td>" . $Promocion["textoPromo"] . "</td>";
                                        echo "<td>" . $Promocion["fechaDesdePromo"] . "</td>";
                                        echo "<td>" . $Promocion["fechaHastaPromo"] . "</td>";
                                        echo "<td>" . $row1["rubroLocal"] . "</td>";
                                        echo "<td>" . $Promocion["usos"] . "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='5'>No se encontraron resultados</td></tr>";
                                }
        }
    ?>
                    </tbody>
            </table>
        </div>
<?php
    } 
}else {
    echo "
    <div class='warning-box'>
            <p class='warning-box__msj'>No se han encontrado Locales</p>
    </div>";
}

?>
</div>
<?php
    include("../../Pie_De_Pagina/footer.php");
?>                  

</body>
</html>
<?php
    ob_end_flush();
?>