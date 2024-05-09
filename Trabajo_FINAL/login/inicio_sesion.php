<?php
    session_start();
    include("database.php");
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $username = $_POST["username"];
        $password = $_POST["password"];
    }
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
                <a href="../unrClient/Home/index.php"><img src="logo.jpg" alt="logo" class="logo"></a>
            </div>
            <div class="username_form">
                <input type="email" class="form-control" id="floatingInput"  name="username">
                <label class="label" for="floatingInput">Email del Usuario</label>
            </div>
            <div class="password_form">
                <input type="password" class="form-control" id="floatingPassword" name="password">
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
                    include("validacion.php");
                    if(!empty($username) && !empty($password)){
                        $sqli = "SELECT * FROM users WHERE (user, password) = ('$username', '$password')";
                        $result = mysqli_query($conn, $sqli);
                        if(mysqli_num_rows($result) < 1){
                            echo"<p class='error'>* No existe dicho usuario</p>";
                        }
                        else{
                            $sql = "SELECT * FROM users WHERE (user, password) = ('$username','$password')";
                            $result = mysqli_query($conn, $sql);
                            if(mysqli_num_rows($result) > 0){
                                $row = mysqli_fetch_assoc($result);
                                mysqli_close($conn);
                                if($row["type"] == "administrador"){
                                    header("LOCATION: admin.html");
                                }
                                elseif($row["type"] == "cliente"){
                                    $_SESSION["username"] = "cliente";
                                    header("LOCATION: ..\\unrClient\\Home\\index.php");
                                }
                                elseif($row["type"] == "dueño"){
                                    header("LOCATION: dueños.html");
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
