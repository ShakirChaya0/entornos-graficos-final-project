<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 3</title>
</head>
<body>
    <h1>El último usuario <?php if(isset($_COOKIE["Nombre"])) echo "es {$_COOKIE["Nombre"]}"; else echo "eres Tú!"; ?></h1>
    <form action="<?php $_SERVER["PHP_SELF"] ?>" method="post" style="margin:auto;margin-top: 100px; border: 2px solid black; padding: 10px;">
        <label>Nombre de usuario: </label>
        <input type="text" name="Nombre">
        <input type="submit" name="Enviar">
    </form>
    <?php
        if(isset($_POST["Enviar"])){
            setcookie("Nombre",$_POST["Nombre"],time()+86400*365);
        }
    ?>
</body>
</html>