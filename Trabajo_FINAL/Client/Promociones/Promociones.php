<?php
ob_start();
session_start();

$selected_value = "";
$search = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $selected_value = $_POST["parametro"];
    $search = isset($_POST["search"]) ? trim($_POST["search"]) : "";
} elseif (isset($_GET['Local'])) {
    // Si el parámetro 'Local' está presente en la URL, utilizarlo para la búsqueda
    $selected_value = "nombreLocal";
    $search = $_GET['Local'];
}

function mostrarpromociones($conn) {
    date_default_timezone_set('America/Argentina/Buenos_Aires');
    $bandera = false;
    $fecha_actual = date("Y-m-d");
    $dia_actual = date("N") - 1; // Devuelve el día de la semana en números, 0 (Lunes) a 6 (Domingo)

    $search_usu = 'SELECT * FROM usuarios WHERE codUsuario = "'.$_SESSION["codUsuario"].'"';
    $result_usu = mysqli_query($conn, $search_usu);
    $row_usu = mysqli_fetch_array($result_usu);
    $_SESSION["categoriaCliente"] = $row_usu["categoriaCliente"];
    $categoriaCliente = $row_usu["categoriaCliente"];

    // Ajustar la consulta de promociones según la categoría del cliente
    if ($categoriaCliente == 'Premium') {
        $categoriaFiltro = "('Premium', 'Medium', 'Inicial')";
    } elseif ($categoriaCliente == 'Medium') {
        $categoriaFiltro = "('Medium', 'Inicial')";
    } else {
        $categoriaFiltro = "('Inicial')";
    }

    $search_promo = "SELECT * FROM promociones WHERE categoriaCliente IN $categoriaFiltro AND estadoPromo = 'aprobada'";
    $result_promo = mysqli_query($conn, $search_promo);

    if (mysqli_num_rows($result_promo) > 0) {
        while ($row_promo = mysqli_fetch_assoc($result_promo)) {
            $search_local = 'SELECT * FROM locales WHERE codLocal = "'.$row_promo["codLocal"].'"';
            $result_local = mysqli_query($conn, $search_local);
            $row_local = mysqli_fetch_array($result_local);
            $dias_disponibles = str_split($row_promo["diasSemana"]);

            if ($row_promo["fechaDesdePromo"] <= $fecha_actual && $row_promo["fechaHastaPromo"] >= $fecha_actual && $dias_disponibles[$dia_actual] == "1") {
                $search_usopromo = 'SELECT * FROM uso_promociones WHERE codCliente = "'.$row_usu["codUsuario"].'" AND codPromo = "'.$row_promo["codPromo"].'"';
                $result_usoPromo = mysqli_query($conn, $search_usopromo);
                if (mysqli_num_rows($result_usoPromo) > 0) {
                    echo "
                    <div class='card text-center' role='region' aria-labelledby='promo-{$row_promo['codPromo']}'>
                      <div class='card-header top_card green' id='promo-{$row_promo['codPromo']}'>
                        {$row_local['nombreLocal']}
                      </div>
                      <div class='card-body aprobado'>
                        <p class='card-text'>{$row_promo['textoPromo']}</p>
                      </div>
                        <button class='card-footer text-body-secondary usado' aria-disabled='true'>
                          Promoción Usada
                        </button>
                    </div>
                  ";
                } else {
                    mostrarPromocion($row_promo, $row_local, $row_usu, $fecha_actual, $conn);
                }
                $bandera = true;
            }
        }
    } else {
        echo "<div class='no_promo cion'>No hay promociones</div>";
        $bandera = true;
    }

    if (!$bandera) {
        echo "<div class='no_promo cion'>No hay promociones</div>";
    }
}

function mostrarPromocion($row_promo, $row_local, $row_usu, $fecha_actual, $conn) {
    echo "
    <div class='card text-center' role='region' aria-labelledby='promo-{$row_promo['codPromo']}'>
      <div class='card-header top_card' id='promo-{$row_promo['codPromo']}'>
        {$row_local['nombreLocal']}
      </div>
      <div class='card-body'>
        <p class='card-text'>{$row_promo['textoPromo']}</p>
      </div>
      <form action='Promociones.php' method='post'>
        <button name='{$row_promo["codPromo"]}' type='submit' value='Usar' class='card-footer text-body-secondary button' aria-label='Usar promoción del local'>
          Usar Promoción
        </button>
      </form>
    </div>
      ";
    if (!empty($_POST["{$row_promo['codPromo']}"]) && $_POST["{$row_promo['codPromo']}"] == "Usar") {
        $cantProm = $row_usu["cantidadPromo"] + 1;
        $sql = "UPDATE usuarios SET cantidadPromo = '$cantProm' WHERE codUsuario = {$row_usu['codUsuario']}";
        mysqli_query($conn, $sql);

        if ($cantProm > 3 && $cantProm < 9) {
            $sqli = "UPDATE usuarios SET categoriaCliente = 'Medium' WHERE codUsuario = {$row_usu['codUsuario']}";
            mysqli_query($conn, $sqli);
        } elseif ($cantProm > 9) {
            $sqlia = "UPDATE usuarios SET categoriaCliente = 'Premium' WHERE codUsuario = {$row_usu['codUsuario']}";
            mysqli_query($conn, $sqlia);
        }

        $add_prom = "INSERT INTO uso_promociones (codCliente, codPromo, fechaUsoPromo, estadoUsoPromo, codLocal) VALUES ({$row_usu['codUsuario']}, {$row_promo['codPromo']}, '$fecha_actual', 'aceptada', {$row_promo['codLocal']})";
        mysqli_query($conn, $add_prom);
        $_POST = array();
        header("LOCATION: {$_SERVER['PHP_SELF']}");
        exit();
    }
}

function mostrarpromociones_usadas($conn) {
    date_default_timezone_set('America/Argentina/Buenos_Aires');
    $fecha_actual = date("Y-m-d");
    $dia_actual = date("N") - 1; // Devuelve el día de la semana en números, 0 (Lunes) a 6 (Domingo)
    $search_usu = 'SELECT * FROM usuarios WHERE codUsuario = "'.$_SESSION["codUsuario"].'"';
    $result_usu = mysqli_query($conn, $search_usu);
    $row_usu = mysqli_fetch_array($result_usu);
    $search_promo = 'SELECT p.*, l.nombreLocal FROM promociones p
                     INNER JOIN uso_promociones u ON p.codPromo = u.codPromo
                     INNER JOIN locales l ON p.codLocal = l.codLocal
                     WHERE u.codCliente = "'.$row_usu["codUsuario"].'" AND u.estadoUsoPromo = "aceptada"';
    $result_promo = mysqli_query($conn, $search_promo);

    if (mysqli_num_rows($result_promo) > 0) {
        while ($row_promo = mysqli_fetch_assoc($result_promo)) {
            echo "
            <div class='card text-center' role='region' aria-labelledby='promo-{$row_promo['codPromo']}'>
                  <div class='card-header top_card green' id='promo-{$row_promo['codPromo']}'>
                    {$row_promo['nombreLocal']}
                  </div>
                  <div class='card-body aprobado'>
                    <p class='card-text'>{$row_promo['textoPromo']}</p>
                  </div>
                    <button class='card-footer text-body-secondary usado' aria-disabled='true'>
                      Promoción Usada
                    </button>
                </div>
                  ";
        }
    } else {
        echo "<div class='no_promo cion'>No has usado promociones todavía</div>";
    }
}

function mostrarpromociones_Texto($parametro, $busqueda, $conn) {
    date_default_timezone_set('America/Argentina/Buenos_Aires');
    $fecha_actual = date("Y-m-d");
    $dia_actual = date("N") - 1; // Devuelve el día de la semana en números, 0 (Lunes) a 6 (Domingo)
    $search_usu = 'SELECT * FROM usuarios WHERE codUsuario = "'.$_SESSION["codUsuario"].'"';
    $result_usu = mysqli_query($conn, $search_usu);
    $row_usu = mysqli_fetch_array($result_usu);
    $busqueda = mysqli_real_escape_string($conn, $busqueda);
    
    if ($row_usu["categoriaCliente"] == 'Premium') {
        $categoriaFiltro = "('Premium', 'Medium', 'Inicial')";
    } elseif ($row_usu["categoriaCliente"] == 'Medium') {
        $categoriaFiltro = "('Medium', 'Inicial')";
    } else {
        $categoriaFiltro = "('Inicial')";
    }

    $search_promo_busq = "SELECT * FROM promociones WHERE $parametro LIKE '$busqueda%' AND estadoPromo = 'aprobada' AND categoriaCliente IN $categoriaFiltro";
    $result_promo_busq = mysqli_query($conn, $search_promo_busq);

    if (mysqli_num_rows($result_promo_busq) > 0) {
        while ($row_promo_busq = mysqli_fetch_assoc($result_promo_busq)) {
            $search_local = 'SELECT * FROM locales WHERE codLocal = "'.$row_promo_busq["codLocal"].'"';
            $result_local = mysqli_query($conn, $search_local);
            $row_local = mysqli_fetch_array($result_local);
            if ($row_local == null) {
                $row_local["codLocal"] = 0;
            }
            $dias_disponibles = str_split($row_promo_busq["diasSemana"]);

            if ($row_promo_busq["fechaDesdePromo"] <= $fecha_actual && $row_promo_busq["fechaHastaPromo"] >= $fecha_actual && $dias_disponibles[$dia_actual] == "1") {
                $search_usopromo = 'SELECT * FROM uso_promociones WHERE codCliente = "'.$row_usu["codUsuario"].'" AND codPromo = "'.$row_promo_busq["codPromo"].'"';
                $result_usoPromo = mysqli_query($conn, $search_usopromo);
                if (mysqli_num_rows($result_usoPromo) > 0) {
                    echo "
                    <div class='card text-center' role='region' aria-labelledby='promo-{$row_promo_busq['codPromo']}'>
                      <div class='card-header top_card green' id='promo-{$row_promo_busq['codPromo']}'>
                        {$row_local['nombreLocal']}
                      </div>
                      <div class='card-body aprobado'>
                        <p class='card-text'>{$row_promo_busq['textoPromo']}</p>
                      </div>
                        <button class='card-footer text-body-secondary usado' aria-disabled='true'>
                          Promoción Usada
                        </button>
                    </div>
                  ";
                } else {
                    mostrarPromocion($row_promo_busq, $row_local, $row_usu, $fecha_actual, $conn);
                }
            }
        }
    } else {
        echo "<div class='no_promo cion'>No se encontró la Promoción que buscas</div>";
    }
}

function mostrarpromociones_NombreLocal($busqueda, $conn) {
    date_default_timezone_set('America/Argentina/Buenos_Aires');
    $fecha_actual = date("Y-m-d");
    $dia_actual = date("N") - 1; // Devuelve el día de la semana en números, 0 (Lunes) a 6 (Domingo)
    $search_usu = 'SELECT * FROM usuarios WHERE codUsuario = "'.$_SESSION["codUsuario"].'"';
    $result_usu = mysqli_query($conn, $search_usu);
    $row_usu = mysqli_fetch_array($result_usu);
    $busqueda = mysqli_real_escape_string($conn, $busqueda);
    
    if ($row_usu["categoriaCliente"] == 'Premium') {
        $categoriaFiltro = "('Premium', 'Medium', 'Inicial')";
    } elseif ($row_usu["categoriaCliente"] == 'Medium') {
        $categoriaFiltro = "('Medium', 'Inicial')";
    } else {
        $categoriaFiltro = "('Inicial')";
    }

    $search_local = "SELECT * FROM locales WHERE nombreLocal LIKE '$busqueda%'";
    $result_local = mysqli_query($conn, $search_local);

    if (mysqli_num_rows($result_local) > 0) {
        while ($row_local = mysqli_fetch_assoc($result_local)) {
            $search_promo_busq = "SELECT * FROM promociones WHERE codLocal = '".$row_local["codLocal"]."' AND estadoPromo = 'aprobada' AND categoriaCliente IN $categoriaFiltro";
            $result_promo_busq = mysqli_query($conn, $search_promo_busq);

            while ($row_promo_busq = mysqli_fetch_assoc($result_promo_busq)) {
                $dias_disponibles = str_split($row_promo_busq["diasSemana"]);

                if ($row_promo_busq["fechaDesdePromo"] <= $fecha_actual && $row_promo_busq["fechaHastaPromo"] >= $fecha_actual && $dias_disponibles[$dia_actual] == "1") {
                    $search_usopromo = 'SELECT * FROM uso_promociones WHERE codCliente = "'.$row_usu["codUsuario"].'" AND codPromo = "'.$row_promo_busq["codPromo"].'"';
                    $result_usoPromo = mysqli_query($conn, $search_usopromo);
                    if (mysqli_num_rows($result_usoPromo) > 0) {
                        echo "
                    <div class='card text-center' role='region' aria-labelledby='promo-{$row_promo_busq['codPromo']}'>
                      <div class='card-header top_card green' id='promo-{$row_promo_busq['codPromo']}'>
                        {$row_local['nombreLocal']}
                      </div>
                      <div class='card-body aprobado'>
                        <p class='card-text'>{$row_promo_busq['textoPromo']}</p>
                      </div>
                        <button class='card-footer text-body-secondary usado' aria-disabled='true'>
                          Promoción Usada
                        </button>
                    </div>
                  ";
                    } else {
                        mostrarPromocion($row_promo_busq, $row_local, $row_usu, $fecha_actual, $conn);
                    }
                }
            }
        }
    } else {
        echo "<div class='no_promo cion'>No se encontró la Promoción que buscas</div>";
    }
}

function mostrar_UNR($conn, $search = "", $parametro = "") {
    date_default_timezone_set('America/Argentina/Buenos_Aires');
    $fecha_actual = date("Y-m-d");
    $dia_actual = date("N") - 1; // Devuelve el día de la semana en números, 0 (Lunes) a 6 (Domingo)
    
    $search_promo = "SELECT * FROM promociones WHERE estadoPromo = 'aprobada'";
    if (!empty($search) && $parametro === 'nombreLocal') {
        $search_promo .= " AND codLocal IN (SELECT codLocal FROM locales WHERE nombreLocal LIKE '%" . mysqli_real_escape_string($conn, $search) . "%')";
    } elseif (!empty($search) && $parametro === 'textoPromo') {
        $search_promo .= " AND textoPromo LIKE '%" . mysqli_real_escape_string($conn, $search) . "%'";
    }

    $result_promo = mysqli_query($conn, $search_promo);

    if (mysqli_num_rows($result_promo) > 0) {
        while ($row_promo = mysqli_fetch_assoc($result_promo)) {
            $search_local = 'SELECT * FROM locales WHERE codLocal = "' . $row_promo["codLocal"] . '"';
            $result_local = mysqli_query($conn, $search_local);
            $row_local = mysqli_fetch_array($result_local);
            $dias_disponibles = str_split($row_promo["diasSemana"]);

            if ($row_promo["fechaDesdePromo"] <= $fecha_actual && $row_promo["fechaHastaPromo"] >= $fecha_actual && $dias_disponibles[$dia_actual] == "1") {
                echo "
                <div class='card text-center' role='region' aria-labelledby='promo-{$row_promo['codPromo']}'>
                  <div class='card-header top_card' id='promo-{$row_promo['codPromo']}'>
                    {$row_local['nombreLocal']}
                  </div>
                  <div class='card-body'>
                    <p class='card-text'>{$row_promo['textoPromo']}</p>
                  </div>
                  <form action='Promociones.php' method='post'>
                    <button name='{$row_promo["codPromo"]}' type='submit' value='Usar' class='card-footer text-body-secondary button' aria-label='Usar promoción del local'>
                      Usar Promoción
                    </button>
                  </form>
                </div>
                  ";

                if (!empty($_POST["{$row_promo['codPromo']}"])) {
                    header("LOCATION: ../../inicio_de_sesion/inicio_sesion.php");
                }
            }
        }
    } else {
        echo "<div class='no_promo cion'>No hay promociones todavía</div>";
    }
}
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
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="Promociones.css">
    <link rel="stylesheet" href="../../Pie_De_Pagina/footer.css">
    <link rel="stylesheet" href="../../Barra_Navegacion/Bar-style.css">
    <title>Promociones | Rosario Shopping Center</title>
</head>

<body>
    <?php include("../../Barra_Navegacion/Nav-bar.php"); ?>

    <h1 class="page_title">Promociones</h1>
    <form class="filtrado_locales" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
        <label class="search_label" for="select_parametro"><b>Búsqueda de promoción:</b>
            <select name="parametro" id="select_parametro" class="form-search__select" aria-label="Selección de opciones para buscar">
                <option value="Todas" <?php if ($selected_value == 'Todas') echo 'selected'; ?>>Todas las promociones</option>
                <option value="nombreLocal" <?php if ($selected_value == 'nombreLocal') echo 'selected'; ?>>Por nombre de Local</option>
                <option value="textoPromo" <?php if ($selected_value == 'textoPromo') echo 'selected'; ?>>Descripción de Promoción</option>
                <?php if ($_SESSION["tipoUsuario"] != "UNR") { ?>
                    <option value="estadoUsada" <?php if ($selected_value == 'estadoUsada') echo 'selected'; ?>>Promociones usadas</option>
                <?php } ?>
            </select>
        </label>
        <input id="lupa_local" type="text" class="busqueda_local" name="search" placeholder="¿Qué es lo que busca?" value="<?php echo htmlspecialchars($search); ?>" aria-label="Campo de texto, ingresar el dato para buscar">
        <label for="enviar_busqueda" class="label_busqueda">
            <button type="submit" class="lupa_input" id="enviar_busqueda" name="busqued" aria-label="Botón Buscar">
                <img class="lupa_busqueda" src="../../Imagenes-Videos/lupa.png" alt="Lupa de búsqueda">
            </button>
        </label>
    </form>
    <div class="iteracion">
        <?php
        include("../../database.php");
        if ($_SESSION["tipoUsuario"] != "UNR") {
            if (isset($_GET['Local'])) {
                mostrarpromociones_NombreLocal($_GET['Local'], $conn);
            } elseif (isset($_POST["parametro"])) {
                if ($_POST["parametro"] == "Todas") {
                    mostrarpromociones($conn);
                } elseif ($_POST["parametro"] == "textoPromo" && !empty($_POST["search"])) {
                    mostrarpromociones_Texto($_POST["parametro"], $_POST["search"], $conn);
                } elseif ($_POST["parametro"] == "estadoUsada") {
                    mostrarpromociones_usadas($conn);
                } elseif ($_POST["parametro"] == "nombreLocal" && !empty($_POST["search"])) {
                    mostrarpromociones_NombreLocal($_POST["search"], $conn);
                } else {
                    mostrarpromociones($conn);
                }
            } else {
                mostrarpromociones($conn);
            }
        } else {
            if (isset($_GET['Local'])) {
                mostrar_UNR($conn, $_GET['Local'], 'nombreLocal');
            } else {
                $search = isset($_POST['search']) ? $_POST['search'] : '';
                $parametro = isset($_POST['parametro']) ? $_POST['parametro'] : '';
                mostrar_UNR($conn, $search, $parametro);
            }
        }
        ?>
    </div>

    <?php include("../../Pie_De_Pagina/footer.php"); ?>
</body>
<?php ob_end_flush(); ?>
</html>


