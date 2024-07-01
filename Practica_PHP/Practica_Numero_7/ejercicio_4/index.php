<?php
    if (isset($_POST["titular"])) {
        setcookie("titular", $_POST["titular"], time() + (86400 * 365), "/");
        $titular = $_POST["titular"];
    }
    elseif (isset($_COOKIE["titular"])) {
        $titular = $_COOKIE["titular"];
    }
    else {
        $titular = "Noticia Política, Noticia Económica, Noticia Deportiva";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 4</title>
</head>
<body>
    <h1><?php echo $titular ?></h1>
    <h3>Seleccione que noticias quiere que muestre el sitio:</h3>
    <form action="<?php $_SERVER["PHP_SELF"] ?>" method="post">
        <input type="radio" id="politica" value="Noticia Política" name="titular">
        <label for="politica">Políticas</label>
        <input type="radio" id="economica" value="Noticia Económica" name="titular">
        <label for="economica">Económicas</label>
        <input type="radio" id="deportiva" value="Noticia Deportiva" name="titular">
        <label for="deportiva">Deportivas</label>
        <input type="submit" value="Enviar">
    </form>
    <br>
    <br>
    <h4>Artículo: </h4>
    <article>
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Sit nisi natus at quas fugiat quisquam adipisci quidem ut voluptatem ullam qui minima, sapiente temporibus autem iste saepe cum, sint facilis! 
        Lorem ipsum, dolor sit amet consectetur adipisicing elit. Sit possimus dolorem nam amet non! Id neque debitis provident illum quibusdam nostrum dignissimos voluptas eaque cumque blanditiis corrupti voluptatem, sed ipsum.
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Recusandae nobis voluptatum veniam voluptatibus ea eius vero iusto laborum at, perspiciatis suscipit ex accusantium reprehenderit totam, harum facere dicta modi molestias!
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Quaerat in provident dolor sint ab deleniti expedita, soluta accusantium eum, molestias assumenda sed voluptates molestiae? Qui veniam impedit officia earum soluta?
    </article>
    <footer style="margin-top: 100px;">
        <a href="delete_cookie.php">Eliminar selección</a>
    </footer>
</body>
</html>