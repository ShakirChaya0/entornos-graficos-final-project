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
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../Imagenes-Videos/bolsas-de-compra.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="admin_users_style.css">
    <link rel="stylesheet" href="../../Barra_Navegacion/Bar-style.css">
    <link rel="stylesheet" href="../../Pie_De_Pagina/footer.css">
    <title>Rosario Shopping Center - Solicitud de Cuentas</title>
</head>
<body>
    
    <?php
        include("../../Barra_Navegacion/Nav-bar.php");
    ?>

    <section>
        <h1 class="page_title">Cuentas de Dueño</h1>
        <div class="subtitle_box">
            <h2 class="page_subtitle">Listado de solicitudes de cuentas de Dueño de Local:</h2>
        </div>

        <?php
            successMensaje();
            $_SESSION["ownerAceptado"] = 0;
            $_SESSION["ownerRechazado"] = 0;
            
            $cant_registros = 15;
            $pag = isset($_GET["page"]) ? $_GET["page"] : 1;
            $inicio = ($pag - 1) * $cant_registros;
            
            $sql = "SELECT * FROM usuarios WHERE estado = 'P' LIMIT $inicio, $cant_registros";
            $sql_total = "SELECT COUNT(*) FROM usuarios WHERE estado = 'P'";

            $result_total = mysqli_query($conn, $sql_total);
            $row_total = mysqli_fetch_row($result_total);
            $total_results = $row_total[0];
            $total_pags = ceil($total_results / $cant_registros);
                
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                echo "
                        <div class='table_box'>
                        <table class='table_list'>
                            <caption>Lista de solicitudes de cuentas de Dueños de Local</caption>
                            <tr>
                                <th>Código</th>
                                <th>Nombre</th>
                                <th>Acciones</th>
                            </tr>    
                    ";
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "
                                <tr>
                                    <td class='cod_cell'>{$row["codUsuario"]}</td>
                                    <td>{$row["nombreUsuario"]}</td>
                                    <td class='button_cell'>
                                        <button class='btn btn-outline-secondary' role='button' aria-pressed='false' onclick=\"document.getElementById('modal-{$row["codUsuario"]}').checked = true\">
                                            Seleccionar
                                        </button>
                                        <input type='checkbox' id='modal-{$row["codUsuario"]}' name='modal-trigger' aria-label='Seleccionar solicitud'>
                                        <div class='modal'>
                                            <div class='modal-dialog'>
                                                <div class='modal-content'>
                                                    <div class='modal-header'>
                                                        <p class='modal-title'>Validar/Rechazar: <span style='color: #0070d1;'>{$row["codUsuario"]}- {$row["nombreUsuario"]}</span></p>
                                                        <button type='button' class='btn btn-close' onclick=\"document.getElementById('modal-{$row["codUsuario"]}').checked = false\" aria-label='Cerrar'></button>
                                                    </div>
                                                    <div class='modal-body'>
                                                        <p>Si se valida la cuenta, se le dará acceso al usuario a las opciones de Dueño de Local.<br><br> Se notificará al mismo sobre su decisión.</p>
                                                    </div>
                                                    <div class='modal-footer'>
                                                        <form method='POST' action='valid_ac.php'>
                                                            <input type='hidden' name='codUsuario' value='{$row["codUsuario"]}'>
                                                            <input type='hidden' name='nombreUsuario' value='{$row["nombreUsuario"]}'>
                                                            <input type='submit' class='btn btn-danger' name='reject_account' value='Rechazar' aria-label='Rechazar solicitud de cuenta de dueño'>
                                                            <input type='submit' class='btn btn-success' name='accept_account' value='Validar' aria-label='Validar cuenta de dueño'>
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
                            <p class='warning-box__msj'>No hay solicitudes de cuentas de dueño</p>
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