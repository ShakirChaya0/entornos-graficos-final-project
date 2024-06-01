<?php
    ob_start();
    session_start();
    include("../database.php");
    include("../successMensajes.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../bolsas-de-compra.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="admin_users_style.css">
    <title>Rosario Shopping Center - Solicitud de Cuentas</title>
</head>
<body>
    <header class="header">
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <div class="navbar-style">
                <a class="navbar-brand" href="../home_page_admin.html"><img class="icon" src="../bolsas-de-compra.png" alt="Icono"></a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
                <div class="collapse navbar-collapse" id="navbarScroll">
                    <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="../locales_menu/admin_locales.php">Locales</a>
                        </li>
                        <li class="nav-item dropdown list-item">
                            <a class="nav-link active dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Usuarios</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="../users_menu/admin_users.php">Usuarios Registrados</a></li>
                                <li><a class="dropdown-item" href="../users_menu/admin_owner.php">Validar/Denegar Cuentas de Dueño</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link active" aria-current="page" href="../novedades_menu/admin_nov.php">Novedades</a>
                        </li>
                        <li class="nav-item dropdown list-item">
                            <a class="nav-link active dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Promociones</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="../promociones_menu/admin_lista_promo.php">Promociones Cargadas</a></li>
                                <li><a class="dropdown-item" href="../promociones_menu/admin_promo.php">Aceptar/Rechazar Promociones</a></li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="../uso_promociones/uso_promo.php">Uso de Promociones</a>
                        </li>
                    </ul>
                    <form class="d-flex align-items-center form-style" role="search" method="post" action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
                        <li class="nav-item dropdown list-item">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><img class="avatar-style icon" src="../avatar.png" alt="">Administrador</a>
                            <ul class="dropdown-menu">
                                <li><button type="submit" class="dropdown-item" name="cerrarSesion">Cerrar Sesión</button></li>
                            </ul>
                        </li>
                    </form>
                </div>
            </div>
        </nav>    
    </header>

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

            $result_total = mysqli_query($connection, $sql_total);
            $row_total = mysqli_fetch_row($result_total);
            $total_results = $row_total[0];
            $total_pags = ceil($total_results / $cant_registros);
                
            $result = mysqli_query($connection, $sql);
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
                                        <button class='btn btn-outline-secondary' onclick=\"document.getElementById('modal-{$row["codUsuario"]}').checked = true\">
                                            Seleccionar
                                        </button>
                                        <input type='checkbox' id='modal-{$row["codUsuario"]}' name='modal-trigger'>
                                        <div class='modal'>
                                            <div class='modal-dialog'>
                                                <div class='modal-content'>
                                                    <div class='modal-header'>
                                                        <h5 class='modal-title'>Validar/Rechazar: <strong style='color: #0070d1;'>{$row["codUsuario"]}- {$row["nombreUsuario"]}</strong></h5>
                                                        <button type='button' class='btn btn-close' onclick=\"document.getElementById('modal-{$row["codUsuario"]}').checked = false\" aria-label='Cerrar'></button>
                                                    </div>
                                                    <div class='modal-body'>
                                                        <p>Si se valida la cuenta, se le dará acceso al usuario a las opciones de Dueño de Local.<br><br> Se notificará al mismo sobre su decisión.</p>
                                                    </div>
                                                    <div class='modal-footer'>
                                                        <form method='POST' action='valid_ac.php'>
                                                            <input type='hidden' name='codUsuario' value='{$row["codUsuario"]}'>
                                                            <input type='hidden' name='nombreUsuario' value='{$row["nombreUsuario"]}'>
                                                            <input type='submit' class='btn btn-danger' name='reject_account' value='Rechazar'>
                                                            <input type='submit' class='btn btn-success' name='accept_account' value='Validar'>
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
                            <p class='warning-box__msj'>No hay solicitudes de cuentas de dueño</p>
                    </div>";
            }
        ?>

    </section>

    <footer class="footer">
        <div class="f1">
            <h3 class="footer-titles">Ubicación: Junín 501</h3>
            <div class="img_mapa">
                <a href="https://www.google.com/maps/place/Alto+Rosario+Shopping/@-32.9282706,-60.674688,15z/data=!4m6!3m5!1s0x95b654abc3ab1d5f:0x2f90ce97db2c5a6!8m2!3d-32.9274658!4d-60.6690017!16s%2Fg%2F1tdvlb_y?entry=ttu" target="_blank">
                <img src="../shopping_map.png" alt="Ubicación en Google Maps"></a>
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