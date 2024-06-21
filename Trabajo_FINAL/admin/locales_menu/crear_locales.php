<?php
    ob_start();
    session_start();
    if (!isset($_SESSION["codUsuario"]) || $_SESSION["codUsuario"] != 1) {
        session_destroy();
        header("Location: ../../inicio_de_sesion/inicio_sesion.php");
    }
    include("../../database.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../Imagenes-Videos/bolsas-de-compra.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../crear_style.css">
    <link rel="stylesheet" href="../../Barra_Navegacion/Bar-style.css">
    <link rel="stylesheet" href="../../Pie_De_Pagina/footer.css">
    <title>Rosario Shopping Center - Crear Local</title>
</head>
<body>
    
    <?php
        include("../../Barra_Navegacion/Nav-bar.php");
    ?>

    <section>
        <h1 class="page_title">Locales</h1>
        <div class="form_back">
            <button class="btn btn-outline-secondary">
                <svg class="arrow_symbol" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/>
                </svg>
                <a href="admin_locales.php" class="volver_btn" aria-label="Volver"></a>
                Volver
            </button>
        </div>

        <div class="create_box">
            <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" class="form_create">
                <h2 class="create_subtitle">Crear Local</h2>
                <label class="create_label" for="nombre">Nombre de Local:</label>
                <input type="text" placeholder="..." class="form-create__input" id="nombre" name="name" maxlength="100" required>
                <label class="create_label" for="ubi">Ubicación:</label>
                <input type="text" placeholder="..." class="form-create__input" id="ubi" name="ubi" maxlength="50" required>
                <label class="create_label" for="rubro">Rubro:</label>
                <input type="text" placeholder="..." class="form-create__input" id="rubro" name="rubro" maxlength="20" required>
                <label class="create_label" for="usuario">Código de Usuario:</label>
                <input type="number" placeholder="..." class="form-create__input" id="usuario" name="user" min="2" required>
                <input type="submit" value="Crear Local" class="form-create__button" name="crear">
            </form>
        </div>
    </section>

    <?php

        if (isset($_POST["crear"])) {
            $sql = "SELECT * FROM locales ORDER BY codLocal DESC LIMIT 1";
            $result = mysqli_query($conn, $sql);
            $last_row = mysqli_fetch_assoc($result);
            
            $cod = $last_row["codLocal"] + 1;
            $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_SPECIAL_CHARS);
            $ubi = filter_input(INPUT_POST, "ubi", FILTER_SANITIZE_SPECIAL_CHARS);
            $rubro = filter_input(INPUT_POST, "rubro", FILTER_SANITIZE_SPECIAL_CHARS);
            $user = $_POST["user"];
            
            $sql_aux = "SELECT * FROM usuarios WHERE codUsuario = '$user' AND tipoUsuario = 'dueño de local'";
            $result_aux = mysqli_query($conn, $sql_aux);
            if (mysqli_num_rows($result_aux) > 0) {
                $sql = "INSERT INTO locales (codLocal, nombreLocal, ubicacionLocal, rubroLocal, codUsuario, estadoLocal)
                        VALUES ('$cod', '$name', '$ubi', '$rubro', '$user', 'A')";

                try {
                    mysqli_query($conn, $sql);
                    $_SESSION["localCreado"] = 1;
                    header("Location: admin_locales.php");
                }
                catch(mysqli_sql_exception) {
                    echo "<p class='msj_error'>El nombre del local no puede repetirse. Ingrese uno nuevo.</p>";
                }
            }
            else {
                echo "<p class='msj_error'>No existe un dueño con el código ingresado. Ingrese uno nuevo.</p>";
            }
        } 
    ?>

    <?php
        include("../../Pie_De_Pagina/footer.php");
    ?>

</body>
</html>
<?php
    ob_end_flush();
?>