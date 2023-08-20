<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>MODIFICAR PRODUCTOS</title>
        <link rel="icon" type="image/x-icon" href="web/img/l.png">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-fhfV51qFvWopJ/3fAbUP5lo7oBkoQk9ytaDQ9lZ4Rt3Ch3Ec6pH+Nk5SCT/cqnzCzBksgQ1w9X1rFbMyzZqfqw==" crossorigin="anonymous" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" >
        <link rel="stylesheet" type="text/css" href="web/css/styleModificarProducto.css"> 
    </head>
    <body>
        <div><a href="index.php?action=ir_modo_admin"><img src="web/img/flecha.png" width="50" height="50" alt="alt"/></a></div>
        <h1>Modificar Producto</h1>
        <p><?php MensajeFlash::imprimirMensajes() ?></p>
        <div class="cajaFormulario">
            <form action="index.php?action=modificar_producto&id=<?= $id ?>" method="post" enctype="multipart/form-data">
                <div class="form-group col-md-10">
                    <input type="text" name="nombre" class="form-control" id="nombre" value="<?=$productos->getNombre()?>" ><br>
                </div>
                <div class="form-group col-md-10">
                    <textarea class="form-control" name="descripcion"><?=$productos->getDescripcion()?></textarea><br>
                </div>
                <div class="form-group col-md-10">
                    <input type="text" class="form-control" name="categoria" id="categoria" value="<?=$productos->getCategoria()?>"><br>
                </div>
                <div class="form-group col-md-3">
                    <input type="number" class="form-control" min="0" name="precio" id="precio" step="any" value="<?=$productos->getPrecio()?>" ><br>
                </div>
                <div class="form-group col-md-10">
                    <input type="file" name="img" class="form-control" id="imagen"><br>
                </div>
                <input type="submit" class="btn btn-secondary" id="botonModificarProducto" value="Modificar Producto">
            </form>
        </div>
    </body>
</html>
