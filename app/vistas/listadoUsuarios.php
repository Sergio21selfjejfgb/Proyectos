<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>LISTA USUARIOS</title>
        <link rel="icon" type="image/x-icon" href="web/img/l.png">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-fhfV51qFvWopJ/3fAbUP5lo7oBkoQk9ytaDQ9lZ4Rt3Ch3Ec6pH+Nk5SCT/cqnzCzBksgQ1w9X1rFbMyzZqfqw==" crossorigin="anonymous" />
        <link rel="stylesheet" type="text/css" href="web/css/styleListaUsuarios.css">        
    </head>
    <body>
        <div><a href="index.php?action=ir_modo_admin"><img src="web/img/flecha.png" width="50" height="50" alt="alt"/></a></div>
        <h1>Listado Usuarios</h1><br><br>      
        <table>
            <tr>
                <th>Id Usuario</th>
                <th>Nombre Completo</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Pedidos</th>
            </tr>
            <?php foreach ($usuarios as $usu): ?>
            <tr>                
                <td><?= $usu->getIdUsuario() ?></td>
                <td><?= $usu->getNombreCompleto() ?></td>
                <td><?= $usu->getEmail() ?></td>
                <td><?= $usu->getRole() ?></td> 
                <td><a href="index.php?action=ir_listado_pedidos&id=<?= $usu->getIdUsuario() ?>"><img src="web/img/pedidos.png" width="50" height="50" alt="alt"/></a></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </body>
</html>
