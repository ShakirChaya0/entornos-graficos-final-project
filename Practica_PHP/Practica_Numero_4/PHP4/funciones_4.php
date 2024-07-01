<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="<?php $_SERVER["PHP_SELF"]?>" method="POST">
        <label>Nombre</label>
        <input type="text" name="username">
        <input type="submit" name="submit" value="Enviar">
    </form>
<?php    
    function comprobar_nombre_usuario($nombre_usuario){
         //compruebo que el tamaño del string sea válido.
        if (strlen($nombre_usuario)<3 || strlen($nombre_usuario)>20){
            echo $nombre_usuario . " no es válido<br>";
            return false;
        }
         //compruebo que los caracteres sean los permitidos
        $permitidos = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-_";
        for ($i=0; $i<strlen($nombre_usuario); $i++){
            if (strpos($permitidos, substr($nombre_usuario,$i,1))===false){
            echo $nombre_usuario . " no es válido<br>";
            return false;
            }
        }
        echo $nombre_usuario . " es válido<br>";
        return true;
        }
    
    comprobar_nombre_usuario($_POST["username"]);

?> 
</body>
</html>