<?php
    ob_start();
    session_start();
    include("../../database.php");

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if ($_POST["accion"] == 'B') {
            $sql = "UPDATE novedades
                    SET estadoNovedad = 'B'
                    WHERE codNovedad = '{$_POST["codNovedad"]}'";

            try {
                mysqli_query($conn, $sql);
                $_SESSION["novEliminada"] = 1;

                header("Location: admin_nov.php");
            }
            catch(mysqli_sql_exception) {
                echo "<p class='msj_error'>Error de conexión con la base de datos.</p>";
            }
        }
        else {
            $sql = "UPDATE novedades
                    SET estadoNovedad = 'A'
                    WHERE codNovedad = '{$_POST["codNovedad"]}'";

            try {
                mysqli_query($conn, $sql);
                $_SESSION["novRestablecida"] = 1;

                header("Location: admin_nov.php");
            }
            catch(mysqli_sql_exception) {
                echo "<p class='msj_error'>Error de conexión con la base de datos.</p>";
            }  
        }
    } 

    ob_end_flush();
?>