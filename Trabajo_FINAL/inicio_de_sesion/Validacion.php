<?php
    session_start();
    include("../database.php");
    $sql = "SELECT * FROM usuarios ORDER BY codUsuario DESC LIMIT 1";
    $result = mysqli_query($conn, $sql);
    $last_row = mysqli_fetch_assoc($result);
    $cod = $last_row["codUsuario"] + 1;
    try{
        $sql1="INSERT INTO usuarios (codUsuario, nombreUsuario, claveUsuario, tipoUsuario, categoriaCliente, estado, cantidadPromo) VALUES ('$cod', '{$_GET["email"]}', '{$_GET["claveUsuario"]}', '{$_GET["type"]}', 'Inicial', 'A', '0')";
        mysqli_query($conn, $sql1);
        header("LOCATION: https://rosarioshoppingcenter.shop/inicio_de_sesion/inicio_sesion.php");
    }
    catch(mysqli_sql_exception){
        header("LOCATION: https://rosarioshoppingcenter.shop/inicio_de_sesion/inicio_sesion.php");
    }
?>