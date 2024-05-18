<?php
    include("database.php");
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
                <a href="../Home/Home.php"><img src="logo.jpg" alt="logo" class="logo"></a>
            </div>
            <div class="username_form">
                <input type="text" class="form-control" id="floatingInput" name="username">
                <label class="label" for="floatingInput">Email del Usuario</label>
            </div>
            <div class="password_form">
                <input type="password" class="form-control" id="floatingPassword" name="password">
                <label class="label" for="floatingPassword">Contraseña</label><br>
            </div>
            <div class="user_type_box">
                <div class="owner_box">
                    <input id = "owner" type="radio" name="type" class="user_type" value="Dueño de local">
                    <span></span>
                    <label for="owner">Dueño de Local</label>
                </div>
                <div class="client_box">
                    <input id = "client"type="radio" name="type" class="user_type" value="Cliente">
                    <span></span>
                    <label for="client">Cliente</label>
                </div>
            </div>
            <div class="footer_form">
                <input type="submit" value="Registrarse" class="submit" name="submit">
                <p class="regis">¿Desea iniciar sesion?<a href="inicio_sesion.php"> Iniciar sesion</a></p>
            <div class="cont_error">
                <?php
                    if($_POST["submit"] == "Registrarse"){
                        $username = $_POST["username"];
                        $password = $_POST["password"];
                        $type = $_POST["type"];
                        $_POST = array();
                        if(!empty($username) && !empty($password)){
                            $sqli = 'SELECT * FROM usuarios WHERE (nombreUsuario, claveUsuario) = ("'.$username.'","'.$password.'")';
                            $result = mysqli_query($conn, $sqli);
                            if(mysqli_num_rows($result) > 0){   
                                echo"<p class = 'error'>* Ya existe dicho usuario</p>";
                            }
                            else{
                                if($type == "Cliente"){
                                    $sql = 'INSERT INTO usuarios (nombreUsuario,claveUsuario, tipoUsuario, categoriaCliente, estado) VALUES ("'.$username.'", "'.$password.'", "'.$type.'", "inicial", "A")';
                                    try{
                                        mysqli_query($conn, $sql);
                                        echo"<p class='register'>* Te registraste exitosamente</p>";
                                        mysqli_close($conn);
                                    }
                                    catch(mysqli_sql_exception){
                                        echo" No se pudo registrar";
                                    }
                                }
                                else{
                                    $sql = 'INSERT INTO usuarios (nombreUsuario,claveUsuario, tipoUsuario, categoriaCliente, estado) VALUES ("'.$username.'", "'.$password.'", "'.$type.'", "inicial", "E")';
                                    try{
                                        mysqli_query($conn, $sql);
                                        echo"<p class='register'>* Se ha enviado la solicitud de dueño</p>";
                                        mysqli_close($conn);
                                    }
                                    catch(mysqli_sql_exception){
                                        echo" No se pudo registrar";
                                    }
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

