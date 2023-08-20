<?php

class MensajeFlash {

    static function guardarMensaje($mensaje) {
        $_SESSION['mensajesFlash'][] = $mensaje;
    }

    static function imprimirMensajes() {
        if (isset($_SESSION['mensajesFlash'])) {
            foreach ($_SESSION['mensajesFlash'] as $mensaje)
            {
                print '<h3 style="color:red;text-align: center;font-weight: bold;">' . $mensaje . '</h3>';
            }
            unset($_SESSION['mensajesFlash']);
        }
    }

}
