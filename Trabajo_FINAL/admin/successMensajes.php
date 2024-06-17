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
        elseif ($_SESSION["novCreada"] == 1) {
            echo "
                    <div class='success-box'>
                        <p class='success-box__msj'>Novedad creada con éxito!</p>
                    </div>
            ";
        }
        elseif ($_SESSION["novModificada"] == 1 && $_SESSION["novRestablecida"] == 1) {
            echo "
                    <div class='success-box'>
                        <p class='success-box__msj'>Novedad modificada y restablecida con éxito!</p>
                    </div>
            ";
        }
        elseif ($_SESSION["novModificada"] == 1) {
            echo "
                    <div class='success-box'>
                        <p class='success-box__msj'>Novedad modificada con éxito!</p>
                    </div>
            ";
        }
        elseif ($_SESSION["novRestablecida"] == 1) {
            echo "
                    <div class='success-box'>
                        <p class='success-box__msj'>Novedad restablecida con éxito!</p>
                    </div>
            ";
        }
        elseif ($_SESSION["novEliminada"] == 1) {
            echo "
                    <div class='success-box'>
                        <p class='success-box__msj'>Novedad eliminada con éxito!</p>
                    </div>
            ";
        }
        elseif ($_SESSION["ownerAceptado"] == 1) {
            echo "
                    <div class='success-box'>
                        <p class='success-box__msj'>Cuenta validada con éxito!</p>
                    </div>
            ";
        }
        elseif ($_SESSION["ownerRechazado"] == 1) {
            echo "
                    <div class='success-box'>
                        <p class='success-box__msj'>Cuenta rechazada con éxito!</p>
                    </div>
            ";
        }
        elseif ($_SESSION["promoAceptada"] == 1) {
            echo "
                    <div class='success-box'>
                        <p class='success-box__msj'>Promoción aceptada con éxito!</p>
                    </div>
            ";
        }
        elseif ($_SESSION["promoDenegada"] == 1) {
            echo "
                    <div class='success-box'>
                        <p class='success-box__msj'>Promoción denegada con éxito!</p>
                    </div>
            ";
        }
        elseif($_SESSION["promocionCreadaDueño"] == 1){
            echo "
                    <div class='success-box'>
                        <p class='success-box__msj'>Promoción creada con éxito!</p>
                    </div>
            ";
        }
    }
?>