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
    <form action="<?php $_SERVER["PHP_SELF"]?>" method="POST" style="margin:auto;padding: 2rem;max-width:200px; border: 1px solid black;">
        <h2>Formulario de contacto</h2>
            <label>Asunto</label><br>
            <input type="text" name="asunto" placeholder="asunto"><br>
            <label>Mensaje</label><br>
            <textarea name="cuerpo" rows="8" style="max-height: 200px;"></textarea> <br>
            <input type="submit" name="submit" value="Enviar">
        </form>
    <?php
        if(isset($_POST["submit"])){
            $asunto = $_POST["asunto"];
            $cuerpo = $_POST["cuerpo"];
            $mail = "admin@shopping.com";
            $headers = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
            $headers .= 'From: tu_correo@ejemplo.com' . "\r\n";
            $headers .= 'Reply-To: tu_correo@ejemplo.com' . "\r\n";
            $headers .= 'X-Mailer: PHP/' . phpversion();
            mail($mail, $asunto, $cuerpo, $headers);
        }
    ?>
</body>
</html>