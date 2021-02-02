<?php


if (isset($_COOKIE["mantenerSesion"]) && $_COOKIE["mantenerSesion"] == false) {
   ini_set("session.cookie_lifetime", "600");
   ini_set("session.gc_maxlifetime", "600");
}

require_once MODELS_FOLDER . 'UserModel.php';
require_once MODELS_FOLDER . 'TramosModel.php';



/**
 * Controlador de las funciones comunes para todos los usuarios
 */
class HomeController extends BaseController
{
   public function __construct()
   {
      parent::__construct();
      $this->modelo = new UserModel();
   }


   /**
    * Función que muestra la página de inicio del gimnasio.
    */
   public function index()
   {

      if ($_SESSION["verificado"]) {

         $parametros = [
            "tituloventana" => "Inicio"
         ];
         $this->view->show("Inicio", $parametros);
      } else {
         $this->redirect("Index", "index");
      }
   }

   /**
    * Función que muestra una página que indica que esta funcionalidad está en desarrollo.
    */
   public function desarrollo()
   {

      if ($_SESSION["verificado"]) {

         $parametros = [
            "tituloventana" => "En progreso..."

         ];
         $this->view->show("Desarrollo", $parametros);
      } else {
         $this->redirect("Index", "index");
      }
   }


   /**
    * Función para mostrar la página con el horario
    */
   public function horario()
   {

      if ($_SESSION["verificado"]) {
         $horario = new TramosModel();
         $horario = $horario->listadoHorario();
         $horario = $horario["datos"];
         $listaHoras = new TramosModel();
         $listaHoras = $listaHoras->listadoHoras();
         $listaHoras = $listaHoras["datos"];

         $parametros = [
            "tituloventana" => "Horario",
            "horario" => $horario,
            "listaHoras" => $listaHoras
         ];
         $this->view->show("Horario", $parametros);
      } else {
         $this->redirect("Index", "index");
      }
   }

   /**
    * Función para cerrar la sesión del usuario
    */
   public function cerrarSesion()
   {
      session_unset();
      session_destroy();
      $this->redirect("Index", "index");
   }

   /**
    * Función para mostrar la página de edición de perfil propio
    */
   public function miPerfil()
   {

      if ($_SESSION["verificado"]) {
         $user = new UserModel();
         $usuario = $user->verUsuario($_SESSION["id"]);
         $parametros = [
            "tituloventana" => "Mi Perfil",
            "usuario" => $usuario["datos"]
         ];
         $this->view->show("miPerfil", $parametros);
      } else {
         $this->redirect("Index", "index");
      }
   }


   /**
    * Función para actualizar los datos del perfil
    */
   public function editarPerfil()
   {
      $errores = array();

      if (isset($_POST) && !empty($_POST)) {


         $id = $_SESSION['id'];
         $nombre = filter_var($_POST['nombre'], FILTER_SANITIZE_STRING);
         $apellidos = filter_var($_POST['apellidos'], FILTER_SANITIZE_STRING);
         $nif = filter_var($_POST['nif'], FILTER_SANITIZE_STRING);
         $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
         $telefono = filter_var($_POST['telefono'], FILTER_SANITIZE_STRING);
         $direccion = filter_var($_POST['direccion'], FILTER_SANITIZE_STRING);
         $usuario = filter_var($_POST['login'], FILTER_SANITIZE_STRING);

         $user = ($this->modelo->verUsuario($id))["datos"];

         

         $nuevaimagen = "";


         $imagen =  $user["imagen"]; 

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

         if (isset($_FILES["imagen"]) && (!empty($_FILES["imagen"]["tmp_name"]))) { //si "tmp_name" no está vacio, se ha recibido la imagen

            if (!is_dir("assets/img/avatarUsers")) { // Si la carpeta con los avatares no existe, la creamos
               $dir = mkdir("assets/img/avatarUsers", 0777, true);
            } else {
               $dir = true;
            }

            if ($dir) {
               $nombrefichimg = time() . "-" . $_FILES["imagen"]["name"]; //ponemos un nombre único

               $movfichimg = move_uploaded_file($_FILES["imagen"]["tmp_name"], "assets/img/avatarUsers/" . $nombrefichimg);
               $nuevaimagen = $nombrefichimg;
               $imagen = $nuevaimagen;

               if (!$movfichimg) {
                  $errores["imagen"] = "La imagen no se cargó correctamente";
               }
            }
         }

         if (count($errores) == 0) {

            $password = $user["password"];

            if (isset($_POST["password"]) && !empty($_POST["password"])) {
               $password = $_POST["password"];
               $password = md5($password);
            }

            if (isset($_FILES["imagen"]) && !empty($_FILES["imagen"]["tmp_name"])) {

               $resultModelo = $this->modelo->actuserConImagen([
                  'id' => $id,
                  'nombre' => $nombre,
                  'email' => $email,
                  'imagen' => $imagen,
                  'direccion' => $direccion,
                  'telefono' => $telefono,
                  'login' => $usuario,
                  'apellidos' => $apellidos,
                  'nif' => $nif,
                  'password' => $password
               ]);
            } else {
               //Ejecutamos la instrucción de actualización a la que le pasamos los valores
               $resultModelo = $this->modelo->actuserSinImagen([
                  'id' => $id,
                  'nombre' => $nombre,
                  'email' => $email,
                  'direccion' => $direccion,
                  'telefono' => $telefono,
                  'login' => $usuario,
                  'apellidos' => $apellidos,
                  'nif' => $nif,
                  'password' => $password
               ]);
            }

            //Analizamos cómo finalizó la operación de registro y generamos un mensaje
            //indicativo del estado correspondiente
            if (!$resultModelo["correcto"]) {
               $errores["actualizarMal"] = "No se pudo actualizar el usuario";
            } else {
               $_SESSION["usuario"] = $usuario;
               $_SESSION["nombre"] = $nombre;
               $_SESSION["apellidos"] = $apellidos;
               $_SESSION["nif"] = $nif;
               $_SESSION["telefono"] = $telefono;
               $_SESSION["direccion"] = $direccion;
               $_SESSION["email"] = $email;
               $_SESSION["img"] = $imagen;
            }
         } else { //hay errores
            $errores["actualizarMal"] = "No se pudo actualizar el usuario";
         }
      }

      $parametros = [
         "tituloventana" => "Mi Perfil",
         "errores" => $errores
      ];
      //Mostramos la vista actuser
      $this->view->show("miPerfil", $parametros);
   }
}
