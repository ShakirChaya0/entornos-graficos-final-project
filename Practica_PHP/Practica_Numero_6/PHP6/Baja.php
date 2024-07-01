<?php
    include("database.php");
    if(isset($_POST["submit"])){
        if(isset($_POST["ciudad"])){
            $search_list = "DELETE FROM ciudades WHERE ciudad = '".$_POST["ciudad"]."'";
            mysqli_query($conn,$search_list);
            mysqli_close($conn);
            echo"dada de baja";
        }
        $_POST = array();
    }
?>
<tr>
        <p><a href="home.html">Volver al menu; del ABML</a></p>
    </tr>