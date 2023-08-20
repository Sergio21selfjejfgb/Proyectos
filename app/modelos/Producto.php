<?php
/**
 * Description of Producto
 *
 * @author Alumno
 */
class Producto {
    private $idProducto; 
    private $nombre;
    private $descripcion;
    private $precio;
    private $imagen;
    private $categoria;
    private $cantidad;
    private $fechaProducto;
    
    
    public function getIdProducto() {
        return $this->idProducto;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function getPrecio() {
        return $this->precio;
    }

    public function getImagen() {
        return $this->imagen;
    }

    public function getCategoria() {
        return $this->categoria;
    }

    public function getFechaProducto() {
        return $this->fechaProducto;
    }

    public function setIdProducto($idProducto): void {
        $this->idProducto = $idProducto;
    }

    public function setNombre($nombre): void {
        $this->nombre = $nombre;
    }

    public function setDescripcion($descripcion): void {
        $this->descripcion = $descripcion;
    }

    public function setPrecio($precio): void {
        $this->precio = $precio;
    }

    public function setImagen($imagen): void {
        $this->imagen = $imagen;
    }

    public function setCategoria($categoria): void {
        $this->categoria = $categoria;
    }

    public function setFechaProducto($fechaProducto): void {
        $this->fechaProducto = $fechaProducto;
    }
    
    public function getCantidad() {
        return $this->cantidad;
    }

    public function setCantidad($cantidad): void {
        $this->cantidad = $cantidad;
    }







}
