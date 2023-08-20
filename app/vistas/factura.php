<?php
ob_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>FACTURA</title>
        <link rel="icon" type="image/x-icon" href="web/img/l.png">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.21.4/dist/bootstrap-table.min.css">
    <style>
        .titulo{
            padding: 25px;
            font-size: 100px;
            color: grey;
            font-family: fantasy;
            text-align: center;
        }
        #cajalogo{
            padding: 20px;
            position: absolute;
            right: 0;
            top: 0;
        }
        #logo{
            width: 100px;
            height: 80px;
            border-radius: 15%;
        }
       #tablaFactura{
            text-align: center;  
            width: 90%;
            margin-left: 5%;
        }
        #tablaFactura th{
            font-family: inherit;
            font-size: 20px;
            background-color: gray;
            color: white;
        }
        .tabla-total tr{
            border: 2px solid black;            
            
        } 
        .tabla-total td{
            padding: 10px;
        }
        .tabla-total{
            width: 90%;
            margin-left: 5%;
            font-size: 30px;
        }
        #total{
            float: right;
            font-size: 30px;
        }
        .tablaFecha th{
            font-family: inherit;
            background-color: gray;
            color: white;
            font-size: 20px;
            padding: 5px;
        }
        .tablaFecha{
            text-align: center;
            margin-left: 3%;
        }
        .tablaDatos th{
            font-family: inherit;
            background-color: gray;
            color: white;
            font-size: 20px;
            padding: 5px;
        }
        .tablaDatos{
            text-align: center;
            margin-left: 3%;
        }
    </style>
    </head>
    <body>         
        <p class="titulo">Factura</p>
        <div id="cajalogo">
                <img src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/GameLoot/web/img/l.png" alt="logo" id="logo"/>
        </div>
        <table class="tablaFecha">
            <tr>                
                <th>FECHA FACTURA</th>
            </tr>
            <tr>
                <td><p><?php echo date("d/m/Y"); ?></p></td>
            </tr>
        </table><br>
        <table class="tablaDatos">
            <tr>
                <th>FACTURA A </th>
            </tr>
            <tr>
                <td><?= $_SESSION['nombreCompleto'] ?></td>
            </tr>
            <tr>
                <td><?= $_SESSION['email'] ?></td>
            <tr>
        </table>
        <br><br>
        <table data-toggle="table" id="tablaFactura">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Importe</th>
                </tr>
            </thead>
            <tbody>
                <?php $total = 0; ?>
                <?php foreach ($datosProductoPedido as $index => $p): ?>
                    <?php $pc = $productosPedido[$index]; ?>
                    <tr>
                        <td><p><?=$p->getNombre()?></p></td>
                        <td><p><?=$pc->getCantidad()?></p></td>
                        <td><p><?=$pc->getPrecio()?></p></td>
                        <td><p><?=$pc->getPrecio() * $pc->getCantidad()?></p></td>
                    </tr>
                    <?php $total += $pc->getPrecio() * $pc->getCantidad(); ?>
                <?php endforeach; ?>             
                    
            </tbody>
        </table><br><br>
        <table class="tabla-total">
            <tr>
                <td><strong>TOTAL</strong></td>
                <td id="total"><strong><?=$total?>€</strong></td>
            </tr>
        </table>
        
        <script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <script src="https://unpkg.com/bootstrap-table@1.21.4/dist/bootstrap-table.min.js"></script>
    </body>
</html>
<?php
$html = ob_get_clean();

require 'librerias/dompdf/autoload.inc.php';

// Generación del PDF con DOMPDF
use Dompdf\Dompdf;
$dompdf = new Dompdf();

// Opción para permitir mostrar imágenes
$options = $dompdf->getOptions();
$options->set(array('isRemoteEnabled' => true));
$dompdf->setOptions($options);

$dompdf->loadHtml($html);
$dompdf->setPaper('letter');

$dompdf->render();

$dompdf->stream("archivo_.pdf", array("Attachment" => false));
?>