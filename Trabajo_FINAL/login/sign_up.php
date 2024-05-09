<?php
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
    <title>Registrarse</title>
</head>
<body>
    <header>

    </header>
    <section class="box">
        <form action="sign_up.php" method="post" class="form">
            <div class="logo-cont">
                <a href="../unrClient/Home/index.php"><img src="logo.jpg" alt="logo" class="logo"></a>
            </div>
            <div class="username_form">
                <input type="email" class="form-control" id="floatingInput" name="username">
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
                    include("validacion.php");
                    if(isset($_POST["submit"])){
                        if(!empty($username) && !empty($password)){
                            $sqli = "SELECT * FROM users WHERE (user, password) = ('$username','$password')";
                            $result = mysqli_query($conn, $sqli);
                            if(mysqli_num_rows($result) > 0){   
                                echo"<p class = 'error'>* Ya existe dicho usuario</p>";
                            }
                            else{
                                $type = $_POST["type"];
                                  $sql = "INSERT INTO users (user, password, type) VALUES ('$username', '$password', '$type')";
                                  try{
                                      mysqli_query($conn, $sql);
                                      echo"<p class='register'>* Te registraste exitosamente</p>";
                                      mysqli_close($conn);
                                  }
                                  catch(mysqli_sql_exception){
                                      echo" No se pudo registrar";
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

