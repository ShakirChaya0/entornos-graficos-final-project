<?php
    if(!isset($_COOKIE["contador"])){
        setcookie("contador",1,time()+86400*365);
    } else{
        setcookie("contador",$_COOKIE["contador"]+1,time()+86400*365);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 2</title>
</head>
<body>
    <?php
        if(!isset($_COOKIE["contador"])){
            echo "Bienvenido";
        }else{
            echo "Esta es la vez N°{$_COOKIE["contador"]}";
        }
    ?>
</body>
</html>