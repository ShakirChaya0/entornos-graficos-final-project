<?php
    session_start();
    include("../../database.php");

    /*if (!isset($_SESSION["codUsuario"]) || $_SESSION["tipoUsuario"] != "Dueño de local") {
        header("Location: ../../inicio_de_sesion/inicio_sesion.php");
    }*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../Imagenes-Videos/bolsas-de-compra.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="../../Barra_Navegacion/Bar-style.css">
	<link rel="stylesheet" href="../../Pie_De_Pagina/footer.css">
	<link rel="stylesheet" href="Home.css">
	<title>Rosario Shopping Center - Inicio</title>
</head>

<body>
<?php
    include("../../Barra_Navegacion/Nav-bar.php");
?>

    <h1 class="page_title">Rosario Shopping Center</h1>
	<section class="section">
        <div class="image_box">
            <div class="text_box">
		        <div class="div_bienvenida">
                    <h2 class="title"><br>Bienvenido Dueño!</h2>
		        	<p class="shopping-description">Gracias por trabajar con nosotros. Su papel es crucial para mantener nuestra comunidad segura y próspera.</p>
                </div>
                <div class="flex_box">
                    <p>Acceda rápidamente al listado de sus promociones</p>
                    <div class="flex_item">
                        <a href="../Promociones/Promociones.php" class="btn btn-primary">Ver Promociones</a>
                    </div>
                </div>
                <hr class="divider">
            </div>
            <?php
                $cod = $_SESSION["codUsuario"];

                $sql = "SELECT * FROM locales WHERE codUsuario = '$cod'";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    echo "
                        <div class='flex_list'>
                            <h3 class='subtitle'>Sus Locales</h3>
                            <ul class='list-group'>
                        ";
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<li class='list-group-item'>{$row["codLocal"]} - {$row["nombreLocal"]}</li>";
                    }
                    echo "
                            </ul>
                        </div>
                    ";
                }
            ?>
        </div>
	</section>

<?php
    include("../../Pie_De_Pagina/footer.php");
?>                  

</body>
</html>