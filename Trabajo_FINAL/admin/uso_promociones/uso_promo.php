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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../Imagenes-Videos/bolsas-de-compra.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="uso_promo_style.css">
    <link rel="stylesheet" href="../../Barra_Navegacion/Bar-style.css">
    <link rel="stylesheet" href="../../Pie_De_Pagina/footer.css">
    <title>Rosario Shopping Center - Reportes de Promociones</title>
</head>
<body>
    
    <?php
        include("../../Barra_Navegacion/Nav-bar.php");
    ?>

    <section>
        <h1 class="page_title">Uso de Promociones</h1>
        <div class="subtitle_box">
            <h2 class="page_subtitle">Listado de usos de promociones:</h2>
        </div>

        <?php
            $cant_registros = 10;
            $pag = isset($_GET["page"]) ? $_GET["page"] : 1;
            $inicio = ($pag - 1) * $cant_registros;
            
            $sql_1 = "SELECT * FROM uso_promociones WHERE estadoUsoPromo = 'aceptada' LIMIT $inicio, $cant_registros";
            $sql_total = "SELECT COUNT(*) FROM uso_promociones WHERE estadoUsoPromo = 'aceptada'";

            $result_total = mysqli_query($conn, $sql_total);
            $row_total = mysqli_fetch_row($result_total);
            $total_results = $row_total[0];
            $total_pags = ceil($total_results / $cant_registros);
                
            $result = mysqli_query($conn, $sql_1);
            if (mysqli_num_rows($result) > 0) {
                echo "
                        <div class='table_box'>
                        <table class='table_list'>
                            <caption>Lista de usos de Promociones</caption>
                            <tr>
                                <th>Código Cliente</th>
                                <th>Nombre Cliente</th>
                                <th>Categoría</th>
                                <th>Código Promoción</th>
                                <th>Descripción</th>
                                <th>Código Local</th>
                                <th>Nombre Local</th>
                                <th>Fecha de Uso</th>
                            </tr>    
                    ";
                while ($row = mysqli_fetch_assoc($result)) {                    
                    $sql_aux_1 = "SELECT * FROM usuarios WHERE codUsuario = '{$row["codCliente"]}'";
                    $result_aux_1 = mysqli_query($conn, $sql_aux_1);
                    $row_aux_1 = mysqli_fetch_assoc($result_aux_1);

                    $sql_aux_2 = "SELECT * FROM promociones WHERE codPromo = '{$row["codPromo"]}'";
                    $result_aux_2 = mysqli_query($conn, $sql_aux_2);
                    $row_aux_2 = mysqli_fetch_assoc($result_aux_2);

                    $sql_aux_3 = "SELECT * FROM locales WHERE codLocal = '{$row["codLocal"]}'";
                    $result_aux_3 = mysqli_query($conn, $sql_aux_3);
                    $row_aux_3 = mysqli_fetch_assoc($result_aux_3);
                    echo "
                                <tr>
                                    <td class='cod_cell'>{$row["codCliente"]}</td>
                                    <td>{$row_aux_1["nombreUsuario"]}</td>
                                    <td>{$row_aux_1["categoriaCliente"]}</td>
                                    <td class='cod_cell'>{$row["codPromo"]}</td>
                                    <td class='special_cell'>{$row_aux_2["textoPromo"]}</td>
                                    <td class='cod_cell'>{$row["codLocal"]}</td>
                                    <td>{$row_aux_3["nombreLocal"]}</td>
                                    <td>{$row["fechaUsoPromo"]}</td>
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
                            <p class='warning-box__msj'>No se han usado promociones aún</p>
                    </div>";
            }
        ?>

    </section>

    <section>
        <div class="container mt-5">
            <div class="flex-container">
                <div class="flex-item table-container">
                    <h3 class="page_subtitle">Promociones usadas por local:</h3>
                    <?php
                        $cant_registros_2 = 10;
                        $pag_2 = isset($_GET["page_2"]) ? $_GET["page_2"] : 1;
                        $inicio_2 = ($pag_2 - 1) * $cant_registros_2;

                        $sql_2 = "SELECT * FROM locales LIMIT $inicio_2, $cant_registros_2";
                        $sql_total_2 = "SELECT COUNT(*) FROM locales";

                        $result_total_2 = mysqli_query($conn, $sql_total_2);
                        $row_total_2 = mysqli_fetch_row($result_total_2);
                        $total_results_2 = $row_total_2[0];
                        $total_pags_2 = ceil($total_results_2 / $cant_registros_2);

                        $result_2 = mysqli_query($conn, $sql_2);
                        if (mysqli_num_rows($result_2) > 0) {
                            echo "
                                    <div class='table-responsive'>
                                    <table class='table table-striped table-hover'>
                                        <caption>Promociones usadas por local</caption>
                                        <tr>
                                            <th>Código Local</th>
                                            <th>Nombre Local</th>
                                            <th>Promociones Usadas</th>
                                        </tr>    
                                ";
                            while ($row_2 = mysqli_fetch_assoc($result_2)) {
                                $codLocal = $row_2["codLocal"];
                                $sql_aux = "SELECT COUNT(*) FROM uso_promociones WHERE codLocal = '$codLocal' AND estadoUsoPromo = 'aceptada'";
                                $result_aux = mysqli_query($conn, $sql_aux);

                                if ($result_aux) {
                                    $row_aux = mysqli_fetch_row($result_aux);
                                    $total = $row_aux[0];
                                } 
                                else {
                                    $total = 0;
                                }

                                echo "
                                            <tr>
                                                <td class='cod_cell'>{$row_2["codLocal"]}</td>
                                                <td class='cod_cell'>{$row_2["nombreLocal"]}</td>
                                                <td class='cod_cell'>$total</td>
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
                                    $pag_2 = !isset($_GET["page_2"]) ? 1 : $_GET["page_2"];
                                ?>
                                <span>Página <?php echo $pag_2 ?> de <?php echo $total_pags_2 ?></span>
                                <?php
                                echo '
                                    <div>
                                        <ul class="pagination">
                                ';
                                if (isset($_GET["page_2"]) && $_GET["page_2"] > 1) {
                                    ?>
                                    <li class="page-item"><a href="?page_2=<?php echo $_GET["page_2"] - 1 ?>" class="page-link">««</a></li>
                                    <?php
                                }
                                else {
                                    ?>
                                    <li class="page-item"><a class="page-link inactive">««</a></li>
                                    <?php
                                }
                                for ($i = 1; $i <= $total_pags_2; $i++) {
                                    ?>
                                    <li class="page-item"><a href="?page_2=<?php echo $i ?>" class="page-link"><?php echo $i ?></a></li>
                                    <?php
                                }
                                if (!isset($_GET["page_2"])) {
                                    $_GET["page_2"] = 1;
                                }
                                if ($_GET["page_2"] >= $total_pags_2) {
                                    ?>
                                    <li class="page-item"><a class="page-link inactive">»»</a></li>
                                    <?php
                                }
                                else {
                                    ?>
                                    <li class="page-item"><a href="?page_2=<?php echo $_GET["page_2"] + 1 ?>" class="page-link">»»</a></li>
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
                                <div class='warning-nd-box'>
                                        <p class='warning-box__msj'>No hay locales cargados</p>
                                </div>";
                        }
                    ?>
                </div>
                <div class="flex-item list-container">
                    <h3 class="page_subtitle">Promociones usadas por categoría:</h3>
                    <?php
                        $cont_categorias = array("Inicial"=>0, "Medium"=>0, "Premium"=>0);

                        $sql_3 = "SELECT * FROM uso_promociones WHERE estadoUsoPromo = 'aceptada'";
                        $result_3 = mysqli_query($conn, $sql_3);
                        if (mysqli_num_rows($result_3) > 0) {

                            while ($row_3 = mysqli_fetch_assoc($result_3)) {
                                $sql_cat = "SELECT * FROM usuarios WHERE codUsuario = '{$row_3["codCliente"]}'";
                                $result_cat = mysqli_query($conn, $sql_cat);
                                $row_cat = mysqli_fetch_assoc($result_cat);

                                $cont_categorias["{$row_cat["categoriaCliente"]}"]++;
                            }

                            echo "<ul class='list-group list-group-flush'>";
                            foreach ($cont_categorias as $categoria=>$total_promos) {
                                echo "<li class='list-group-item d-flex justify-content-between align-items-center'>$categoria:
                                        <span class='badge text-bg-primary'>$total_promos</span>
                                    </li>";
                            }
                            echo "</ul>";
                        }
                        else {
                            echo "
                                    <div class='warning-nd-box'>
                                            <p class='warning-box__msj'>No se han usado ninguna promoción</p>
                                    </div>";
                        }
                    ?>
                </div>
            </div>
        </div>
    </section>

    <?php
        include("../../Pie_De_Pagina/footer.php");
    ?>

</body>
</html>
<?php
    ob_end_flush();
?>