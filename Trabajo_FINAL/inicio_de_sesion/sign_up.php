<?php
    include("../database.php");
    session_start();
    $_SESSION["tipoUsuario"] = "UNR";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="log_in.css">
    <title>Registrarse</title>
</head>
<body>
    <header>

    </header>
    <section class="box">
        <form action="sign_up.php" method="post" class="form">
            <div class="logo-cont">
                <a href="../Home-UNR/index.php"><img src="../Imagenes-Videos/logo.jpg" alt="logo" class="logo"></a>
            </div>
            <div class="username_form">
                <img src="../Imagenes-Videos/avatar.png" alt="Avatar.png" class="avatar-de-email">
                <input type="text" class="form-control" id="floatingInput" name="username" required maxlength="100">
                <label for="floatingInput">Email del Usuario</label>
            </div>
            <div class="password_form">
            <img src="../Imagenes-Videos/candado.png" alt="candado.png" class="avatar-de-email">
                <input type="password" class="form-control" id="floatingPassword" name="password" required maxlength="8">
                <label for="floatingPassword">Contraseña</label><br>
            </div>
            <div class="user_type_box">
                <div class="owner_box">
                    <input id="owner" type="radio" name="type" class="user_type" value="Dueño de local">
                    <span></span>
                    <label for="owner">Dueño de Local</label>
                </div>
                <div class="client_box">
                    <input id="client" type="radio" name="type" class="user_type" value="Cliente" >
                    <span></span>
                    <label for="client">Cliente</label>
                </div>
            </div>
            <div class="footer_form">
                <input type="submit" value="Registrarse" class="submit" name="submit">
                <p class="regis">¿Desea iniciar sesion?<a href="inicio_sesion.php"> Iniciar sesion</a></p>
            <div class="cont_error">
                <?php
                    if(!empty($_POST["submit"])){
                        $username = $_POST["username"];
                        $password = $_POST["password"];
                        $type = $_POST["type"];
                        $_POST = array();
                        if(!empty($username) && !empty($password)){
                            $destinatario = "josebpp198@gmail.com";
                            $asunto = "Email de prueba";
                            $cuerpo = "
                            <html>
                                <head>
                                    <title>Prueba de correo</title>
                                </head>
                                <body>
                                    <h1>Email del admin</h1>
                                    <form method = 'post'>
                                        <input type='submit'>
                                    </form>
                                </body>
                            </html>
                            ";
                            $headers = "MIME-Version: 1.0\r\n";
                            $headers .= "Contetn-type: text/html; charset=utf-8\r\n";
                            $headers .= "From: cliente\r\n";
                            $headers .= "Return-path: $destinatario\r\n";
                            @mail($destinatario, $asunto, $cuerpo, $headers);
                            echo"enviado correctamente";
                        }
                    }
                        
                ?>
            </div>
            </div>
        </form>
    </section>
</body>
</html>

