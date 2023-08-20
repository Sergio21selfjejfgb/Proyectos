<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>LOGIN</title>
        <link rel="icon" type="image/x-icon" href="web/img/l.png">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="web/css/styleLoginyRegistrar.css">
        <style>
            #cajalogo{
                padding: 20px;
                height: 80px;
            }
            #logo{
                width: 100px;
                height: 80px;
                border-radius: 15%;
            }
        </style>
    </head>
    <body>        
	<div class="section">
            <div id="cajalogo">
                <a href="index.php"><img src="web/img/l.png" alt="logo" id="logo"/></a>
            </div>
		<div class="container">
			<div class="row full-height justify-content-center">
				<div class="col-12 text-center align-self-center py-5">
					<div class="section pb-5 pt-5 pt-sm-2 text-center">
						<h6 class="mb-0 pb-3"><span>Login </span><span>Registrar</span></h6>
			          	<input class="checkbox" type="checkbox" id="reg-log" name="reg-log"/>
			          	<label for="reg-log"></label>
                                        <?php MensajeFlash::imprimirMensajes(); ?>
						<div class="card-3d-wrap mx-auto">
							<div class="card-3d-wrapper">
								<div class="card-front">
									<div class="center-wrap">
										<div class="section text-center">
											<h4 class="mb-4 pb-3">Login</h4>
                                                                                        <form action="index.php?action=login" method="post">
											<div class="form-group">
												<input type="email" name="email" class="form-style" placeholder="Email" id="logemail" autocomplete="off">
												<i class="input-icon uil uil-at"></i>
											</div>	
											<div class="form-group mt-2">
												<input type="password" name="password" class="form-style" placeholder="Password" id="logpass" autocomplete="off">
												<i class="input-icon uil uil-lock-alt"></i>
											</div>
											<input class="btn mt-4" type="submit" value="Enviar"/>
                                                                                        </form>
				      					</div>
			      					</div>
			      				</div>
								<div class="card-back">
									<div class="center-wrap">
										<div class="section text-center">
											<h4 class="mb-4 pb-3">Registrar</h4>
                                                                                        <form action="index.php?action=registrar" method="post" enctype="multipart/form-data">
                                                                                            <div class="form-group">
                                                                                                    <input type="text" name="nombre" class="form-style" placeholder="Nombre Completo" id="logname" autocomplete="off">
                                                                                                    <i class="input-icon uil uil-user"></i>
                                                                                            </div>	
                                                                                            <div class="form-group mt-2">
                                                                                                    <input type="email" name="email" class="form-style" placeholder="Email" id="logemail" autocomplete="off">
                                                                                                    <i class="input-icon uil uil-at"></i>
                                                                                            </div>	
                                                                                            <div class="form-group mt-2">
                                                                                                    <input type="password" name="password" class="form-style" placeholder="Password" id="logpass" autocomplete="off">
                                                                                                    <i class="input-icon uil uil-lock-alt"></i>
                                                                                            </div>
                                                                                            <input class="btn mt-4" type="submit" value="Enviar"/>
                                                                                        </form>
				      					</div>
			      					</div>
			      				</div>
			      			</div>
			      		</div>
			      	</div>
		      	</div>
	      	</div>
	    </div>
	</div>
    </body>
</html>
