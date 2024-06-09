<?php
    ob_start();
    session_start();
    include("../../database.php");

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $sql = "UPDATE locales
                SET estadoLocal = 'B'
                WHERE codLocal = '{$_POST["codLocal"]}'";
        try {
            mysqli_query($conn, $sql);
            $_SESSION["localEliminado"] = 1;

            header("Location: admin_locales.php");
        }
        catch(mysqli_sql_exception) {
            echo "Error al intentar realizar la operación, inténtelo más tarde.";
        }  
    } 

    ob_end_flush();
?>