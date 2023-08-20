<?php
/**
 * Description of Pedido
 *
 * @author Alumno
 */
class Pedido {
    private $idPedido;
    private $idusuario;
    private $idproducto;
    private $cantidad;
    private $precio;
    private $identificador;
    private $fechaPedido;
    
    public function getIdPedido() {
        return $this->idPedido;
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

    public function getFechaPedido() {
        return $this->fechaPedido;
    }

    public function setIdPedido($idPedido): void {
        $this->idPedido = $idPedido;
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

    public function setFechaPedido($fechaPedido): void {
        $this->fechaPedido = $fechaPedido;
    }

    public function getIdentificador() {
        return $this->identificador;
    }

    public function setIdentificador($identificador): void {
        $this->identificador = $identificador;
    }




}
