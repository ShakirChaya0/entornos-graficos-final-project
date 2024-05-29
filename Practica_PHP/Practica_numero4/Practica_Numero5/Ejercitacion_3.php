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
    <form action="<?php $_SERVER["PHP_SELF"]?>">
        <label for="email">Email</label><br>
        <input id="email" type="email" placeholder="Ingrese el email de tu amigo"><br>
        <label for="cuerpo">Mensaje de recomendacion</label><br>
        <textarea name="cuerpo" id="cuerpo" rows="8" style="max-height: 200px;"></textarea><br>
        <input type="submit">
    </form>
    <?php
        if (isset($_POST["submit"])) {
            $destinatario = $_POST["email"];
            $asunto = $_POST["cuerpo"];
            $cuerpo = "
            <!DOCTYPE html>
            <html>
            <head>
                <title>Recomendacion</title>
            </head>
            <body>
                <h1>Te recomiendo este sitio!!!</h1>
                <p>{$_POST['cuerpo']}</p>
            </body>
            </html>
            ";
            $headers = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
            $headers .= 'From: tu_correo@ejemplo.com' . "\r\n";
            $headers .= 'Reply-To: tu_correo@ejemplo.com' . "\r\n";
            $headers .= 'X-Mailer: PHP/' . phpversion();
            mail($destinatario, $asunto, $cuerpo, $headers);
        }
    ?>
</body>
</html>