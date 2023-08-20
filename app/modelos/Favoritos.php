<?php

/**
 * Description of Favoritos
 *
 * @author Sergio Del Pozo Checa
 */
class Favoritos {
    private $id; 
    private $idusuario;
    private $idproducto;
    
    public function getId() {
        return $this->id;
    }

    public function getIdusuario() {
        return $this->idusuario;
    }

    public function getIdproducto() {
        return $this->idproducto;
    }

    public function setId($id): void {
        $this->id = $id;
    }

    public function setIdusuario($idusuario): void {
        $this->idusuario = $idusuario;
    }

    public function setIdproducto($idproducto): void {
        $this->idproducto = $idproducto;
    }


}
