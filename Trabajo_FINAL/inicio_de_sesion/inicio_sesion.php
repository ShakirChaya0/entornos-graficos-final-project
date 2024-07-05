<?php
    ob_start();
    session_start();
    include("../database.php");
    session_unset();
    $_SESSION["tipoUsuario"] = "UNR";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../Imagenes-Videos/bolsas-de-compra.png">
    <link rel="stylesheet" href="log_in.css">
    <title>Inicio de sesion | Rosario Shopping Center</title>
</head>
<body>
    <main>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post" class="form" >
            <div class="logo-cont" title="Enlace a la pagina principal">
                <a href="../Home-UNR/index.php" aria-label="Enlace a la pagina principal"><img src="../Imagenes-Videos/logo.jpg" alt="Enlace a la página principal" class="logo"></a>
                <h1 style="display: none">Rosario Shopping Center</h1>
            </div>
            <div class="username_form">
                <img src="../Imagenes-Videos/avatar.png" alt="Imagen de avatar de usuario" class="avatar-de-email" title="Avatar de usuario">
                <input type="text" required class="form-control" id="floatingInput" aria-labelledby="email-label" name="username" autocomplete="off" aria-required="true">
                <label for="floatingInput" id="email-label">Email del Usuario</label>
            </div>
            <div class="password_form">
                <img src="../Imagenes-Videos/candado.png" alt="Ver contraseña" class="avatar-de-email" id="togglePassword" title="Dejar ver contraseña">
                <input type="password" required class="form-control" id="password" aria-labelledby="pass-label" name="password" aria-required="true">
                <label for="password" id="pass-label">Contraseña</label>
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
                <input type="submit" value="Iniciar sesion" class="submit" name="submit" aria-label="Iniciar Sesión">
                <p class="regis">¿Aun no te registraste?<a href="sign_up.php" aria-label="Enlace para registrarse"> Registrarse</a></p>
            <div class="cont_error">
                <?php
                    if(!empty($_POST["submit"])){
                        $username = $_POST["username"];
                        $password = $_POST["password"];
                        if(!empty($username) && !empty($password)){
                            $sqli = "SELECT * FROM usuarios WHERE (nombreUsuario, claveUsuario) = ('$username', '$password')";
                            $result = mysqli_query($conn, $sqli);
                            if(mysqli_num_rows($result) < 1){
                                echo"<p class='error'>* No existe dicho usuario</p>";
                            }
                            else{
                                $row_promos = mysqli_fetch_assoc($result);
                                $_SESSION["codUsuario"] = $row_promos["codUsuario"];
                                $_SESSION["nombreUsuario"] = $row_promos["nombreUsuario"];
                                $_SESSION["claveUsuario"] = $row_promos["claveUsuario"];
                                $_SESSION["tipoUsuario"] = $row_promos["tipoUsuario"];
                                $_SESSION["categoriaCliente"] = $row_promos["categoriaCliente"];
                                $_SESSION["estado"] = $row_promos["estado"];
                                $_SESSION["cantidadPromo"] = $row_promos["cantidadPromo"];
                                $_SESSION["editarPerfil"] = 0;
                                mysqli_close($conn);
                                if($row_promos["tipoUsuario"] == "Administrador"){
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
                                    $_SESSION["fechavalida"] = 0;
                                    $_SESSION["no_dueño"] = 0;
                                    header("LOCATION: ../admin/home/home_page_admin.php");
                                }
                                elseif($row_promos["tipoUsuario"] == "Cliente"){
                                    header("LOCATION: ../Client/Home/Home.php");
                                }
                                elseif($row_promos["tipoUsuario"] == "Dueño de local"){
                                    if($row_promos["estado"] == "A"){
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
                                        $_SESSION["fechavalida"] = 0;
                                        $_SESSION["no_dueño"] = 0;
                                        header("LOCATION: ../Owner/Home/Home.php");
                                    }
                                    else{
                                        echo"<p class='error'>* Tu cuenta debe ser validada</p>";
                                    }
                                }
                            }
                        }
                    }
                ?>
            </div>
            </div>
        </form>
    </main>
</body>
</html>
<?php
    ob_end_flush();
?>
