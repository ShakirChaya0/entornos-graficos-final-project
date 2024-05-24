<?php
    function successMensaje() {
        if ($_SESSION["localCreado"] == 1) {
            echo "
                    <div class='success-box'>
                        <p class='success-box__msj'>Local creado con éxito!</p>
                    </div>
            ";
        }
        elseif ($_SESSION["localModificado"] == 1 && $_SESSION["localRestablecido"] == 1) {
            echo "
                    <div class='success-box'>
                        <p class='success-box__msj'>Local modificado y restablecido con éxito!</p>
                    </div>
            ";
        }
        elseif ($_SESSION["localModificado"] == 1) {
            echo "
                    <div class='success-box'>
                        <p class='success-box__msj'>Local modificado con éxito!</p>
                    </div>
            ";
        }
        elseif ($_SESSION["localRestablecido"] == 1) {
            echo "
                    <div class='success-box'>
                        <p class='success-box__msj'>Local restablecido con éxito!</p>
                    </div>
            ";
        }
        elseif ($_SESSION["localEliminado"] == 1) {
            echo "
                    <div class='success-box'>
                        <p class='success-box__msj'>Local eliminado con éxito!</p>
                    </div>
            ";
        }
    }
?>