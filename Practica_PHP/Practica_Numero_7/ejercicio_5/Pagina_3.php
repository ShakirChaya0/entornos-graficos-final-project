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
    <h1>Session anterior: </h1>
    <?php
    if($_SESSION["Nombre"] == $_SESSION["Nombre_Ant"]){
        echo "Eres la primera persona en entrar a esta página.";
    } else {
        echo "Los datos de la sesion anterior son: <br>";
        echo "Nombre: {$_SESSION["Nombre_Ant"]} <br>";
        echo "Clave: {$_SESSION["Clave_Ant"]} <br>";
    }
    $_SESSION["Nombre_Ant"] = $_SESSION["Nombre"]; 
    $_SESSION["Clave_Ant"] = $_SESSION["Clave"]; 
    ?>
    <a href="Pagina_1.php">Volver a la página principal</a>

</body>
</html>