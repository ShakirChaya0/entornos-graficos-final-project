<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Creando variables de sesión...</h1>
    <p>Para recuperar las variables de sesión ingrese aquí: <a href="Pagina_3.php">Página 3</a></p>
    <?php 
    if(isset($_POST["Enviar"])){
        if(empty($_SESSION["Nombre_Ant"])){
            $_SESSION["Nombre_Ant"] = $_POST["Nombre"]; 
            $_SESSION["Clave_Ant"] = $_POST["Clave"]; 
        } else {
            $_SESSION["Nombre"] = $_POST["Nombre"]; 
            $_SESSION["Clave"] = $_POST["Clave"];
        }
    } 
    ?>


</body>
</html>