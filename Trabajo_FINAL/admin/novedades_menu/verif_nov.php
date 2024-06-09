<?php
    include("../../database.php");
    date_default_timezone_set('America/Argentina/Buenos_Aires');

    $sql = "SELECT * FROM novedades";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) > 0) {
        $today = date('Y-m-d');
        while ($row = mysqli_fetch_assoc(($result))) {
            
            if ($today < $row["fechaDesdeNov"] || $today > $row["fechaHastaNov"]) {
                if ($row["estadoNovedad"] == "B") {
                    $estado = "B";
                } 
                else {
                    $estado = "NV";
                }
            }
            else {
                if ($row["estadoNovedad"] == "B") {
                    $estado = "B";
                } 
                else {
                    $estado = "A";
                }
            }

            $sql = "UPDATE novedades 
                    SET estadoNovedad = '$estado'
                    WHERE codNovedad = '{$row["codNovedad"]}'";
            
            try {
                mysqli_query($conn, $sql);
            }
            catch(mysqli_sql_exception) {
                echo "<p class='msj_error'>Error con la base de datos, ingrese de nuevo más tarde.</p>";
            }
        }
    }
?>