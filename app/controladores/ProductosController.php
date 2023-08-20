<?php

/**
 * Description of ProductosController
 *
 * @author Sergio Del Pozo Checa
 */
class ProductosController {
    function inicio() {                   
        $productoDAO = new ProductosDAO(ConexionBD::conectar());
        $productos = $productoDAO->obtenerTodosProductos();
        $numProductos = $productoDAO->numProductos();
        
        require 'app/vistas/inicio.php';                
    }
    
    function ir_productosFiltrados(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $busqueda = htmlentities($_POST['busqueda']);
            
            if(isset($_POST['buscar']) && !empty($_POST['busqueda'])){
                $productoDAO = new ProductosDAO(ConexionBD::conectar());
                $productosFiltrados = $productoDAO->filtrarProductosPorNombre($busqueda);
                require 'app/vistas/productosFiltrados.php';
            }else{
                $productoDAO = new ProductosDAO(ConexionBD::conectar());
                $productos = $productoDAO->obtenerTodosProductos();
                require 'app/vistas/inicio.php';
            }
        }
        
    }

    function ir_favoritos(){
        if(isset($_SESSION['email'])){
            $productoDAO = new ProductosDAO(ConexionBD::conectar());
            $productosFavoritos = $productoDAO->obtenerTodosProductosFavoritosPorUsuario();
            require 'app/vistas/favoritos.php';
        }else{
            header("Location: index.php?action=irlogin");
            die();
            
        }        
    }
    
    function ir_carrito(){
        if(isset($_SESSION['email'])){
            $productoDAO = new ProductosDAO(ConexionBD::conectar());
            $productosCarrito = $productoDAO->obtenerTodosProductosCarritoPorUsuario();
            require 'app/vistas/carrito.php';
        }else{
            header("Location: index.php?action=irlogin");
            die();            
        }        
    }
    
    function ir_factura(){
        if(isset($_SESSION['email']) && isset($_GET['identificador'])){
            $identificador = filter_var($_GET['identificador'], FILTER_SANITIZE_NUMBER_INT);
            
            $pedido = new Pedido();
            $pedido->setIdentificador($identificador);
            
            $productoDAO = new ProductosDAO(ConexionBD::conectar());
            $productosPedido = $productoDAO->obtenerPedidosUsuario($pedido);
            
            $datosProductoPedido = $productoDAO->obtenerTodosProductosPedidosPorUsuario($identificador);
            
            require 'app/vistas/factura.php';
        }else{
            header("Location: index.php");
            die();            
        }        
    }
    
    function ir_vista_producto(){
        $idProducto = filter_var($_GET['idPro'], FILTER_SANITIZE_NUMBER_INT);
        $productoDAO = new ProductosDAO(ConexionBD::conectar());
        $producto = $productoDAO->obtenerProductoId($idProducto);
        
        require 'app/vistas/vistaProducto.php';
    }
    
    function ir_listado_pedidos(){
        $idUsuario = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
        $productoDAO = new ProductosDAO(ConexionBD::conectar());
        $pedidos = $productoDAO->obtenerPedidosIdUsuario($idUsuario);
        require 'app/vistas/listadoPedidos.php';
    }


    function borrar_producto(){
        if (isset($_GET['id'])) {
            $idProducto = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
            $productoDAO = new ProductosDAO(ConexionBD::conectar()); 
            
            if(!$productos = $productoDAO->obtenerPorductoporId($idProducto)){   
                MensajeFlash::guardarMensaje("El anuncio no existe");
                header("Location: index.php");
                die(); 
            }
            $imagenProducto = $productos->getImagen();
            if (file_exists("web/app/" . $imagenProducto)) {
                unlink("web/app/" . $imagenProducto);
            }
        }
        $productoDAO->borrarProducto($productos);
        header("Location: index.php?action=ir_modo_admin");
    }
    
    function insertar_producto() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //Recoger datos  y filtrarlos
            $nombre = htmlentities($_POST['nombre']);
            $descripcion = htmlentities($_POST['descripcion']);
            $categoria = htmlentities($_POST['categoria']);
            $precio = htmlentities($_POST['precio']);
           
            // Validar que se haya subido un archivo
            if (!isset($_FILES['img']) || $_FILES['img']['error'] !== UPLOAD_ERR_OK) {
                MensajeFlash::guardarMensaje('Error al cargar la imagen');
                header("Location: index.php?action=insertar_producto");
                die();
            }
            
            //Validar el tipo de archivo
            $img_type = exif_imagetype($_FILES['img']['tmp_name']);
            if (!$img_type || !in_array($img_type, [IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_GIF, IMAGETYPE_WEBP])) {
                MensajeFlash::guardarMensaje('El archivo no es una imagen');
                header("Location: index.php?action=insertar_producto");
                die();
            }
            
            // Validar el tamaño del archivo
            if ($_FILES['img']['size'] > 5000000) {
                MensajeFlash::guardarMensaje('El archivo es demasiado grande');
                header("Location: index.php?action=insertar_producto");
                die();              
            }
            
            $img_name = uniqid() . '_' . $_FILES['img']['name'];
            $img_path = 'web/img/' . $img_name;
            
            try {
            // Mover el archivo cargado al servidor
            if (!move_uploaded_file($_FILES['img']['tmp_name'], $img_path)) {
                MensajeFlash::guardarMensaje('Error al guardar la imagen');
                header("Location: index.php?action=insertar_producto");
                die();
            }
            //Guardar datos
            $producto = new Producto();
            $producto->setNombre($nombre);
            $producto->setDescripcion($descripcion);
            $producto->setCategoria($categoria);
            $producto->setPrecio($precio);
            $producto->setImagen($img_name);

            $productoDAO = new ProductosDAO(ConexionBD::conectar());
            $productoDAO->insertar($producto);

            header("Location: index.php?action=ir_modo_admin");
            die();
            } catch (Exception $e) {
                // Manejar cualquier excepción que pueda ocurrir durante el proceso de carga de la imagen
                die('Error al guardar la imagen: ' . $e->getMessage());
            }
        } else {
            require 'app/vistas/insertarProductos.php';
        }
    }
    
    function modificar_producto(){
        //Recoger datos y filtrarlos
        $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
        $productoDAO=new ProductosDAO(ConexionBD::conectar());
        $producto= new Producto();
        $producto= $productoDAO->obtenerPorductoporId($id);
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {            
            //Recoger datos y filtrarlos
            $nombre=htmlentities($_POST['nombre']);
            $descripcion = htmlentities($_POST['descripcion']);
            $categoria=htmlentities($_POST['categoria']);
            $precio = htmlentities($_POST['precio']);
            
            //Comprobaciones para la subída de la imagen
            if (!isset($_FILES['img']) || $_FILES['img']['error'] !== UPLOAD_ERR_OK) {
                MensajeFlash::guardarMensaje('Error al cargar la imagen');
                header("Location: index.php?action=modificar_producto&id=$id");
                die();
            }
            
            //Comprobación del tipo de imagen que introduce el usuario
            $img_type = exif_imagetype($_FILES['img']['tmp_name']);
            if (!$img_type || !in_array($img_type, [IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_GIF, IMAGETYPE_WEBP])) {
                MensajeFlash::guardarMensaje('El archivo no es una imagen');
                header("Location: index.php?action=modificar_producto&id=$id");
                die();
            }
            
            // Validar el tamaño del archivo
            if ($_FILES['img']['size'] > 5000000) {
                MensajeFlash::guardarMensaje('El archivo es demasiado grande');
                header("Location: index.php?action=modificar_producto&id=$id");
                die();
            }
            
            $img_name = uniqid() . '_' . $_FILES['img']['name'];
            $img_path = 'web/img/' . $img_name;
            
            try {
            // Mover el archivo cargado al servidor
            if (!move_uploaded_file($_FILES['img']['tmp_name'], $img_path)) {
                MensajeFlash::guardarMensaje('Error al guardar la imagen');
                header("Location: index.php?action=modificar_producto&id=$id");
                die();
            }

            //Guardar los datos
            $producto->setNombre($nombre);
            $producto->setDescripcion($descripcion);
            $producto->setCategoria($categoria);
            $producto->setPrecio($precio);
            $producto->setImagen($img_name);

            $productoDAO->actualizar_producto($producto);
            header("Location: index.php?action=ir_modo_admin");
            die();
            } catch (Exception $e) {
                // Manejar cualquier excepción que pueda ocurrir durante el proceso de carga de la imagen
                die('Error al guardar la imagen: ' . $e->getMessage());
            }
    }else{
        $idllega= $_GET['id'];
        $conn= ConexionBD::conectar();
        $productoDAO=new ProductosDAO($conn);
        $productos=$productoDAO->obtenerPorductoporId($idllega);
        require 'app/vistas/modificarProductos.php';
    }
    
    }
    
    function insertar_producto_favorito(){
        $productoId = filter_var($_POST['productId'],FILTER_SANITIZE_NUMBER_INT);
        $idUsuario = $_SESSION['idUsuario'];
        $usuario = new Usuario();
        $usuario->setIdUsuario($_SESSION['idUsuario']);
        
        $productoDAO=new ProductosDAO(ConexionBD::conectar());
        $producto= new Producto();
        $producto= $productoDAO->obtenerPorductoporId($productoId);
        
        if($productoDAO->existeEnFavoritos($idUsuario, $productoId) > 0){
            //mensaje de que ya existe el producto en favoritos            
        }else{
            $productoDAO->insertar_favorito($producto, $usuario);
        }         
    }
    
    function borrar_producto_favorito(){
        $idProducto = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
        $idusuario = $_SESSION['idUsuario'];
        
        $productoDAO = new ProductosDAO(ConexionBD::conectar());
        $product = $productoDAO->borrar_favorito($idProducto, $idusuario );
        if($product == true){
            header("Location: index.php?action=ir_favoritos");
        }else{
            header("Location: index.php");
            die();
        }       
    }
    
    function comprobar_producto_favorito(){
        $productoId = filter_var($_POST['productId'],FILTER_SANITIZE_NUMBER_INT);
        $idUsuario = $_SESSION['idUsuario'];
        $productoDAO = new ProductosDAO(ConexionBD::conectar());
        $existeEnFavoritos = $productoDAO->existeEnFavoritos($idUsuario, $productoId);
        
        header('Content-Type: application/json');
        echo json_encode($existeEnFavoritos);
    }
    
    function comprobar_producto_carrito(){
        $productoId = filter_var($_POST['productId'],FILTER_SANITIZE_NUMBER_INT);
        $idUsuario = $_SESSION['idUsuario'];
        $productoDAO = new ProductosDAO(ConexionBD::conectar());
        $existeEnCarrito = $productoDAO->existeEnCarrito($idUsuario, $productoId);
        
        header('Content-Type: application/json');
        echo json_encode($existeEnCarrito);
    }

    function insertar_producto_carrito(){
        $productoId = filter_var($_POST['productId'],FILTER_SANITIZE_NUMBER_INT);
        $idUsuario = $_SESSION['idUsuario'];
        $usuario = new Usuario();
        $usuario->setIdUsuario($_SESSION['idUsuario']);
        
        $productoDAO=new ProductosDAO(ConexionBD::conectar());
        $producto= new Producto();
        $producto= $productoDAO->obtenerPorductoporId($productoId);
        
        $precio = $producto->getPrecio();
        $carrito = $producto->getCantidad();
        
        if($productoDAO->existeEnCarrito($idUsuario, $productoId) > 0){
            //mensaje de que ya existe el producto en favoritos
        }else{
            $productoDAO->insertar_carrito($producto, $usuario, $precio, $carrito);
        }
        
    }
    
    function borrar_producto_carrito () {
        $idProducto = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
        $idusuario = $_SESSION['idUsuario'];
        
        $productoDAO = new ProductosDAO(ConexionBD::conectar());
        
        $producto = $productoDAO->borrarDelCarrito($idProducto, $idusuario );
        if($producto == true){
            header("Location: index.php?action=ir_carrito");
        }else{
            header("Location: index.php");
            die();
        } 
    } 
    
    function insertar_pedido(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
            $idProducto = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
            $precio = htmlentities($_POST['precio']);
            $cantidades = $_POST['cantidad'];

            $producto = new Producto();

            $producto->setIdProducto($idProducto);
            $producto->setPrecio($precio);

            $usuario = new Usuario();
            $usuario->setIdUsuario($_SESSION['idUsuario']);

            $productoDAO = new ProductosDAO(ConexionBD::conectar());
            $array_producto = $productoDAO->obtenerProductosCarrito();

            // Verificar si $cantidades es un array
            if (is_array($cantidades)) {
                $cantidadProductos = count($cantidades);

                // Verificar si la cantidad de productos coincide con la cantidad de cantidades
                if (count($array_producto) == $cantidadProductos) {
                    $identidicador = mt_rand();
                    foreach ($array_producto as $index => $prod) {
                        $cantidad = intval($cantidades[$index]); // Convertir la cantidad a número entero

                        // Actualizar la cantidad del producto antes de insertarlo
                        $prod->setCantidad($cantidad);

                        // Insertar el producto con la cantidad correspondiente
                        if($productoDAO->insertarProducto_pedido($prod, $usuario, $identidicador)){
                            $productoDAO->borrar_TodosProductosCarrito($_SESSION['idUsuario']);
                            header("Location: index.php?action=ir_factura&identificador=" . $identidicador);
                            
                        }
                        
                    }
                } else {
                    echo "Error: La cantidad de productos y cantidades no coincide.";
                }
            } else {
                // Si $cantidades no es un array, asumir que es un número y asignarlo a todos los productos
                $cantidad = intval($cantidades);

                foreach ($array_producto as $prod) {
                    // Actualizar la cantidad del producto antes de insertarlo
                    $prod->setCantidad($cantidad);

                    // Insertar el producto con la cantidad correspondiente
                    if($productoDAO->insertarProducto_pedido($prod, $usuario)){
                            header("Location: index.php?action=ir_factura");
                    }
                }
            }
        }
    }




}




