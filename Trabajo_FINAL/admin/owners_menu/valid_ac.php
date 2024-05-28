<?php
    ob_start();
    session_start();
    include("../database.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["accept_account"])) {
            $estado = "A";
            $cuerpo = "Su cuenta de Dueño de Local fue validada. Ya puede ingresar y comenzar a gestionar sus locales. ¡Gracias por sumarse a nosotros!";
            $_SESSION["ownerAceptado"] = 1;
        }
        else {
            $estado = "R";
            $cuerpo = "Su solicitud de una cuenta de Dueño de Local fue rechazada. Comuníquese a través del formulario de contacto si así lo requiere.";
            $_SESSION["ownerRechazado"] = 1;
        }
        
        $destinatario = $_POST["nombreUsuario"];
        $asunto = "Validación/Rechazo de Cuenta";
        $headers = 'From: rosarioShoppingCenter@gmail.com' . "\r\n" .
                    'Reply-To: no_reply@gmail.com' . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();

        if (mail($destinatario, $asunto, $cuerpo, $headers)) {
            echo "Correo enviado exitosamente a $email";
        } else {
            echo "Error al enviar el correo.";
        }
        
        $sql = "UPDATE usuarios 
                SET estado = '$estado'
                WHERE codUsuario = '{$_POST["codUsuario"]}'";

        try {
            mysqli_query($connection, $sql);
        }
        catch (mysqli_sql_exception) {
            echo "Error al intentar realizar la operación, inténtelo más tarde.";
        }
    }

    ob_end_flush();
?>