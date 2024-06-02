<?php
    $server = "localhost";
    $user = "root";
    $pass = "";
    $name = "compras";

    try {
        $connection = mysqli_connect($server, $user, $pass, $name);
    }
    catch(mysqli_sql_exception) {
        echo "Error";
    }
?>