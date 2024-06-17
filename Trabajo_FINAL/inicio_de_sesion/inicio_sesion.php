<?php
    ob_start();
    session_start();
    include("../database.php");
    session_unset();
    $_SESSION["tipoUsuario"] = "UNR";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../Imagenes-Videos/bolsas-de-compra.png">
    <link rel="stylesheet" href="log_in.css">
    <title>Inicio de sesion</title>
</head>
<body>
    <section class="box">
        <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post" class="form">
            <div class="logo-cont">
                <a href="../Home-UNR/index.php"><img src="../Imagenes-Videos/logo.jpg" alt="logo" class="logo"></a>
            </div>
            <div class="username_form">
                <img src="../Imagenes-Videos/avatar.png" alt="Avatar.png" class="avatar-de-email">
                <input type="text" required class="form-control" id="floatingInput"  name="username" autocomplete="off">
                <label for="floatingInput">Email del Usuario</label>
            </div>
            <div class="password_form">
                <img src="../Imagenes-Videos/candado.png" alt="candado.png" class="avatar-de-email" id="togglePassword">
                <input type="password" required class="form-control" id="password" name="password">
                <label for="password">Contraseña</label>
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
            <div class="footer_form">
                <input type="submit" value="Iniciar sesion" class="submit" name="submit">
                <p class="regis">¿Aun no te registraste?<a href="sign_up.php"> Registrarse</a></p>
            <div class="cont_error">
                <?php
                    if(!empty($_POST["submit"])){
                        $username = $_POST["username"];
                        $password = $_POST["password"];
                        $_POST = array();
                        if(!empty($username) && !empty($password)){
                            $sqli = "SELECT * FROM usuarios WHERE (nombreUsuario, claveUsuario) = ('$username', '$password')";
                            $result = mysqli_query($conn, $sqli);
                            if(mysqli_num_rows($result) < 1){
                                echo"<p class='error'>* No existe dicho usuario</p>";
                            }
                            else{
                                $row = mysqli_fetch_assoc($result);
                                $_SESSION["codUsuario"] = $row["codUsuario"];
                                $_SESSION["nombreUsuario"] = $row["nombreUsuario"];
                                $_SESSION["claveUsuario"] = $row["claveUsuario"];
                                $_SESSION["tipoUsuario"] = $row["tipoUsuario"];
                                $_SESSION["categoriaCliente"] = $row["categoriaCliente"];
                                $_SESSION["estado"] = $row["estado"];
                                $_SESSION["cantidadPromo"] = $row["cantidadPromo"];
                                mysqli_close($conn);
                                if($row["tipoUsuario"] == "administrador"){
                                    $_SESSION["promocionCreadaDueño"] = 0;
                                    $_SESSION["localCreado"] = 0;
                                    $_SESSION["localModificado"] = 0;
                                    $_SESSION["localRestablecido"] = 0;
                                    $_SESSION["localEliminado"] = 0;
                                    $_SESSION["novCreada"] = 0;
                                    $_SESSION["novModificada"] = 0;
                                    $_SESSION["novRestablecida"] = 0;
                                    $_SESSION["novEliminada"] = 0;
                                    $_SESSION["ownerAceptado"] = 0;
                                    $_SESSION["ownerRechazado"] = 0;
                                    $_SESSION["promoAceptada"] = 0;
                                    $_SESSION["promoDenegada"] = 0;
                                    header("LOCATION: ../admin/home_page_admin.php");
                                }
                                elseif($row["tipoUsuario"] == "Cliente"){
                                    header("LOCATION: ../Client/Home/Home.php");
                                }
                                elseif($row["tipoUsuario"] == "Dueño"){
                                    if($row["estado"] == "A"){
                                        $_SESSION["promocionCreadaDueño"] = 0;
                                        $_SESSION["localCreado"] = 0;
                                        $_SESSION["localModificado"] = 0;
                                        $_SESSION["localRestablecido"] = 0;
                                        $_SESSION["localEliminado"] = 0;
                                        $_SESSION["novCreada"] = 0;
                                        $_SESSION["novModificada"] = 0;
                                        $_SESSION["novRestablecida"] = 0;
                                        $_SESSION["novEliminada"] = 0;
                                        $_SESSION["ownerAceptado"] = 0;
                                        $_SESSION["ownerRechazado"] = 0;
                                        $_SESSION["promoAceptada"] = 0;
                                        $_SESSION["promoDenegada"] = 0;
                                        header("LOCATION: ../Owner/Home/Home.php");
                                    }
                                    else{
                                        echo"<p class='error'>* Tu cuenta debe ser validada</p>";
                                    }
                                }
                            }
                        }
                    }
                    else{
                        $_POST = array();
                    }
                ?>
            </div>
            </div>
        </form>
    </section>
</body>
</html>
<?php
    ob_end_flush();
?>
