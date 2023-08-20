<?php
/**
 * Description of ProductosDAO
 *
 * @author Alumno
 */
class ProductosDAO {
    private $conn;
    
    public function __construct($conn) {
        if (!$conn instanceof mysqli) { //Comprueba si $conn es un objeto de la clase mysqli
            return false;
        }
        $this->conn = $conn;
    }
    
    public function obtenerTodosProductos() {
        $sql = "SELECT * FROM productos ORDER BY fechaProducto DESC";
        if (!$result = $this->conn->query($sql)) {
            die("Error al ejecutar la SQL " . $this->conn->error);
        }
        $array_productos = array();
        while ($producto = $result->fetch_object('Producto')) {
            $array_productos[] = $producto;
        }
        return $array_productos;
    }
    
    public function obtenerProductoId(int $id) {
        $sql = "SELECT * FROM productos WHERE idProducto = ?";

        if (!$stmt = $this->conn->prepare($sql)) {
            die("Error al preparar la sentencia: " . $this->conn->error);
        }

        $stmt->bind_param('i',$id);
        $stmt->execute();

        $result = $stmt->get_result();

        $arrayProducto = array();
        while ($producto = $result->fetch_object('Producto')) {
            $arrayProducto[] = $producto;
        }

        return $arrayProducto;
    }
    
    public function obtenerPorductoporId(int $id) {
        $sql = "SELECT * FROM productos WHERE idProducto = ?";
        if (!$stmt = $this->conn->prepare($sql)) {
            die("Error al preparar la sentencia: " . $this->conn->error);
        }
        $stmt->bind_param('i', $id);
        $stmt->execute();
        
        $result = $stmt->get_result();
        
        return $result->fetch_object('Producto');
    }
    
    public function borrarProducto(Producto $p) { 
        $sql = "DELETE FROM productos WHERE idProducto = ?";
        if (!$stmt = $this->conn->prepare($sql)) {
            die("Error al preparar la sentencia: " . $this->conn->error);
        }          
    
        $id = $p->getIdProducto();
        $stmt->bind_param('i', $id);
        $stmt->execute();
        
        if($stmt->affected_rows==0){
            return false;
        }
        else{
            return true;
        }
    }
    
    public function insertar(Producto $p) {
        $sql = "INSERT INTO productos (nombre, descripcion, precio, imagen, categoria) VALUES (?, ?, ?, ?, ?)";
        if (!$stmt = $this->conn->prepare($sql)) {
            die("Error al preparar la sentencia: " . $this->conn->error);
        }
        $nombre = $p->getNombre();
        $descripcion = $p->getDescripcion();
        $precio = $p->getPrecio();
        $imagen = $p->getImagen();
        $categoria = $p->getCategoria();
        
        $stmt->bind_param('ssdss', $nombre, $descripcion, $precio, $imagen,$categoria);
        $stmt->execute();
        return $stmt->insert_id;
    }
    
    public function actualizar_producto(Producto $p) {
        $sql = "UPDATE productos SET nombre = ? , descripcion = ?, precio = ?, imagen = ?, categoria = ? "
                . "WHERE idProducto = ?";
        if (!$stmt = $this->conn->prepare($sql)) {
            die("Error al preparar la sentencia: " . $this->conn->error);
        }   
        $id = $p->getIdProducto();
        $nombre = $p->getNombre();
        $descripcion = $p->getDescripcion();
        $precio = $p->getPrecio();
        $imagen = $p->getImagen();
        $categoria = $p->getCategoria();
        
        $stmt->bind_param('ssdssi', $nombre, $descripcion, $precio, $imagen, $categoria, $id );
        $stmt->execute();       
    }
    
    public function insertar_favorito(Producto $p, Usuario $u) {
        
        $sql = "INSERT INTO favoritos (idusuario, idproducto) VALUES (?, ?)";
        if (!$stmt = $this->conn->prepare($sql)) {
            die("Error al preparar la sentencia: " . $this->conn->error);
        }
        $idproducto = $p->getIdProducto();
        $idusuario = $u->getIdUsuario();
        
        $stmt->bind_param('ii', $idusuario, $idproducto);
        $stmt->execute();
        return $stmt->insert_id;
    }
    
    public function existeEnFavoritos($idUsuario , $idProducto) {
        $sql = "SELECT COUNT(*) FROM favoritos WHERE idusuario = ? AND idproducto = ?";
        if (!$stmt = $this->conn->prepare($sql)) {
            die("Error al preparar la sentencia: " . $this->conn->error);
        }
        $stmt->bind_param('ii', $idUsuario, $idProducto);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();

        return $count > 0;
    }  
    
    public function borrar_favorito(int $p, int $u) {
        $sql = "DELETE FROM favoritos WHERE idproducto = ? AND idusuario = ?";
        if (!$stmt = $this->conn->prepare($sql)) {
            die("Error al preparar la sentencia: " . $this->conn->error);
        }
        
        $stmt->bind_param('ii', $p, $u);
        $stmt->execute();
        
        if($stmt->affected_rows == 0){
            return false;
        }
        else{
            return true;            
        }
    }    
    
    public function obtenerTodosProductosFavoritosPorUsuario() {
        $sql = "SELECT p.* 
                FROM favoritos f 
                LEFT JOIN productos p ON f.idproducto = p.idProducto 
                WHERE f.idusuario = ?";

        if (!$stmt = $this->conn->prepare($sql)) {
            die("Error al preparar la sentencia: " . $this->conn->error);
        }

        $idUsuario = $_SESSION['idUsuario'];
        $stmt->bind_param('i', $idUsuario);
        $stmt->execute();

        $result = $stmt->get_result();

        $productosFavoritos = array();
        while ($producto = $result->fetch_object('Producto')) {
            $productosFavoritos[] = $producto;
        }

        return $productosFavoritos;
    }
    
    public function insertar_carrito(Producto $p, Usuario $u, float $precio, int $cantidad) {
        $sql = "INSERT INTO carritos (idusuario, idproducto, precio, cantidad) VALUES (?, ?, ?, ?)";
        if (!$stmt = $this->conn->prepare($sql)) {
            die("Error al preparar la sentencia: " . $this->conn->error);
        }
        $idproducto = $p->getIdProducto();
        $idusuario = $u->getIdUsuario();
        $precioProducto = $precio;
        $cantidadProducto = $cantidad;
        
        $stmt->bind_param('iidi', $idusuario, $idproducto, $precioProducto, $cantidadProducto);
        $stmt->execute();
        return $stmt->insert_id;
    }
    
    public function existeEnCarrito($idUsuario , $idProducto) {
        $sql = "SELECT COUNT(*) FROM carritos WHERE idusuario = ? AND idproducto = ?";
        if (!$stmt = $this->conn->prepare($sql)) {
            die("Error al preparar la sentencia: " . $this->conn->error);
        }
        $stmt->bind_param('ii', $idUsuario, $idProducto);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();

        return $count > 0;
    }
        
    public function obtenerTodosProductosCarritoPorUsuario() {
        $sql = "SELECT p.*, c.cantidad 
                FROM carritos c 
                LEFT JOIN productos p ON c.idproducto = p.idProducto 
                WHERE c.idusuario = ?";

        if (!$stmt = $this->conn->prepare($sql)) {
            die("Error al preparar la sentencia: " . $this->conn->error);
        }

        $idUsuario = $_SESSION['idUsuario'];
        $stmt->bind_param('i', $idUsuario);
        $stmt->execute();

        $result = $stmt->get_result();

        $productosCarrito = array();
        while ($producto = $result->fetch_object('Producto')) {
            $productosCarrito[] = $producto;
        }

        return $productosCarrito;
    }

    public function insertarProducto_pedido(Producto $p, Usuario $u, int $identificador) {
        $sql = "INSERT INTO pedidos (idproducto,idusuario, cantidad, precio, identificador) VALUES (?, ?, ?, ?, ?)";
        if (!$stmt = $this->conn->prepare($sql)) {
            die("Error al preparar la sentencia: " . $this->conn->error);
        }
        
        $idProducto = $p->getidProducto();
        $cantidad = $p->getCantidad();
        $precio = $p->getPrecio();
        $idUsuario = $u->getIdUsuario();

        
        $stmt->bind_param('iiidi', $idProducto, $idUsuario, $cantidad, $precio, $identificador);
        $resultado = $stmt->execute();
        if ($resultado) {
            // La inserción fue exitosa
            return true;
        } else {
            // Hubo un error al insertar el producto
            return false;
        }
        
    }
    
    public function actualizar_cantidadCarrito(Usuario $u, Producto $p, int $cantidad) {
        $sql = "UPDATE carritos SET cantidad = ? "
                . "WHERE idusuario = ? AND idproducto = ?";
        if (!$stmt = $this->conn->prepare($sql)) {
            die("Error al preparar la sentencia: " . $this->conn->error);
        }
        $idProducto = $p->getidProducto();
        $idUsuario = $u->getIdUsuario();
        
        $stmt->bind_param('ssi', $idUsuario, $idProducto, $cantidad );
        $stmt->execute();       
    }
    
    public function obtenerProductosCarrito() {
        $productos = array();
        $idUsuario = $_SESSION['idUsuario'];

        $sql = "SELECT p.idproducto, p.precio, c.cantidad FROM productos p
                INNER JOIN carritos c ON p.idproducto = c.idproducto
                WHERE c.idusuario = ?";

        if ($stmt = $this->conn->prepare($sql)) {
            $stmt->bind_param('i', $idUsuario);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $producto = new Producto();
                    $producto->setIdProducto($row['idproducto']);
                    $producto->setCantidad($row['cantidad']);
                    $producto->setPrecio($row['precio']);            

                    // Agregar el producto al array
                    $productos[] = $producto;
                }
            }

            $stmt->close();
        }

        return $productos;
    }
    
    public function borrar_TodosProductosCarrito(int $u) {
        $sql = "DELETE FROM carritos WHERE idusuario = ?";
        if (!$stmt = $this->conn->prepare($sql)) {
            die("Error al preparar la sentencia: " . $this->conn->error);
        }
        
        $stmt->bind_param('i', $u);
        $stmt->execute();
        
        if($stmt->affected_rows == 0){
            return false;
        }
        else{
            return true;            
        }
    } 
    
    public function borrarDelCarrito(int $p, int $u) {
        $sql = "DELETE FROM carritos WHERE idproducto = ? AND idusuario = ?";
        if (!$stmt = $this->conn->prepare($sql)) {
            die("Error al preparar la sentencia: " . $this->conn->error);
        }
        
        $stmt->bind_param('ii', $p, $u);
        $stmt->execute();
        
        if($stmt->affected_rows == 0){
            return false;
        }
        else{
            return true;            
        }
    }
    
    public function obtenerPedidosUsuario(Pedido $pe) {
        $sql = "SELECT * FROM pedidos WHERE idusuario = ? AND identificador = ?";

        if (!$stmt = $this->conn->prepare($sql)) {
            die("Error al preparar la sentencia: " . $this->conn->error);
        }

        $idUsuario = $_SESSION['idUsuario'];
        $pedidoIdentificador = $pe->getIdentificador();
        $stmt->bind_param('ii', $idUsuario, $pedidoIdentificador);
        $stmt->execute();

        $result = $stmt->get_result();

        $arrayPedidos = array();
        while ($pedido = $result->fetch_object('Pedido')) {
            $arrayPedidos[] = $pedido;
        }

        return $arrayPedidos;
    }
    
    public function obtenerTodosProductosPedidosPorUsuario(int $identificador) {
        $sql = "SELECT p.nombre, p.descripcion 
                FROM pedidos ped 
                LEFT JOIN productos p ON ped.idproducto = p.idProducto  
                WHERE ped.idusuario = ? AND ped.identificador = ?";

        if (!$stmt = $this->conn->prepare($sql)) {
            die("Error al preparar la sentencia: " . $this->conn->error);
        }

        $idUsuario = $_SESSION['idUsuario'];
        $stmt->bind_param('ii', $idUsuario, $identificador);
        $stmt->execute();

        $result = $stmt->get_result();

        $productosFavoritos = array();
        while ($producto = $result->fetch_object('Producto')) {
            $productosFavoritos[] = $producto;
        }

        return $productosFavoritos;
    }
    
    public function filtrarProductosPorNombre($nombreProducto) {
        $sql = "SELECT * FROM productos WHERE nombre LIKE '%$nombreProducto%'";
        if (!$result = $this->conn->query($sql)) {
            die("Error al ejecutar la SQL " . $this->conn->error);
        }
        $array_productos = array();
        while ($producto = $result->fetch_object('Producto')) {
            $array_productos[] = $producto;
        }
        return $array_productos;
    }
    
    public function numProductos() {
        $sql = "SELECT COUNT(*) FROM productos ";
        if (!$stmt = $this->conn->prepare($sql)) {
            die("Error al preparar la sentencia: " . $this->conn->error);
        }
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();

        return $count;
    }
    
    
    public function productosPaginacion($inicio, $registros) {
        $sql = "SELECT * FROM productos ORDER BY fechaProducto DESC LIMIT ?, ? ";
        if (!$stmt = $this->conn->prepare($sql)) {
            die("Error al preparar la sentencia: " . $this->conn->error);
        }
        $stmt->bind_param('ii', $inicio, $registros);
        $stmt->execute();

        $result = $stmt->get_result();

        $productos = array();
        while ($row = $result->fetch_object('Producto')) {
            $productos[] = $row;
        }

        return $productos;
    }

    public function obtenerPedidosIdUsuario(int $id) {
        $sql = "SELECT * FROM pedidos WHERE idusuario = ?";

        if (!$stmt = $this->conn->prepare($sql)) {
            die("Error al preparar la sentencia: " . $this->conn->error);
        }

        $stmt->bind_param('i',$id);
        $stmt->execute();

        $result = $stmt->get_result();

        $arrayPedidos = array();
        while ($pedidos = $result->fetch_object('Pedido')) {
            $arrayPedidos[] = $pedidos;
        }

        return $arrayPedidos;
    }

}
