<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>CARRITO</title>
        <link rel="icon" type="image/x-icon" href="web/img/l.png">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet">        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" type="text/css" href="web/css/styleCarrito.css">
        
    </head>
    <body>
        <div id="cajalogo">
                <a href="index.php"><img src="web/img/l.png" alt="logo" id="logo"/></a>
        </div>
            <?php $total = 0; ?>
            <?php $size = count($productosCarrito);
            if($size == 0){ ?>
            <div class="cajaSinProductos">
                <h1 id="titulo2">Carrito</h1>
                <h1>No hay productos en tu carrito </h1><br>
                <div id="enlaceSeguirComprando"><a href="index.php"><p>Continuar comprando</p></a></div>
            </div>
            <?php } else{ ?>
            <h1 id="titulo">Carrito</h1>
            <?php foreach ($productosCarrito as $pc): ?>
            
            <table>
                <tr>
                    <form action="index.php?action=insertar_pedido&id=<?= $pc->getIdProducto() ?>" method="post">
                        <div class="cajaDatos">
                            <div class="cajaImagen">
                                <img src="web/img/<?= $pc->getImagen() ?>" alt="imagenProducto" id="imagenes"/>
                            </div>
                            <div class="cajaInputs">
                                <input type="text" readonly="" disabled name="nombre" id="nombre" value="<?=$pc->getNombre()?>" ><br><br>
                                <input type="number" readonly="" name="precio" id="precio" value="<?=$pc->getPrecio()?>" ><span class="currency-symbol">€</span><br><br>
                                <input type="number" min="0" name="cantidad[]" id="cantidad<?=$pc->getIdProducto()?>" value="<?=$pc->getCantidad()?>" onchange="actualizarTotal()"><br><br>
                                <div class = "borrar"><a href = "index.php?action=borrar_producto_carrito&id=<?= $pc->getIdProducto() ?>"><i class = "fa-solid fa-trash" ></i></a></div>
                            </div>
                        </div>
                        <br><br>                        
                </tr>                   
                <?php 
                $total += $pc->getPrecio() * $pc->getCantidad(); 
                $total = number_format($total, 2);
                ?>
            
            <?php endforeach; ?>
                <?php }?>
            </table>    
                <?php if($size == 0){ ?>
                    
                <?php }else{?>
                <div class="resumen">
                    <h1>Resumen</h1>
                    <h2>Total <span id="total"><?= $total ?></span>€</h2>                    
                    <input type="submit" id="botonPedido" value="Tramitar Pedido"><br><br>                    
                </div>
                </form>
                <?php }?>
        
        
        <script>
            function actualizarTotal() {
            var inputsCantidad = document.querySelectorAll('input[name="cantidad[]"]');
            var total = 0;

            for (var i = 0; i < inputsCantidad.length; i++) {
                var cantidad = inputsCantidad[i].value;
                var precio = inputsCantidad[i].previousElementSibling.previousElementSibling.previousElementSibling.previousElementSibling.value;
                total += cantidad * precio;
            }
            total = total.toFixed(2);

            // Actualizar el valor en el elemento HTML
            document.getElementById('total').textContent = total;
        }
        </script>

    </body>
</html>
