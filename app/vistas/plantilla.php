<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>GAME LOOT</title>
        <link rel="icon" type="image/x-icon" href="web/img/l.png">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Black+Ops+One&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" >
        <link rel="stylesheet" type="text/css" href="web/css/styleInicioyPlantilla.css">

        <style>
        </style>
    </head>
    <body>        
        <div class="cajatitulo">
            <header>
            <div id="cajalogo">
                <a href="index.php?action=inicio"><img src="web/img/l.png" alt="logo" id="logo"/></a>
            </div>
            <div id="cajabuscar">                
                <div class="row">
                    <div class="col">
                      <form action="index.php?action=ir_productosFiltrados" method="post" class="d-flex">
                        <input type="text" name="busqueda" placeholder="Buscar" class="form-control">
                        <button type="submit" name="buscar" class="btn btn-dark">
                          <i class="fas fa-search"></i>
                        </button>
                      </form>
                    </div>
                  </div>

            </div>            
            <?php if(isset($_SESSION['email'])){ ?>
            <div id="cajalogout">
                <p id="email"><?= $_SESSION['email'] ?></p>            
                <a href="index.php?action=logout"><img src="web/img/un-hombre-caminando.png" width="30px" height="30px" alt="cerrarsesion"/></a>
            </div>
            <?php }else{ ?>                
            <div id="cajalogin">
                <a href="index.php?action=irlogin"><img src="web/img/user.png" alt="imagen usuario" id="login"/></a>
            </div>
            <?php } ?>
                <div id="cajaOpciones">
            <div id="cajafavorito">
                <a href="index.php?action=ir_favoritos"><img src="web/img/amor.png" alt="favorito" id="favorito"/></a>
            </div>
            <div id="cajacarrito">  
                <a href="index.php?action=ir_carrito"><img src="web/img/carritoo.png" alt="carrito" id="carrito"/></a>
            </div>
                    </div>
        </div>
        </header>
        <main class="container">
            <?php MensajeFlash::imprimirMensajes() ?>
            <?php
            if(isset($_POST['buscar']) && !empty($_POST['busqueda'])){
                print $vistaProductosFiltrados;
            }else{
                print $vista;  
            }
            
            ?>
        </main>
    </body>
</html>
