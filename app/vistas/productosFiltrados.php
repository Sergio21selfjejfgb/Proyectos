<?php
ob_start();
?>

<div class="listado_productos">
    <h1 id="tituloInicio">Productos</h1>
    <div class="caja_global">
        <?php if(empty($productosFiltrados)){ ?>
        <div class="cajaTituloFallo">
        <h1 class="tituloSinFiltrado">Lamentablemente, no hemos encontrado una coincidencia adecuada para tu búsqueda.</h1>
        </div>
        <?php }else{ ?>
        <?php foreach ($productosFiltrados as $p): ?>
        <div class="caja_productos_datos">
            <img src="web/img/<?= $p->getImagen() ?>" alt="imagenProducto" id="imagenes"/><br><br>
            <?php if(isset($_SESSION['email'])){   
            $idUsuario = $_SESSION['idUsuario'];
            $idProducto = $p->getIdProducto();
            $existeEnFavoritos = $productoDAO->existeEnFavoritos($idUsuario, $idProducto);
            $existeEnCarrito = $productoDAO->existeEnCarrito($idUsuario, $idProducto);
            ?>            
                <?php if($existeEnFavoritos){ ?>
                    <button class="btn-favorito" data-producto-id="<?= $p->getIdProducto() ?>"><i class="fa fa-heart" id="fav" style="color: red"></i></button>
                <?php }else{ ?>
                    <button class="btn-favorito" data-producto-id="<?= $p->getIdProducto() ?>"><i class="fa fa-heart" id="fav"></i></button>
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
        <?php } ?>
    </div>
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
    <div id="cajaCurriculum">
        <a href="">Curriculum</a>
    </div>
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
$vistaProductosFiltrados = ob_get_clean();
require 'app/vistas/plantilla.php';
