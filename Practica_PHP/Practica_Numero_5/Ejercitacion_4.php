<?php
    session_start();
    if (!isset($_SESSION["Visitas"])){
        $_SESSION["Visitas"] = 1;
    }
    else{
        $_SESSION["Visitas"]++;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        echo"Has visitado ".$_SESSION["Visitas"]." paginas";
    ?><br>
    <a href="Ejercitacion_1.php">Ejercitacion_1</a>
    <a href="Ejercitacion_2.php">Ejercitacion_2</a>
    <a href="Ejercitacion_3.php">Ejercitacion_3</a>
</body>
</html>