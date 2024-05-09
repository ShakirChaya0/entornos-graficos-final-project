<?php
    include("database.php");
    if(isset($_POST["submit"])){
        if(empty($username) && empty($password)){
            echo"<p class='error'>* Completa ambos campos</p>";
        }
        elseif(empty($password)){
            echo"<p class='error'>* Completa la contraseña</p>";
        }
        elseif(empty($username)){
            echo"<p class='error'>* Completa el usuario</p>";
        }
    }   
?>