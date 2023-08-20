<?php

class ConexionBD {
    /**
     * Conecta con MySQL y devuelve la conexión
     * @return \mysqli Devuelve la conexión con la base de datos
     */
    static function conectar() {
        $conn = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASS, MYSQL_BD);
        if ($conn->connect_errno) {
            die("Error de conexión" . $conn->connect_error);
        }
        return $conn;
    }

}
