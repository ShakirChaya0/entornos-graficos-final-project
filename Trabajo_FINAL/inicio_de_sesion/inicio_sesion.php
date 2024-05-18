<?php
    session_start();
    include("database.php");
    session_unset();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="log_in.css">
    <title>Inicio de sesion</title>
</head>
<body>
    <section class="box">
        <form action="inicio_sesion.php" method="post" class="form">
            <div class="logo-cont">
                <a href="../Home/Home.php"><img src="logo.jpg" alt="logo" class="logo"></a>
            </div>
            <div class="username_form">
                <input type="text" required class="form-control" id="floatingInput"  name="username">
                <label class="label" for="floatingInput">Email del Usuario</label>
            </div>
            <div class="password_form">
                <input type="password" required class="form-control" id="floatingPassword" name="password">
                <label class="label" for="floatingPassword">Contraseña</label>
            </div>
            <div class="footer_form">
                <input type="submit" value="Iniciar sesion" class="submit" name="submit">
                <p class="regis">¿Aun no te registraste?<a href="sign_up.php"> Registrarse</a></p>
            <div class="cont_error">
                <?php
                    if($_SERVER["REQUEST_METHOD"] == "POST"){
                        $username = $_POST["username"];
                        $password = $_POST["password"];
                    }
                    if(!empty($username) && !empty($password)){
                        $sqli = "SELECT * FROM usuarios WHERE (nombreUsuario, claveUsuario) = ('$username', '$password')";
                        $result = mysqli_query($conn, $sqli);
                        if(mysqli_num_rows($result) < 1){
                            echo"<p class='error'>* No existe dicho usuario</p>";
                        }
                        else{
                            $row = mysqli_fetch_assoc($result);
                            $_SESSION["codusuario"] = $row["codusuario"];
                            $_SESSION["nombreUsuario"] = $row["nombreUsuario"];
                            $_SESSION["claveUsuario"] = $row["claveUsuario"];
                            $_SESSION["tipoUsuario"] = $row["tipoUsuario"];
                            $_SESSION["categoriaCliente"] = $row["categoriaCliente"];
                            $_SESSION["estado"] = $row["estado"];
                            $_SESSION["cantidadPromo"] = $row["cantidadPromo"];
                            mysqli_close($conn);
                            if($row["tipoUsuario"] == "administrador"){
                                header("LOCATION: admin.html");
                            }
                            elseif($row["tipoUsuario"] == "Cliente"){
                                header("LOCATION: ..\\Client\\Home\\Home.php");
                            }
                            elseif($row["tipoUsuario"] == "Dueño de local"){
                                if($row["estado"] == "A"){
                                    header("LOCATION: dueños.html");
                                }
                                else{
                                    echo"<p class='error'>* Tu cuenta debe ser validada</p>";
                                }
                            }
                            }
                        }
                ?>
            </div>
            </div>
        </form>
    </section>
</body>
</html>
