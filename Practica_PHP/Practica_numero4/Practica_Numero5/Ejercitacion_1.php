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
    <form action="<?php $_SERVER["PHP_SELF"]?>" method="POST">
        <label>Email</label>
        <input type="email" name="email" placeholder="email"><br>
        <label>Asunto</label>
        <input type="text" name="asunto" placeholder="asunto"><br>
        <label>Mensaje</label><br>
        <textarea name="cuerpo" rows="8" style="max-height: 200px;"></textarea> <br>
        <input type="submit" name="submit" value="Enviar">
    </form>
    <?php
    if (isset($_POST["submit"])) {
        $destinatario = $_POST["email"];
        $asunto = $_POST["asunto"];
        $cuerpo = "
        <!DOCTYPE html>
        <html>
        <head>
            <title>Prueba de correo</title>
        </head>
        <body>
            <h1>Prueba de correo</h1>
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