<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>MODO ADMINISTRADOR</title>
        <link rel="icon" type="image/x-icon" href="web/img/l.png">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-fhfV51qFvWopJ/3fAbUP5lo7oBkoQk9ytaDQ9lZ4Rt3Ch3Ec6pH+Nk5SCT/cqnzCzBksgQ1w9X1rFbMyzZqfqw==" crossorigin="anonymous" />

        <link rel="stylesheet" type="text/css" href="web/css/styleModoAdmin.css">
        
    </head>
    <body>
        <div class="contenedor">
            <div id="cajalogo">
                    <a href="index.php"><img src="web/img/l.png" alt="logo" id="logo"/></a>
            </div>
            <header class="itemHeader">
                <h1>Modo Administrador</h1>
                <h2><?= $_SESSION['nombreCompleto'] ?></h2>
            </header>
            <nav class="itemNav">
                <a href="index.php?action=ir_listado_usuarios">Lista Usuarios</a>
                <a href="index.php?action=insertar_producto">Insertar Producto</a>
            </nav>
        </div>
        <br><br>
        <table>
            <thead>
            <tr>
                <th>Imagen</th>
                <th>Categoría</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Precio</th> 
                <th>Fecha Producto</th>
                <th colspan="2">Operaciones</th>
            </tr>
            </thead>
            <?php foreach ($productos as $pro): ?>
            <tbody>
            <tr id="tabla">                
                <td><img src="web/img/<?= $pro->getImagen() ?>" alt="imagen" id="imagenesProductos"/></td>
                <td><?= $pro->getCategoria() ?></td>
                <td><?= $pro->getNombre() ?></td>
                <td class="descripcion"><?= $pro->getDescripcion() ?></td>
                <td><?= $pro->getPrecio() ?></td>
                <td><?= $pro->getFechaProducto() ?></td>
                <td class="botonborrar">
                    <div class = "borrar"><a href = "index.php?action=borrar_producto&id=<?= $pro->getIdProducto() ?>"><i class = "fa-solid fa-trash" ></i></a></div>
                 </td>
                <td class="botonModificar">
                    <a href="index.php?action=modificar_producto&id=<?= $pro->getIdProducto() ?>"><i class="fas fa-edit"></i></a>
                </td>                
            </tr>
            </tbody>
            <?php endforeach; ?>
        </table>
        
    </body>
</html>
