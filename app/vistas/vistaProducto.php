<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Producto</title>
        <link href="https://fonts.googleapis.com/css2?family=Black+Ops+One&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" >
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" >
        <link rel="stylesheet" type="text/css" href="web/css/styleVistaProducto.css">
        
    </head>
    <body>
        <div id="cajalogo">
                <a href="index.php"><img src="web/img/l.png" alt="logo" id="logo"/></a>
        </div>
        <div class="cajaProducto">
            <?php foreach ($producto as $pro): ?>
            <br><br>
            <div class="cajaImagenyNombre">
                <h2 id="tituloNombre"><?= $pro->getNombre() ?></h2><br>
                <img src="web/img/<?= $pro->getImagen() ?>" alt="imagenProducto" id="imagenes"/><br>
            </div>               
            <br><br>
            <div class="cajaDatos">
                <?php if(isset($_SESSION['email'])){   
                    $idUsuario = $_SESSION['idUsuario'];
                    $idProducto = $pro->getIdProducto();
                    $existeEnFavoritos = $productoDAO->existeEnFavoritos($idUsuario, $idProducto);
                    $existeEnCarrito = $productoDAO->existeEnCarrito($idUsuario, $idProducto);
                ?> 
                    <?php if($existeEnFavoritos){ ?>
                        <button class="btn-favorito" data-producto-id="<?= $pro->getIdProducto() ?>"><i class="fa fa-heart" id="fav" style="color: red"></i></button>
                    <?php }else{ ?>
                        <button class="btn-favorito" data-producto-id="<?= $pro->getIdProducto() ?>"><i class="fa fa-heart" id="fav"></i></button>
                    <?php } ?>

                    <?php if($existeEnCarrito){ ?>
                        <button class="btn-carrito" data-producto-id="<?= $pro->getIdProducto() ?>"><i class="fa fa-shopping-cart" id="cart" style="color: blue"></i></button>                    
                    <?php }else{ ?>
                        <button class="btn-carrito" data-producto-id="<?= $pro->getIdProducto() ?>"><i class="fa fa-shopping-cart" id="cart"></i></button>
                    <?php } ?>
                <?php } ?> 
                <h3 id="precio"><?= $pro->getPrecio() ?>€</h3><br><br><br><br>
                <h3>Descripción:<h3><h4 id="descripcion"><?= $pro->getDescripcion() ?></h4><br><br>
                        
                       
            
            </div>
            <?php endforeach; ?>
        </div>
    </body>
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
</html>
