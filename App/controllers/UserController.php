<?php

require_once MODELS_FOLDER . 'UserModel.php';

/**
 * Controlador para las acciones que tengan que ver con los usuarios
 */

class UserController extends BaseController
{

    private $modelo;     // para acceder al modelo desde el controlador


    public function __construct()
    {
        parent::__construct();
        $this->modelo = new UserModel();
    }


    /**
     * Función para añadir nuevos usuarios al a base de datos, en base a los datos introducidos en la página de registro
     */
    public function adduser()
    {
        $errores = array();

        if (isset($_POST) && !empty($_POST)) {

            $nombre = filter_var($_POST['nombre'], FILTER_SANITIZE_STRING);
            $apellidos = filter_var($_POST['apellidos'], FILTER_SANITIZE_STRING);
            $nif = filter_var($_POST['nif'], FILTER_SANITIZE_STRING);
            $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
            $telefono = filter_var($_POST['telefono'], FILTER_SANITIZE_STRING);
            $direccion = filter_var($_POST['direccion'], FILTER_SANITIZE_STRING);
            $usuario = filter_var($_POST['login'], FILTER_SANITIZE_STRING);
            $password = $_POST['password'];
            $confirmaPass = $_POST['confirmaPass'];

            $comprobarUsuario = new UserModel();
            $comprobarUsuario = $comprobarUsuario->comprobarRegistroUsuario($usuario, $email);
            $comprobarUsuario = $comprobarUsuario["correcto"];

            if (!$comprobarUsuario) { //usuario no registrado

                if (!strcmp($password, $confirmaPass) == 0) {
                    $errores["PassDif"] = "Las contraseñas introducidas deben coincidir";
                }


                if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
                } else {
                    $errores["email"] = "El email no tiene un formato correcto";
                }

                if (!preg_match('/^[0-9]{8}[A-Z]{1}$/', $nif)) {
                    $errores["dni"] = "El dni no tiene un formato correcto";
                }

                if (!preg_match('/^[0-9]{9}$/', $telefono)) {
                    $errores["telefono"] = "El telefono no tiene un formato correcto";
                }


                $imagen = NULL;
               
                if (isset($_FILES["imagen"]) && (!empty($_FILES["imagen"]["tmp_name"]))) { //si "tmp_name" no está vacio, se ha recibido la imagen 

                    if (!is_dir("assets/img/avatarUsers")) { // Si la carpeta con los avatares no existe, la creamos
                        $dir = mkdir("assets/img/avatarUsers", 0777, true);
                    } else {
                        $dir = true;
                    }
                   
                    if ($dir) {                        
                        $nombrefichimg = time() . "-" . $_FILES["imagen"]["name"];   //ponemos nombre único                     
                        $movfichimg = move_uploaded_file($_FILES["imagen"]["tmp_name"], "assets/img/avatarUsers/" . $nombrefichimg); //movemos el fichero
                        $imagen = $nombrefichimg;                        
                        if (!$movfichimg) {
                            $errores["imagen"] = "La imagen no se cargó correctamente";
                        }
                    }
                }
                // Si no hay errores registramos el usuario
                if (count($errores) == 0) {
                    $password = md5($password);
                    $this->modelo->adduser([ 
                        'nif' =>  $nif,
                        'nombre' => $nombre,
                        'apellidos' => $apellidos,
                        'imagen' => $imagen,
                        'usuario' => $usuario,
                        "password" => $password,
                        'email' => $email,
                        'telefono' => $telefono,
                        'direccion' => $direccion
                    ]);
                }
            } else { // usuario ya registrado
                $errores["yaRegistrado"] = "Error, usuario o correo ya registrados";
            }
        }
            $parametros = [
                "tituloventana" => "Registro",
                "nombre" => isset($nombre) ? $nombre : "",
                "usuario" => isset($usuario) ? $usuario : "",
                "email" => isset($email) ? $email : "",
                "imagen" => isset($imagen) ? $imagen : "",
                "nif" => isset($nif) ? $nif : "",
                "telefono" => isset($telefono) ? $telefono : "",
                "direccion" => isset($direccion) ? $direccion : "",
                "apellidos" => isset($apellidos) ? $apellidos : "",
                "errores" => $errores
            ];
        
        //Visualizamos la vista asociada al registro de usuarios
        $this->view->show("Register", $parametros);
    }
}
