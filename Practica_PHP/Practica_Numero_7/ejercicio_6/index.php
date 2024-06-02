<?php
    session_start();
    include("database.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 6</title>
</head>
<body>
    <h1>Formulario de Ingreso</h1>
    <form action="<?php $_SERVER["PHP_SELF"] ?>" method="post">
        <label for="email">Email del Alumno: </label>
        <input type="email" id="email" name="mail">
        <input type="submit" name="send" value="Ingresar">
    </form>

    <?php
        if (isset($_POST["send"])) {
            $sql = "SELECT * FROM base2 WHERE mail = '{$_POST["mail"]}'";
            $result = mysqli_query($connection, $sql);
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $_SESSION["nombreAlumno"] = $row["nombre"];
            }
            else {
                echo "No existe ningún alumno con ese mail.";
            }
        }
    ?>

    <a href="bienvenida_alumno.php">Bienvenida Alumno</a>
</body>
</html>
