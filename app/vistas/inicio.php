<?php
ob_start();
?>
<div class="listado_productos">
    <?php if(isset($_SESSION['email'])){
            if($_SESSION['rol'] == 'admin'){?>    
                <div class="enlaceAdmin"><a href="index.php?action=ir_modo_admin" >Modo administrador</a></div>
        <?php 
            }
            else if($_SESSION['rol'] != 'admin'){ ?>
<!--                <a href="">Servicio técnico / garantía </a>            -->
    <?php }
    }?>
                
    <h1 id="tituloInicio">Productos</h1>
    
    <div class="caja_global">
    <!-- paginacion //////////////////////////////////////-->
        <?php 
        if (!empty($_REQUEST['numer'])) {
            $_REQUEST['numer'] = $_REQUEST['numer'];            
        } else {
            $_REQUEST['numer'] = '1';    
        }

        if ($_REQUEST['numer'] == '') {
            $_REQUEST['numer'] = '1';
        }
        $numProductos = $productoDAO->numProductos();
        $registros = 12;
        $pagina = $_REQUEST['numer'];

        if (is_numeric($pagina)) {
            $inicio = (($pagina-1) * $registros);
        } else {
            $inicio = 0;
            die("Página inválida");
        }

        $productoDAO = new ProductosDAO(ConexionBD::conectar());
        $busqueda = $productoDAO->productosPaginacion($inicio, $registros);

        $paginas = ceil($numProductos / $registros);
        ?>
    <!-- fin paginacion ///////////////////////// -->
    
        <?php foreach ($busqueda as $p): ?>
        <div class="caja_productos_datos">
            <a href="index.php?action=ir_vista_producto&idPro=<?= $p->getIdProducto() ?>"><img src="web/img/<?= $p->getImagen() ?>" alt="imagenProducto" id="imagenes"/></a><br><br>
            <?php if(isset($_SESSION['email'])){   
            $idUsuario = $_SESSION['idUsuario'];
            $idProducto = $p->getIdProducto();
            $existeEnFavoritos = $productoDAO->existeEnFavoritos($idUsuario, $idProducto);
            $existeEnCarrito = $productoDAO->existeEnCarrito($idUsuario, $idProducto);
            ?>            
                <?php if($existeEnFavoritos){ ?>
                    <button class="btn-favorito" data-producto-id="<?= $p->getIdProducto() ?>"><i class="fa fa-heart " id="fav" style="color: red"></i></button>
                <?php }else{ ?>
                    <button class="btn-favorito" data-producto-id="<?= $p->getIdProducto() ?>"><i class="fa fa-heart " id="fav"></i></button>
                <?php } ?>
                    
                <?php if($existeEnCarrito){ ?>
                    <button class="btn-carrito" data-producto-id="<?= $p->getIdProducto() ?>"><i class="fa fa-shopping-cart" id="cart" style="color: blue"></i></button>                    
                <?php }else{ ?>
                    <button class="btn-carrito" data-producto-id="<?= $p->getIdProducto() ?>"><i class="fa fa-shopping-cart" id="cart"></i></button>
                <?php } ?>
            <?php } ?>
                <h2><?= $p->getNombre() ?></h2>
                <h3><?= $p->getPrecio() ?>€</h3>
        </div>
        <?php endforeach; ?>
    
    </div>
    
    <!-- paginacion //////////////////////////////////////-->
    <div class="container-fluid  col-12">
        <ul class="pagination pg-dark justify-content-center pb-5 pt-5 mb-0" style="float: none;"  >
            <li class="page-item">
            <?php
            if($_REQUEST["numer"] == "1" ){
                $_REQUEST["numer"] == "0";
                echo  "";
            }else{
                if ($pagina>1){
                    $ant = $_REQUEST["numer"] - 1;
                    echo "<a class='page-link' aria-label='Previous' href='index.php?action=inicio&numer=1'><span aria-hidden='true'>&laquo;</span><span class='sr-only'>Previous</span></a>"; 
                    echo "<li class='page-item '><a class='page-link' href='index.php?numer=". ($pagina-1) ."' >".$ant."</a></li>"; 
                }            
            }
            echo "<li class='page-item active'><a class='page-link' >".$_REQUEST["numer"]."</a></li>"; 
            $sigui = $_REQUEST["numer"] + 1;
            $ultima = $numProductos / $registros;
            
            if ($ultima == $_REQUEST["numer"] +1 ){
                $ultima == "";            
            }
            if ($pagina<$paginas && $paginas>1){
                echo "<li class='page-item'><a class='page-link' href='index.php?numer=". ($pagina+1) ."'>".$sigui."</a></li>"; 
            }            
            if ($pagina<$paginas && $paginas>1){
                echo "
                <li class='page-item'><a class='page-link' aria-label='Next' href='index.php?numer=". ceil($ultima) ."'><span aria-hidden='true'>&raquo;</span><span class='sr-only'>Next</span></a>
                </li>";
            }
            
            ?>
        </ul>
    </div>
    <!-- fin paginacion ///////////////////////// -->
</div>
<footer class="itemFooter">
    <div id="redes">
        <h3>Redes sociales:</h3>
        <a href="https://www.instagram.com" target="_blank"><img src="web/img/inta.png" alt="inta"></a>
        <a href="https://twitter.com/?lang=es" target="_blank"><img src="web/img/twit.png" alt="twi"></a>
    </div >
    <div id="redes">
        <h3>Telefono:</h3>
        <p>+34 123123123</p>
    </div>
<!--    <div id="cajaCurriculum">
        <a href="index.php?action=ir_informacionSobreMi">Sobre Mí</a>
    </div>-->
    <div id="redes">
        <p>GameLoot &copy;</p>
    </div>
    
</footer>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
    $('.btn-favorito').click(function() {
        var productId = $(this).data('producto-id');
        var btnFavorito = $(this);
        // Realizar la comprobación de existencia en favoritos
        $.ajax({
            type: 'POST',
            url: 'index.php?action=comprobar_producto_favorito',
            data: { productId: productId },
            success: function(data) {
                // Comprobar el resultado de la respuesta
                console.log(data);
                if (data === true) {                    
                    // El producto ya está en la lista de favoritos
                    console.log('El producto ya está en favoritos');
                    
                } else {
                    // El producto no está en la lista de favoritos
                    console.log('El producto no está en favoritos'); 
                    // Agregar estilo al botón para que sea rojo
                    btnFavorito.find('i').css('color', 'red');
                    // Realizar la inserción del producto en favoritos
                    $.ajax({
                        type: 'POST',
                        url: 'index.php?action=insertar_producto_favorito',
                        data: { productId: productId },
                        success: function(data) {
                            // Procesar la respuesta
                            console.log('Producto añadido a favoritos');
                        },
                        error: function(error){
                            alert('Error al añadir a favoritos');
                        }
                    });
                }
            },
            error: function(error){
                alert('Error al comprobar el producto favorito');
            }
        });
    });
});


$(document).ready(function() {
    $('.btn-carrito').click(function() {
        var productId = $(this).data('producto-id');
        var btnCarrito = $(this);
            $.ajax({
            type: 'POST',
            url: 'index.php?action=comprobar_producto_carrito',
            data: { productId: productId },
            success: function(data) {
                // Comprobar el resultado de la respuesta
                console.log(data);
                if (data === true) {                    
                    // El producto ya está en la lista de favoritos
                    console.log('El producto ya está en carrito');
                    
                } else {
                    // El producto no está en la lista de favoritos
                    console.log('El producto no está en carrito'); 
                    // Agregar estilo al botón para que sea rojo
                    btnCarrito.find('i').css('color', 'blue');
                    // Realizar la inserción del producto en favoritos
                    $.ajax({
                        type: 'POST',
                        url: 'index.php?action=insertar_producto_carrito',
                        data: { productId: productId },
                        success: function(data) {
                            // Procesar la respuesta
                            console.log('Producto añadido a carrito');
                        },
                        error: function(error){
                            alert('Error al añadir a carrito');
                        }
                    });
                }
            },
            error: function(error){
                alert('Error al comprobar el producto favorito');
            }
        });
        
    });
});
</script>    
<?php
$vista = ob_get_clean();
require 'app/vistas/plantilla.php';
