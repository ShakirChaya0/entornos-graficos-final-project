<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 2</title>
</head>
<body>
    <form action="Pagina_2.php" method="post" style="margin: auto;margin-top: 100px; border: 2px solid black; padding: 10px;">
        <label>Nombre de usuario: </label>
        <input type="text" name="Nombre">
        <label>Contraseña: </label>
        <input type="password" name="Clave">
        <input type="submit" name="Enviar">
    </form>

</body>
</html>