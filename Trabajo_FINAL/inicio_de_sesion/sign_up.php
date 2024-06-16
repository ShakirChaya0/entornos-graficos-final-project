<?php
    include("../database.php");
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../Imagenes-Videos/bolsas-de-compra.png">
    <link rel="stylesheet" href="log_in.css">
    <title>Registrarse</title>
</head>
<body>
    <header>

    </header>
    <section class="box">
        <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post" class="form">
            <div class="logo-cont">
                <a href="../Home-UNR/index.php"><img src="../Imagenes-Videos/logo.jpg" alt="logo" class="logo"></a>
            </div>
            <div class="username_form">
                <img src="../Imagenes-Videos/avatar.png" alt="Avatar.png" class="avatar-de-email">
                <input type="text" class="form-control" id="floatingInput" name="username" required maxlength="100">
                <label for="floatingInput">Email del Usuario</label>
            </div>
            <div class="password_form">
                <img src="../Imagenes-Videos/candado.png" alt="candado.png" id="togglePassword" class="avatar-de-email">
                <input type="password" class="form-control" id="password" name="password" required maxlength="8">
                <label for="password">Contraseña</label><br>
            </div>
            <script>
                document.getElementById('togglePassword').addEventListener('click', function () {
                    const passwordField = document.getElementById('password');
                    const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordField.setAttribute('type', type);
                    if (type === 'text') {
                        this.src = '../Imagenes-Videos/desbloquear.png'; 
                    } else {
                        this.src = '../Imagenes-Videos/candado.png'; 
                    }   
                });
            </script>
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
                        $_SESSION["nombreUsuario"] = $_POST["username"];
                        $_SESSION["claveUsuario"] = $_POST["password"];
                        $_SESSION["tipoUsuario"] = $_POST["type"];
                        $_POST = array();
                        $valid = "SELECT * FROM usuarios WHERE nombreUsuario = '{$_SESSION["nombreUsuario"]}'";
                        $valid_query = mysqli_query($conn, $valid);
                        if(!empty($_SESSION["nombreUsuario"]) && !empty($_SESSION["claveUsuario"]) && !empty($_SESSION["tipoUsuario"])){
                            if(mysqli_num_rows($valid_query) > 0){
                                echo"<p class= 'enviado'>*Usuario ya existente</p>";
                            }
                            else{
                                if($_SESSION["tipoUsuario"] == "Cliente"){
                                    $destinatario = "josebpp198@gmail.com";
                                    $asunto = "Email de prueba";
                                    $cuerpo = "
                                    <html>
                                        <head>
                                            <title>Prueba de correo</title>
                                        </head>
                                        <body>
                                            <img src='../Imagenes-Videos/bolsas-de-compra.png' alt='logo.png'>
                                            <h2>Validar cuenta de cliente {$_SESSION["nombreUsuario"]}</h2>
                                            <a href='https://rosarioshoppingcenter.shop/inicio_de_sesion/Validacion.php'>Validar Cuenta</a>
                                        </body>
                                    </html>
                                    ";
                                    $headers = "MIME-Version: 1.0" . "\r\n";
                                    $headers .= "Content-type:text/html;charset=utf-8" . "\r\n";
                                    $headers .= 'From: cliente' ."\r\n";
                                    $headers .= "Return-path: $destinatario" . "\r\n";
                                    @mail($destinatario, $asunto, $cuerpo, $headers);
                                    echo"<p class= 'enviado'>*enviado correctamente</p>";
                                }
                                else{
                                    $sql = "INSERT INTO usuarios (nombreUsuario, claveUsuario, tipoUsuario, categoriaCliente, estado, cantidadPromo) VALUES ('{$_SESSION["nombreUsuario"]}', '{$_SESSION["claveUsuario"]}', '{$_SESSION["tipoUsuario"]}', 'ninguno', 'P', '0')";
                                    $query = mysqli_query($conn, $sql);
                                    echo "<p class= 'enviado'>*enviado correctamente</p>";
                                }
                            }
                        }
                        else{
                            echo "<p class= 'error'>*Completa el tipo de usuario</p>";
                        }
                    }
                        
                ?>
            </div>
            </div>
        </form>
    </section>
</body>
</html>

