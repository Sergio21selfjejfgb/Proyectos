<?php

class UsuariosController {

    function irlogin(){
       require 'app/vistas/loginYregistrar.php'; 
    }
    
    function ir_listado_usuarios(){
        $usuarioDAO = new UsuarioDAO(ConexionBD::conectar());
        $usuarios = $usuarioDAO->obtenerTodosUsuarios();  
        
       require 'app/vistas/listadoUsuarios.php'; 
    }
    
    function ir_modo_admin(){ 
        $productoDAO = new ProductosDAO(ConexionBD::conectar());
        $productos = $productoDAO->obtenerTodosProductos();
        
       require 'app/vistas/modoAdmin.php'; 
    }
    
    function ir_informacionSobreMi() {
        require 'app/vistas/informacionSobreMi.php'; 
    }
    
    function ir_curriculum() {
        require 'app/vistas/curriculum.php';
    }

    function registrar() {
        $email = "";
        $password = "";
        $nombre = "";

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $usuario = new Usuario();
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
            $nombre = filter_var($_POST['nombre'],FILTER_SANITIZE_STRING);
            $error = false;
            
            //Comprobamos si existe un usuario con el mismo email
            $usuarioDAO = new UsuarioDAO(ConexionBD::conectar());
            if ($usuarioDAO->obtenerPorEmail($email)) {
                //Ya existe un usuario con el mismo email
                MensajeFlash::guardarMensaje("Email repetido");
                $error = true;
            }

            if (!$error) {                
                $passwordCodificada = password_hash($password, PASSWORD_BCRYPT);
                $usuario->setEmail($email);
                $usuario->setPassword($passwordCodificada);
                $usuario->setNombreCompleto($nombre);
                $usuario->setRole('user');
                $usuarioDAO->insertar($usuario);

                // Iniciar sesión después del registro
                $usuarioLogueado = $usuarioDAO->obtenerPorEmail($email);
                if ($usuarioLogueado && password_verify($password, $usuarioLogueado->getPassword())) {
                    $_SESSION['nombreCompleto'] = $usuarioLogueado->getNombreCompleto();
                    $_SESSION['email'] = $usuarioLogueado->getEmail();
                    $_SESSION['rol'] = $usuarioLogueado->getRole();
                    $_SESSION['idUsuario'] = $usuarioLogueado->getIdUsuario();
                    header('Location: index.php');
                    die();
                }
            }
        }
        require 'app/vistas/loginYregistrar.php';
    }

    function login() { 
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
        
        $usuDAO = new UsuarioDAO(ConexionBD::conectar());
        $usu = $usuDAO->obtenerPorEmail($email);

        if (!$usu) {  //El usuario con ese email no existe.
            MensajeFlash::guardarMensaje("El usuario o la contraseña no son válidos");
            header("Location: index.php?action=irlogin");
            die();
        }
        //Usuario con ese email si existe
        elseif (!password_verify($password, $usu->getPassword())) {   //Login incorrecto
            MensajeFlash::guardarMensaje("La contraseña no es válida");
            header("Location: index.php?action=irlogin");
            die();
        } else {
            //Usuario y contraseña son correctos. 
            //Iniciamos sesión
            $_SESSION['nombreCompleto'] = $usu->getNombreCompleto();
            $_SESSION['email'] = $usu->getEmail();
            $_SESSION['rol'] = $usu->getRole();
            $_SESSION['idUsuario'] = $usu->getIdUsuario();
            

            header("Location: index.php");
            die();
        }
    }

    function logout() {
        session_destroy();
        header("Location: index.php");
    }

    //Se va a utilizar desde una conexión AJAX
    function comprobar_email() {
        //Indicar al navegador que la respuesta es un json
        header("Content-type: application/json; charset=utf-8");

        //Si no se ha enviado el email por post devolvemos un mensaje de error
        if (!isset($_POST['email'])) {
            print json_encode(["error" => "Falta parámetro email"]);
            die();
        }
        
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $usuarioDAO = new UsuarioDAO(ConexionBD::conectar());
        if ($usuarioDAO->obtenerPorEmail($email) != false) {
            //Devolvemos un json
            print json_encode(["repetido" => true]);
        } else {
            print json_encode(["repetido" => false]);
        }
        //Para simular un retardo en el servidor. Se quita después en producción.
        sleep(1);
    }

}
