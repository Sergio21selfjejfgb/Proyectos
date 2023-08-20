<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>PRODUCTOS FAVORITOS</title>
        <link rel="icon" type="image/x-icon" href="web/img/l.png">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Black+Ops+One&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" >
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" >
        <link rel="stylesheet" type="text/css" href="web/css/styleFavoritos.css">
        
    </head>
    <body>
        <div id="cajalogo">
                <a href="index.php"><img src="web/img/l.png" alt="logo" id="logo"/></a>
        </div>
        <?php $size = count($productosFavoritos);
            if($size == 0){ ?>
            <div class="cajaSinProductos">
                <br><br><br><h1 id="titulo2">Lista de deseos</h1><br><br>
                <h1>Todavía no tienes productos en la Lista de deseos.</h1><br>
                <h1>Añade productos a la Lista de deseos y aparecerán aquí.</h1><br>
            </div>
            <?php } else{ ?>
        <br>
        <h1 id="titulo">Lista de deseos</h1><br>
        <div class="caja_global">
            
            <?php foreach ($productosFavoritos as $pf): ?>
            <div class="cajaFavorito">
                <img src="web/img/<?= $pf->getImagen() ?>" alt="imagenProducto" id="imagenes"/><br><br>
                <?php if(isset($_SESSION['email'])){   
                $idUsuario = $_SESSION['idUsuario'];
                $idProducto = $pf->getIdProducto();
                $existeEnCarrito = $productoDAO->existeEnCarrito($idUsuario, $idProducto);
                ?>                        
                <?php if($existeEnCarrito){ ?>
                    <button class="btn-carrito" data-producto-id="<?= $pf->getIdProducto() ?>"><i class="fa fa-shopping-cart" id="cart" style="color: blue"></i></button>                    
                <?php }else{ ?>
                    <button class="btn-carrito" data-producto-id="<?= $pf->getIdProducto() ?>"><i class="fa fa-shopping-cart" id="cart"></i></button>
                <?php } ?>
                    <button class="eliminar_favorito"><a href="index.php?action=borrar_producto_favorito&id=<?= $pf->getIdProducto() ?>"><i class="fa-solid fa-heart-crack" style="color: darkred"></i></a></button><br><br>
                                
                <h2><?= $pf->getNombre() ?></h2>
                <h2><?= $pf->getPrecio() ?>€</h2>                
                
            <?php } ?>
            </div>        
            <?php endforeach; ?>
            <?php }?>
        </div>
    </body>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
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
                    
                    console.log('El producto ya está en carrito');
                    
                } else {
                    
                    console.log('El producto no está en carrito'); 
                    
                    btnCarrito.find('i').css('color', 'blue');
                    
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
