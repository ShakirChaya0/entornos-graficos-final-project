<?php
    ob_start();
    session_start();
    /*if (!isset($_SESSION["codUsuario"])) {
        session_destroy();
        header("Location: ../../inicio_de_sesion/inicio_sesion.php");
    }*/
    include("../../database.php");

    function valid_input($input) {
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input);

        return $input;
      }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../Imagenes-Videos/bolsas-de-compra.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="perfil_style.css">
    <link rel="stylesheet" href="../../Barra_Navegacion/Bar-style.css">
    <link rel="stylesheet" href="../../Pie_De_Pagina/footer.css">
    <title>Rosario Shopping Center - Perfil de Usuario</title>
</head>
<body>
    
    <?php
        include("../../Barra_Navegacion/Nav-bar.php");
    ?>

    <section>
        <h1 class="page_title">Perfil</h1>
        
        <div class="create_box">
            <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" class="form_create">
                <h2 class="create_subtitle">Datos de Usuario</h2>
                <label class="create_label" for="nombre">Nombre de Usuario:</label>
                <input type="text" placeholder="..." class="form-create__input" id="nombre" name="name" maxlength="100" value="<?php echo $_SESSION["nombreUsuario"] ?>" required <?php if ($_SESSION["editarPerfil"] == 0) echo "disabled readonly"?>>
                <label class="create_label" for="ubi">Contraseña:</label>
                <div class="password_form">
                    <img src="../../Imagenes-Videos/candado.png" alt="candado.png" class="avatar-de-email" id="togglePassword">
                    <input type="password" placeholder="..." class="form-create__input" id="password" name="password" maxlength="8" value="<?php echo $_SESSION["claveUsuario"] ?>" required <?php if ($_SESSION["editarPerfil"] == 0) echo "disabled readonly"?>>
                </div>
                <label class="create_label" for="rubro">Tipo de Usuario:</label>
                <div class="form-create__input" style="font-weight: 600;"><?php echo $_SESSION["tipoUsuario"] ?></div>
                <?php
                    if ($_SESSION["tipoUsuario"] == "Cliente") {
                        ?>
                            <label class="create_label" for="usuario">Categoría:</label>
                            <div class="form-create__input" style="font-weight: 600;"><?php echo $_SESSION["categoriaCliente"] ?></div>
                            <label class="create_label" for="usuario">Cantidad de promociones usadas:</label>
                            <div class="form-create__input" style="font-weight: 600;"><?php echo $_SESSION["cantidadPromo"] ?></div>
                        <?php
                    }
                ?>
                <div class="flexbox">
                    <button type="submit" name="editar" class="btn btn-primary editar" <?php if ($_SESSION["editarPerfil"] == 1) echo "disabled"?>>Editar</button>
                    <div>
                        <button type="submit" name="confirmar" class="btn btn-success confirmar" <?php if ($_SESSION["editarPerfil"] == 0) echo "disabled"?>>Confirmar</button>
                        <button type="submit" name="cancelar" class="btn btn-danger cancelar " <?php if ($_SESSION["editarPerfil"] == 0) echo "disabled"?>>Cancelar</button>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <?php
        if (isset($_POST["editar"])) {
            $_SESSION["editarPerfil"] = 1;
            header("Location: perfil.php");
        }
        elseif (isset($_POST["cancelar"])) {
            $_SESSION["editarPerfil"] = 0;
            header("Location: perfil.php");
        }
        elseif (isset($_POST["confirmar"])) {
            $sql_aux = "SELECT * FROM usuarios WHERE nombreUsuario = '{$_POST["name"]}'";
            $result = mysqli_query($conn, $sql_aux);

            if (mysqli_num_rows($result) == 0) {
                $password = $_POST["password"];
                $name = valid_input($_POST["name"]);
                
                if (!filter_var($name, FILTER_VALIDATE_EMAIL)) {
                    echo "<p class='msj_error'>Dirección de correo inválida.</p>";
                }
                else {
                    $sql = "UPDATE usuarios
                            SET nombreUsuario = '$name', claveUsuario = '$password' 
                            WHERE codUsuario = '{$_SESSION["codUsuario"]}'";

                    mysqli_query($conn, $sql);

                    $_SESSION["nombreUsuario"] = $name;
                    $_SESSION["claveUsuario"] = $password;
                    $_SESSION["editarPerfil"] = 0;

                    header("Location: perfil.php");

                }
            }
            else {
                echo "<p class='msj_error'>Nombre de usuario ya existente, ingrese uno nuevo.</p>";
            }
        }
    ?>

    <script>
        document.getElementById('togglePassword').addEventListener('click', function () {
            const passwordField = document.getElementById('password');
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            if (type === 'text') {
                this.src = '../../Imagenes-Videos/desbloquear.png'; 
            } else {
                this.src = '../../Imagenes-Videos/candado.png'; 
            }   
        });
    </script>

    <?php
        include("../../Pie_De_Pagina/footer.php");
    ?>

</body>
</html>
<?php
    ob_end_flush();
?>