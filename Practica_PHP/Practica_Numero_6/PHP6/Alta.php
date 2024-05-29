<?php
    include("database.php");
    if(!empty($_POST["Submit"])) {
        if(isset($_POST["Ciudad"]) && isset($_POST["Pais"]) && isset($_POST["Habitantes"]) && isset($_POST["Superficie"]) && isset($_POST["tieneMetro"])){
            $sql = "INSERT INTO ciudades (ciudad, pais, habitantes, superficie, tieneMetro) VALUES ('".$_POST["Ciudad"]."','".$_POST["Pais"]."', '".$_POST["Habitantes"]."', '".$_POST["Superficie"]."', '".$_POST["tieneMetro"]."')";
            mysqli_query($conn, $sql);
            echo"Dada de alta exitosa";
        }
        $_POST = array();
    }
?>
<tr>
        <p><a href="home.html">Volver al menu; del ABML</a></p>
    </tr>