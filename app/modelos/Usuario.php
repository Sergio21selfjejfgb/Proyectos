<?php
/**
 * Description of Usuario
 *
 * @author Sergio Del Pozo Checa
 */
class Usuario {
    private $idUsuario;
    private $nombreCompleto;
    private $email;
    private $password;
    private $role;
    
    public function getIdUsuario() {
        return $this->idUsuario;
    }

    public function getNombreCompleto() {
        return $this->nombreCompleto;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getRole() {
        return $this->role;
    }

    public function setIdUsuario($idUsuario): void {
        $this->idUsuario = $idUsuario;
    }

    public function setNombreCompleto($nombreCompleto): void {
        $this->nombreCompleto = $nombreCompleto;
    }

    public function setEmail($email): void {
        $this->email = $email;
    }

    public function setPassword($password): void {
        $this->password = $password;
    }

    public function setRole($role): void {
        $this->role = $role;
    }




    
}
