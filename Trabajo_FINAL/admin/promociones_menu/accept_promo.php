<?php
    ob_start();
    session_start();
    include("../../database.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $sql = "SELECT * FROM usuarios WHERE codUsuario ='{$_POST["codOwner"]}'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);

        if (isset($_POST["accept_promo"])) {
            $estado = "aprobada";
            $cuerpo = "La solicitud de promoción (código: {$_POST["codPromo"]}) para su local '{$_POST["nombreLocal"]}' fue aprobada y ya se encuentra disponible para los clientes de nuestro Shopping.";
            $_SESSION["promoAceptada"] = 1;
        }
        else {
            $estado = "denegada";
            $cuerpo = "La solicitud de promoción (código: {$_POST["codPromo"]}) para su local '{$_POST["nombreLocal"]}' fue denegada por no cumplir con la política comercial del Shopping. Comuníquese con el administrador a través del formulario de contacto si así lo requiere.";
            $_SESSION["promoDenegada"] = 1;
        }

        $destinatario = $row["nombreUsuario"];
        $asunto = "Aprobación/Denegación de Promoción";
        $headers = 'From: rosarioShoppingCenter@gmail.com' . "\r\n" .
                    'Reply-To: no_reply@gmail.com' . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();

        /*if (mail($destinatario, $asunto, $cuerpo, $headers)) {
            echo "Correo enviado exitosamente a $email";
        } else {
            echo "Error al enviar el correo.";
        }*/

        $sql = "UPDATE promociones 
                SET estadoPromo = '$estado'
                WHERE codPromo = '{$_POST["codPromo"]}'";

        try {
            mysqli_query($conn, $sql);
            header("Location: admin_promo.php");
        }
        catch (mysqli_sql_exception) {
            echo "Error al intentar realizar la operación, inténtelo más tarde.";
        }

    }

    ob_end_flush();
?>