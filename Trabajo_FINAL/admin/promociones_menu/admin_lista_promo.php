<?php
    ob_start();
    session_start();
    /*if (!isset($_SESSION["codUsuario"]) || $_SESSION["codUsuario"] != 1) {
        session_destroy();
        header("Location: ../../inicio_de_sesion/inicio_sesion.php");
    }*/
    include("../../database.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../Imagenes-Videos/bolsas-de-compra.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="admin_promo_style.css">
    <link rel="stylesheet" href="../../Barra_Navegacion/Bar-style.css">
    <link rel="stylesheet" href="../../Pie_De_Pagina/footer.css">
    <title>Rosario Shopping Center - Listado Promociones</title>
</head>
<body>

    <?php
        include("../../Barra_Navegacion/Nav-bar.php");
    ?>

    <section>
        <h1 class="page_title">Promociones</h1>
        <div class="subtitle_box">
            <h2 class="page_subtitle">Listado de promociones aprobadas:</h2>
        </div>

        <?php
            $cant_registros = 10;
            $pag = isset($_GET["page"]) ? $_GET["page"] : 1;
            $inicio = ($pag - 1) * $cant_registros;
            
            $sql_1 = "SELECT * FROM promociones WHERE estadoPromo = 'aprobada' LIMIT $inicio, $cant_registros";
            $sql_total = "SELECT COUNT(*) FROM promociones WHERE estadoPromo = 'aprobada'";

            $result_total = mysqli_query($conn, $sql_total);
            $row_total = mysqli_fetch_row($result_total);
            $total_results = $row_total[0];
            $total_pags = ceil($total_results / $cant_registros);
                
            $result = mysqli_query($conn, $sql_1);
            if (mysqli_num_rows($result) > 0) {
                $dias_semana = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo"); 
                echo "
                        <div class='table_box'>
                        <table class='table_list'>
                            <caption>Lista de solicitudes de Promociones</caption>
                            <tr>
                                <th>Código</th>
                                <th>Descripción</th>
                                <th>Local</th>
                                <th>Categoría</th>
                                <th>Inicio</th>
                                <th>Finalización</th>
                                <th>Días Válidos</th>
                            </tr>        
                    ";
                while ($row = mysqli_fetch_assoc($result)) {                    
                    $sql_aux = "SELECT * FROM locales WHERE codLocal = '{$row["codLocal"]}'";
                    $result_aux = mysqli_query($conn, $sql_aux);
                    $local = mysqli_fetch_assoc($result_aux);
                    
                    $dias_validos = "";
                    for ($i = 0; $i <= 6; $i++) {
                        if ($row["diasSemana"][$i] == 1) {
                            $dias_validos = $dias_validos . $dias_semana[$i] . "-";
                        }
                    }
                    $len = strlen($dias_validos);
                    $dias_validos[$len - 1] = ' ';

                    echo "
                            <tr>
                                <td class='cod_cell'>{$row["codPromo"]}</td>
                                <td>{$row["textoPromo"]}</td>
                                <td>{$local["nombreLocal"]}</td>
                                <td>{$row["categoriaCliente"]}</td>
                                <td>{$row["fechaDesdePromo"]}</td>
                                <td>{$row["fechaHastaPromo"]}</td>
                                <td>$dias_validos</td>
                            </tr>
                    ";
                }
                echo "
                            </table>
                        </div>
                ";
                ?>

                <!-- PAGINACION -->
                <div class="pagination_info">
                    <?php
                        $pag = !isset($_GET["page"]) ? 1 : $_GET["page"];
                    ?>
                    <span>Página <?php echo $pag ?> de <?php echo $total_pags ?></span>

                    <?php
                    echo '
                        <div>
                            <ul class="pagination">
                    ';

                    if (isset($_GET["page"]) && $_GET["page"] > 1) {
                        ?>
                        <li class="page-item"><a href="?page=<?php echo $_GET["page"] - 1 ?>" class="page-link">««</a></li>
                        <?php
                    }
                    else {
                        ?>
                        <li class="page-item"><a class="page-link inactive">««</a></li>
                        <?php
                    }

                    for ($i = 1; $i <= $total_pags; $i++) {
                        ?>
                        <li class="page-item"><a href="?page=<?php echo $i ?>" class="page-link"><?php echo $i ?></a></li>
                        <?php
                    }

                    if (!isset($_GET["page"])) {
                        $_GET["page"] = 1;
                    }
                    if ($_GET["page"] >= $total_pags) {
                        ?>
                        <li class="page-item"><a class="page-link inactive">»»</a></li>
                        <?php
                    }
                    else {
                        ?>
                        <li class="page-item"><a href="?page=<?php echo $_GET["page"] + 1 ?>" class="page-link">»»</a></li>
                        <?php
                    }

                    echo '
                            </ul>
                        </div>
                    ';
                    ?>
                </div>

        <?php
            }
            else {
                echo "
                    <div class='warning-box'>
                            <p class='warning-box__msj'>No hay promociones cargadas</p>
                    </div>";
            }
        ?>

    </section>

    <?php
        include("../../Pie_De_Pagina/footer.php");
    ?>

</body>
</html>
<?php
    ob_end_flush();
?>