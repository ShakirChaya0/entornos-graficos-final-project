<?php
    $server = "localhost";
    $user = "root";
    $password = "";
    $name = "base2";

    try {
        $connection = mysqli_connect($server, $user, $password, $name);
    }
    catch(mysqli_sql_exception) {
        echo "Error al conectar con la base de datos.";
    }
?>