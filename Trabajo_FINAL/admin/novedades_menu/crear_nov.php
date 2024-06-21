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
    <title>Rosario Shopping Center - Crear Novedad</title>
</head>
<body>

    <?php
        include("../../Barra_Navegacion/Nav-bar.php");
    ?>

    <section>
        <h1 class="page_title">Novedades</h1>
        <div class="form_back">
            <button class="btn btn-outline-secondary">
                <svg class="arrow_symbol" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/>
                </svg>
                <a href="admin_nov.php" class="volver_btn" aria-label="Volver"></a>
                Volver
            </button>
        </div>

        <div class="create_box">
            <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" class="form_create">
                <h2 class="create_subtitle">Crear Novedad</h2>
                <label class="create_label" for="titulo">Título:</label>
                <input type="text" placeholder="..." class="form-create__input" id="titulo" name="titulo" maxlength="30" required>
                <label class="create_label" for="descripcion">Descripción:</label>
                <input type="text" placeholder="..." class="form-create__input" id="descripcion" name="texto" maxlength="200" required>
                <label class="create_label" for="inicio">Inicio:</label>
                <input type="date" placeholder="..." class="form-create__input" id="inicio" name="desde" required>
                <label class="create_label" for="final">Finalización:</label>
                <input type="date" placeholder="..." class="form-create__input" id="final" name="hasta" required>
                <label class="create_label" for="categoria-usuario">Categoría de Cliente:</label>
                <select  class="form-create__input" id="categoria-usuario" name="categoria" required>
                    <option value="Inicial">Inicial</option>
                    <option value="Medium">Medium</option>
                    <option value="Premium">Premium</option>
                </select>
                <input type="submit" value="Crear Novedad" class="form-create__button" name="crear">
            </form>
        </div>
    </section>

    <?php
        if (isset($_POST["crear"])) {
            $sql = "SELECT * FROM novedades ORDER BY codNovedad DESC LIMIT 1";
            $result = mysqli_query($conn, $sql);
            $last_row = mysqli_fetch_assoc($result);
            
            $cod = $last_row["codNovedad"] + 1;
            $titulo = filter_input(INPUT_POST, "titulo", FILTER_SANITIZE_SPECIAL_CHARS);
            $texto = filter_input(INPUT_POST, "texto", FILTER_SANITIZE_SPECIAL_CHARS);
            $desde = $_POST["desde"];
            $hasta = $_POST["hasta"];
            $cat_user = $_POST["categoria"];
            $sql = "INSERT INTO novedades (codNovedad, tituloNovedad, textoNovedad, fechaDesdeNov, fechaHastaNov, tipoUsuario, estadoNovedad)
                    VALUES ('$cod', '$titulo', '$texto', '$desde', '$hasta', '$cat_user', 'A')";
            
            try {
                mysqli_query($conn, $sql);
                $_SESSION["novCreada"] = 1;
                header("Location: admin_nov.php");
            }
            catch(mysqli_sql_exception) {
                echo "<p class='msj_error'>Error al crear la novedad, inténtelo más tarde.</p>";
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