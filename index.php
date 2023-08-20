<?php
//Para utilizar variables de sesión
session_start();

//////// CONTROLADOR FRONTAL /////////

/* REQUIRES DE MODELOS, CONTROLADORES Y CONFIG */
require './app/config.php';
require './app/modelos/ConexionBD.php';
require './app/utilidades/MensajeFlash.php';
require './app/controladores/ProductosController.php';
require './app/controladores/UsuariosController.php';
require './app/modelos/UsuarioDAO.php';
require './app/modelos/ProductosDAO.php';
require './app/modelos/Usuario.php';
require './app/modelos/Producto.php';
require './app/modelos/Carrito.php';
require './app/modelos/Pedido.php';


/* MAPA DE ENRUTAMIENTO */
$map = array (
    "inicio" => array("controller" => "ProductosController", "method" => "inicio", "publica" => true),
    "ir_productosFiltrados" => array("controller" => "ProductosController", "method" => "ir_productosFiltrados", "publica" => true),
    "login" => array("controller" => "UsuariosController", "method" => "login", "publica" => true),
    "registrar" => array("controller" => "UsuariosController", "method" => "registrar", "publica" => true),
    "logout" => array("controller" => "UsuariosController", "method" => "logout", "publica" => false),
    "irlogin" => array("controller" => "UsuariosController", "method" => "irlogin", "publica" => true),
    "ir_modo_admin" => array("controller" => "UsuariosController", "method" => "ir_modo_admin", "publica" => true),
    "ir_informacionSobreMi" => array("controller" => "UsuariosController", "method" => "ir_informacionSobreMi", "publica" => true),
    "ir_curriculum" => array("controller" => "UsuariosController", "method" => "ir_curriculum", "publica" => true),
    "ir_listado_usuarios" => array("controller" => "UsuariosController", "method" => "ir_listado_usuarios", "publica" => true),
    "ir_listado_pedidos" => array("controller" => "ProductosController", "method" => "ir_listado_pedidos", "publica" => true),
    "ir_vista_producto" => array("controller" => "ProductosController", "method" => "ir_vista_producto", "publica" => true),
    "borrar_producto" => array("controller" => "ProductosController", "method" => "borrar_producto", "publica" => false),
    "insertar_producto" => array("controller" => "ProductosController", "method" =>"insertar_producto", "publica" =>false),
    "modificar_producto" => array("controller" => "ProductosController", "method" =>"modificar_producto", "publica" =>false),
    "ir_favoritos" => array("controller" => "ProductosController", "method" => "ir_favoritos", "publica" => true),
    "ir_carrito" => array("controller" => "ProductosController", "method" => "ir_carrito", "publica" => true),
    "insertar_producto_favorito" => array("controller" => "ProductosController", "method" =>"insertar_producto_favorito", "publica" =>false),
    "borrar_producto_favorito" => array("controller" => "ProductosController", "method" =>"borrar_producto_favorito", "publica" =>false),
    "comprobar_producto_favorito" => array("controller" => "ProductosController", "method" =>"comprobar_producto_favorito", "publica" =>true),
    "insertar_producto_carrito" => array("controller" => "ProductosController", "method" =>"insertar_producto_carrito", "publica" =>false),
    "insertar_pedido" => array("controller" => "ProductosController", "method" =>"insertar_pedido", "publica" =>false),
    "ir_factura" => array("controller" => "ProductosController", "method" => "ir_factura", "publica" => true),
    "borrar_producto_carrito" => array("controller" => "ProductosController", "method" => "borrar_producto_carrito", "publica" => false),
    "comprobar_producto_carrito" => array("controller" => "ProductosController", "method" =>"comprobar_producto_carrito", "publica" =>true)    
);
    
/* PARSEO DE LA RUTA */
if (!isset($_GET['action'])) {    
    $action = 'inicio';
} else {
    if (!isset($map[$_GET['action']])) {  
        print "La acción indicada no existe.";
        header('Status: 404 Not Found');
        die();
    } else {
        $action = filter_var($_GET['action'], FILTER_SANITIZE_SPECIAL_CHARS);
    }
}

/* CONTROL DE ACCESO MEDIANTE VARIABLES DE SESIÓN */
if (!$map[$action]["publica"] && !isset($_SESSION['idUsuario'])) {
    MensajeFlash::guardarMensaje("Debes identificarte");
    header("Location: index.php");
    die();
}

/* EJECUTAMOS EL CONTROLADOR NECESARIO */

$controller = $map[$action]['controller'];
$method = $map[$action]['method'];

if (method_exists($controller, $method)) {
    $obj_controller = new $controller();
    $obj_controller->$method();
} else {
    header('Status: 404 Not Found');
    echo "El método $method del controlador $controller no existe.";
}
