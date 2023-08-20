<?php
/**
 * Description of Carrito
 *
 * @author Alumno
 */
class Carrito {
    private $idCarrito;
    private $idusuario;
    private $idproducto;
    private $cantidad;
    private $precio;
    private $fecha;
    
    public function getIdCarrito() {
        return $this->idCarrito;
    }

    public function getIdusuario() {
        return $this->idusuario;
    }

    public function getIdproducto() {
        return $this->idproducto;
    }

    public function getCantidad() {
        return $this->cantidad;
    }

    public function getPrecio() {
        return $this->precio;
    }

    public function getFecha() {
        return $this->fecha;
    }

    public function setIdCarrito($idCarrito): void {
        $this->idCarrito = $idCarrito;
    }

    public function setIdusuario($idusuario): void {
        $this->idusuario = $idusuario;
    }

    public function setIdproducto($idproducto): void {
        $this->idproducto = $idproducto;
    }

    public function setCantidad($cantidad): void {
        $this->cantidad = $cantidad;
    }

    public function setPrecio($precio): void {
        $this->precio = $precio;
    }

    public function setFecha($fecha): void {
        $this->fecha = $fecha;
    }


}
