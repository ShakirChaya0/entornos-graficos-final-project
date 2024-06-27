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
    <title>Rosario Shopping Center - Modificar Novedad</title>
</head>
<body>
    
    <?php
        include("../../Barra_Navegacion/Nav-bar.php");
    ?>

    <section>
        <h1 class="page_title">Novedades</h1>
        <div class="form_back">
            <span class="btn btn-outline-secondary">
                <svg class="bi bi-arrow-left arrow_symbol" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/>
                </svg>
                <a href="admin_nov.php" class="volver_btn" aria-label="Volver"></a>
                Volver
            </span>
        </div>

        <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $cod_nov = $_POST["codNovedad"];
                $sql = "SELECT * FROM novedades WHERE codNovedad = '$cod_nov'";

                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
            }
        ?>

        <div class="create_box">
        <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" class="form_create">
                <h2 class="create_subtitle">Modificar Novedad</h2>
                <label class="create_label" for="titulo">Título:</label>
                <input type="text" placeholder="..." class="form-create__input" id="titulo" name="titulo" maxlength="30" value="<?php echo $row["tituloNovedad"] ?>" required>
                <label class="create_label" for="descripcion">Descripción:</label>
                <textarea type="text" placeholder="..." class="form-create__input" id="descripcion" name="texto" maxlength="200" required><?php echo $row["textoNovedad"] ?></textarea>
                <label class="create_label" for="inicio">Inicio:</label>
                <input type="date" placeholder="..." class="form-create__input" id="inicio" name="desde" value="<?php echo $row["fechaDesdeNov"] ?>" required>
                <label class="create_label" for="final">Finalización:</label>
                <input type="date" placeholder="..." class="form-create__input" id="final" name="hasta" value="<?php echo $row["fechaHastaNov"] ?>" required>
                <label class="create_label" for="categoria-usuario">Categoría de Cliente:</label>
                <select  class="form-create__input" id="categoria-usuario" name="categoria" required>
                    <option value="Inicial" <?php if ($row["tipoUsuario"] == "Inicial") echo "selected" ?>>Inicial</option>
                    <option value="Medium" <?php if ($row["tipoUsuario"] == "Medium") echo "selected" ?>>Medium</option>
                    <option value="Premium" <?php if ($row["tipoUsuario"] == "Premium") echo "selected" ?>>Premium</option>
                </select>
                <?php
                    if($row["estadoNovedad"] == "B") {
                        ?>
                            <h4 class="aviso_alta_local">Novedad dada de baja, ¿Desea restablecerla?</h4>
                            <div class="dar-alta">
                                <input class="form-check-input" type="checkbox" value="A" id="flexCheckDefault" name="darAlta">
                                <label class="dar-alta__label" for="flexCheckDefault">Restablecer</label>
                            </div>
                        <?php
                    }
                ?>
                <?php
                    if($row["estadoNovedad"] == "NV") {
                        ?>
                            <h6 class="aviso_term_nov">Novedad no vigente, actualice su fecha de inicio y/o fin para darle vigencia nuevamente.</h6>
                        <?php
                    }
                ?>
                <input type="hidden" name="codNovedad" value="<?php echo $cod_nov ?>">
                <input type="submit" value="Modificar" class="form-modify__button" name="modify">
            </form>
        </div>
    </section>

    <?php
        if (isset($_POST["modify"])) {
            if (!empty($_POST["titulo"]) && !empty($_POST["texto"]) && !empty($_POST["desde"]) && !empty($_POST["hasta"]) && !empty($_POST["categoria"])) {
                $cod_nov = $_POST["codNovedad"];
                $titulo = filter_input(INPUT_POST, "titulo", FILTER_SANITIZE_SPECIAL_CHARS);
                $texto = filter_input(INPUT_POST, "texto", FILTER_SANITIZE_SPECIAL_CHARS);
                $desde = $_POST["desde"];
                $hasta = $_POST["hasta"];
                $cat_user = $_POST["categoria"];

                
                if ($row["estadoNovedad"] == "B") {
                    $estado = !empty($_POST["darAlta"]) ? htmlspecialchars($_POST["darAlta"]) : "B";
                }
                else {
                    $estado = $row["estadoNovedad"];
                }

                $sql = "UPDATE novedades 
                        SET tituloNovedad = '$titulo', textoNovedad = '$texto', fechaDesdeNov = '$desde', fechaHastaNov = '$hasta', tipoUsuario = '$cat_user', estadoNovedad = '$estado'
                        WHERE codNovedad = '$cod_nov'";  

                try {
                    mysqli_query($conn, $sql);

                    if ($row["tituloNovedad"] != $titulo || $row["textoNovedad"] != $texto || $row["fechaDesdeNov"] != $desde || $row["fechaHastaNov"] != $hasta || $row["tipoUsuario"] != $cat_user) {
                        $_SESSION["novModificada"] = 1;
                    }

                    if ($row["estadoNovedad"] != $estado) {
                        $_SESSION["novRestablecida"] = 1;
                    } 

                    header("Location: admin_nov.php");
                }
                catch(mysqli_sql_exception) {
                    echo "<p class='msj_error'>Error al modificar novedad, inténtelo de nuevo más tarde.</p>";
                }
            }
            else {
                echo "<p class='msj_error'>Deben llenarse todos los campos para continuar.</p>";
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