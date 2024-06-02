<?php
    session_start();

    if (isset($_SESSION["nombreAlumno"])) {
        echo "<h1>Bienvenido {$_SESSION["nombreAlumno"]}!</h1>";
    }
    else {
        echo "No puedes visitar esta página.";
    }
?>