<?php
    session_start();
    include("../database.php");
    $sql="INSERT INTO usuarios (nombreUsuario, claveUsuario, tipoUsuario, categoriaCliente, estado, cantidadPromo) VALUES ('{$_SESSION["nombreUsuario"]}', '{$_SESSION["claveUsuario"]}', '{$_SESSION["tipoUsuario"]}', 'Inicial', 'A', '0')";
    mysqli_query($conn, $sql);
    header("LOCATION: https://rosarioshoppingcenter.shop/inicio_de_sesion/inicio_sesion.php");
?>