<?php
session_start();

function successMail() {
    if (isset($_SESSION['mailEnviado']) && $_SESSION['mailEnviado'] == 1) {
        echo '
        <style>
            .modal-mail {
                position: fixed;
                bottom: 20px;
                left: 20px;
                background-color: black;
                color: white;
                padding: 10px 20px;
                border-radius: 5px;
                opacity: 0;
                transition: opacity 0.5s ease-in-out;
            }
            .modal-mail.show {
                opacity: 1;
            }
        </style>
        <div id="mailModal" class="modal-mail">
            Email enviado correctamente
        </div>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var modal = document.getElementById("mailModal");
                modal.classList.add("show");
                setTimeout(function() {
                    modal.classList.remove("show");
                }, 3000); // Desaparece después de 3 segundos
            });
        </script>
        ';
    }
}
