<?php
if(isset($_POST["estilo"])){
    $estilo = $_POST["estilo"];
    setcookie("estilo", $estilo, time() + (86400 * 365));
}else{
    if (isset($_COOKIE["estilo"])){
    $estilo = $_COOKIE["estilo"];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Ejercicio 1 - Practica 7</title>
        <?php
        if (isset($estilo)){
        echo "<link rel='STYLESHEET' type='text/css' href='$estilo.css'>";
        }
        ?>
    </head>
    <body>
        <p>Ejercicio número 1 de la práctica 7. Página de prueba para elegir estilos.</p>
        <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="post">
            <label for="select_estilo">Seleccione el estilo que más le guste para el sitio: </label>
            <select name="estilo" id="select_estilo">
                <option value="verde">Verde
                <option value="rosa">Rosa
                <option value="negro">Negro
            </select>
            <input type="submit" value="Actualizar el estilo">
        </form>
    </body>
</html>