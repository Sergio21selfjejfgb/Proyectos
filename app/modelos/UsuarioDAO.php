<?php


class UsuarioDAO {
    private $conn;

    public function __construct($conn) {
        if (!$conn instanceof mysqli) { //Comprueba si $conn es un objeto de la clase mysqli
            return false;
        }
        $this->conn = $conn;
    }
    
    public function obtenerPorEmail($email) {
        $sql = "SELECT * FROM usuarios WHERE email = ?";
        if (!$stmt = $this->conn->prepare($sql)) {
            die("Error al preparar la sentencia: " . $this->conn->error);
        }
        $stmt->bind_param('s', $email);
        $stmt->execute();

        $result = $stmt->get_result();
        $usuario = $result->fetch_object('Usuario');
        //Para que netbeans reconozca el objeto de la clase Usuario  
        return $usuario;
    }
    
    public function insertar(Usuario $u) {
        $sql = "INSERT INTO usuarios (nombreCompleto, email, password,role ) VALUES (?,?,?,?)";
        if (!$stmt = $this->conn->prepare($sql)) {
            die("Error al preparar la sentencia: " . $this->conn->error);
        }
        $nombre = $u->getNombreCompleto();
        $email = $u->getEmail();
        $password = $u->getPassword();
        $role = $u->getRole();
        

        $stmt->bind_param('ssss', $nombre, $email, $password,$role);
        $stmt->execute();
    }
    
    public function actualizar(Usuario $u) {
        $sql = "UPDATE usuarios SET email = ? , cookie = ? "
                . "WHERE id = ?";
        if (!$stmt = $this->conn->prepare($sql)) {
            die("Error al preparar la sentencia: " . $this->conn->error);
        }
        $id = $u->getId();
        $email = $u->getEmail();
        $cookie = $u->getCookie();
        $stmt->bind_param('ssi', $email, $cookie, $id);
        $stmt->execute();
    }
    
    public function obtenerTodosUsuarios() {
        $sql = "SELECT * FROM usuarios ";
        if (!$result = $this->conn->query($sql)) {
            die("Error al ejecutar la SQL " . $this->conn->error);
        }
        $array_usuarios = array();
        while ($usuarios = $result->fetch_object('Usuario')) {
            $array_usuarios[] = $usuarios;
        }
        return $array_usuarios;
    }

}
