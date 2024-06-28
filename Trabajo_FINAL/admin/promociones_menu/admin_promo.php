<?php
    ob_start();
    session_start();
    /*if (!isset($_SESSION["codUsuario"]) || $_SESSION["codUsuario"] != 1) {
        session_destroy();
        header("Location: ../../inicio_de_sesion/inicio_sesion.php");
    }*/
    include("../../database.php");
    include("../successMensajes.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../Imagenes-Videos/bolsas-de-compra.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="admin_promo_style.css">
    <link rel="stylesheet" href="../../Barra_Navegacion/Bar-style.css">
    <link rel="stylesheet" href="../../Pie_De_Pagina/footer.css">
    <title>Rosario Shopping Center - Solicitud de Promociones</title>
</head>
<body>

    <?php
        include("../../Barra_Navegacion/Nav-bar.php");
    ?>

    <section>
        <h1 class="page_title">Promociones</h1>
        <div class="subtitle_box">
            <h2 class="page_subtitle">Listado de solicitudes de promociones:</h2>
        </div>

        <?php
            successMensaje();
            $_SESSION["promoAceptada"] = 0;
            $_SESSION["promoDenegada"] = 0;
            
            $cant_registros = 10;
            $pag = isset($_GET["page"]) ? $_GET["page"] : 1;
            $inicio = ($pag - 1) * $cant_registros;
            
            $sql = "SELECT * FROM promociones WHERE estadoPromo = 'pendiente' LIMIT $inicio, $cant_registros";
            $sql_total = "SELECT COUNT(*) FROM promociones WHERE estadoPromo = 'pendiente'";

            $result_total = mysqli_query($conn, $sql_total);
            $row_total = mysqli_fetch_row($result_total);
            $total_results = $row_total[0];
            $total_pags = ceil($total_results / $cant_registros);
                
            $result = mysqli_query($conn, $sql);
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
                                <th>Estado</th>
                                <th>Acciones</th>
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
                                    <td class='special_cell'>{$row["textoPromo"]}</td>
                                    <td>{$local["nombreLocal"]}</td>
                                    <td>{$row["categoriaCliente"]}</td>
                                    <td>{$row["fechaDesdePromo"]}</td>
                                    <td>{$row["fechaHastaPromo"]}</td>
                                    <td class='special_cell'>$dias_validos</td>
                                    <td>{$row["estadoPromo"]}</td>
                                    <td class='button_cell'>
                                        <button class='btn btn-outline-secondary' onclick=\"document.getElementById('modal-{$row["codPromo"]}').checked = true\">
                                            Seleccionar
                                        </button>
                                        <input type='checkbox' id='modal-{$row["codPromo"]}' name='modal-trigger'>
                                        <div class='modal'>
                                            <div class='modal-dialog'>
                                                <div class='modal-content'>
                                                    <div class='modal-header'>
                                                        <h5 class='modal-title'>Aceptar/Rechazar promoción de <strong style='color: #0070d1;'>{$local["nombreLocal"]}</strong></h5>
                                                        <button type='button' class='btn btn-close' onclick=\"document.getElementById('modal-{$row["codPromo"]}').checked = false\" aria-label='Cerrar'></button>
                                                    </div>
                                                    <div class='modal-body'>
                                                        <p><strong style='color: #0070d1;'>{$row["codPromo"]}- {$row["textoPromo"]}</strong><br><br>Se notificará al dueño del local sobre su decisión.</p>
                                                    </div>
                                                    <div class='modal-footer'>
                                                        <form method='POST' action='accept_promo.php'>
                                                            <input type='hidden' name='codPromo' value='{$row["codPromo"]}'>
                                                            <input type='hidden' name='codOwner' value='{$local["codUsuario"]}'>
                                                            <input type='hidden' name='nombreLocal' value='{$local["nombreLocal"]}'>
                                                            <input type='submit' class='btn btn-danger' name='reject_promo' value='Rechazar'>
                                                            <input type='submit' class='btn btn-success' name='accept_promo' value='Aceptar'>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
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
                        <span>
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
                        </span>
                    ';
                    ?>
                </div>

        <?php
            }
            else {
                echo "
                    <div class='warning-box'>
                            <p class='warning-box__msj'>No hay solicitudes de promoción</p>
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