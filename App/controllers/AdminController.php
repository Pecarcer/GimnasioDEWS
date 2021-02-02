<?php

require_once MODELS_FOLDER . 'UserModel.php';
require_once MODELS_FOLDER . 'ActivityModel.php';
require_once MODELS_FOLDER . 'TramosModel.php';

/**
 * Este controlador se usará para todas las acciones que sólo pueda hacer un usuario registrado como administrador
 */
class AdminController extends BaseController
{
   public function __construct()
   {
      parent::__construct();
      $this->modelo = new UserModel();
   }

   /**
    * Esta función sirve para llevar al administrador a la pantalla de administración de usuario y cargar el listado de usuarios
    */
   public function administrarUsuarios()
   {

      $errores = array(); //array con los mensajes de error

      if ($_SESSION["verificado"] && $_SESSION["rol"] == 1) { //Si estás verificado y eres admin

         $user = new UserModel();

         $regsxpag = (isset($_GET['regsxpag'])) ? (int)$_GET['regsxpag'] : 10; //para poner diez elementos por defecto
         $pagina = (isset($_GET['pagina'])) ? (int)$_GET['pagina'] : 1; //para que la primera página mostrada muestre el primer elemento


         $offset = ($pagina > 1) ? (($pagina - 1) * $regsxpag) : 0; //offset se usa para indicar la posición desde donde se muestran los registros


         $totalregistros = $user->totalReg(); //para calcular el número total de registros
         $totalregistros = $totalregistros['datos'];
         $totalregistros = $totalregistros["total"];

         $numpaginas = ceil($totalregistros / $regsxpag); //Para ver el número de páginas de la paginación
         $resultModelo = $user->paginarUsuarios($regsxpag, $offset);

         if ($resultModelo["correcto"]) {
            $parametros["datos"] = $resultModelo["datos"];
         } else { //Ha ocurrido un error, creamos el mensaje            
            $errores["cargaListado"] = "Hubo un error a la hora de hacer el listado  :(";
         }

         $parametros = [
            "tituloventana" => "Admin. Usuarios",
            "datos" =>  $resultModelo["datos"],
            "numpaginas" => $numpaginas,
            "totalregistros" => $totalregistros,
            "pagina" => $pagina,
            "regsxpag" => $regsxpag,
            "errores" => $errores,
            "inicio" => true
         ];
         $this->view->show("AdminUser", $parametros);
      } else {
         $this->redirect("Index", "index");
      }
   }

   /**
    * Función para activar usuarios en la base de datos.
    */
   public function activarUsuarioTabla()
   {
      $errores = array();

      if (isset($_GET['id']) && (is_numeric($_GET['id']))) {
         $id = $_GET["id"];
         // Volver a mostrar el listado
         $regsxpag = (isset($_GET['regsxpag'])) ? (int)$_GET['regsxpag'] : 10;
         //Establecemos la página que vamos a mostrar, por página,por defecto la 1
         $pagina = (isset($_GET['pagina'])) ? (int)$_GET['pagina'] : 1;

         //Definimos la variable $inicio que indique la posición del registro desde el que se
         // mostrarán los registros de una página dentro de la paginación.
         $offset = ($pagina > 1) ? (($pagina - 1) * $regsxpag) : 0;

         //Calculamos el número de registros obtenidos
         $totalregistros = $this->modelo->totalReg();
         $totalregistros = $totalregistros['datos'];
         $totalregistros = $totalregistros["total"];
         $numpaginas = ceil($totalregistros / $regsxpag);

         $user = new UserModel();
         $resultModelo = $user->activarUsuario($id);
         $users = $user->listado($regsxpag, $offset);
         $users = $users["datos"];
         if (!$resultModelo["correcto"]) {
            $errores["activarUser"] = "Hubo un error a la hora de activar el usuario  :(";
         }
      } else { //Si no recibimos el valor del parámetro $id generamos el mensaje indicativo:
         $errores["errorId"] = "No se pudo acceder al id del usuario  :(";
      }
      $parametros = [
         "tituloventana" => "Admin. Usuarios",
         "datos" =>  $users,
         "numpaginas" => $numpaginas,
         "totalregistros" => $totalregistros,
         "pagina" => $pagina,
         "regsxpag" => $regsxpag,
         "errores" => $errores,
         "inicio" => false
      ];
      $this->view->show("AdminUser", $parametros);
   }

   /**
    * Función para desactivar usuarios de la base de datos.
    */
   public function desactivarUsuarioTabla()
   {
      $errores = array();
      if (isset($_GET['id']) && (is_numeric($_GET['id']))) {
         $id = $_GET["id"];

         $user = new UserModel();

         $regsxpag = (isset($_GET['regsxpag'])) ? (int)$_GET['regsxpag'] : 10; //para poner diez elementos por defecto
         $pagina = (isset($_GET['pagina'])) ? (int)$_GET['pagina'] : 1; //para que la primera página mostrada muestre el primer elemento


         $offset = ($pagina > 1) ? (($pagina - 1) * $regsxpag) : 0;  //offset se usa para indicar la posición desde donde se muestran los registros


         $totalregistros = $user->totalReg(); //para calcular el número total de registros
         $totalregistros = $totalregistros['datos'];
         $totalregistros = $totalregistros["total"];

         $numpaginas = ceil($totalregistros / $regsxpag); //Para ver el número de páginas de la paginación

         $resultModelo = $user->desactivarUsuario($id);
         $users = $user->listado($regsxpag, $offset);
         $users = $users["datos"];

         if (!$resultModelo["correcto"]) {
            $errores["desacUser"] = "hubo un error a la hora de desactivar el usuario : (";
         }
      } else { //Si no recibimos el valor del parámetro $id generamos el mensaje indicativo:
         $errores["errorId"] = "No se pudo acceder al id del usuario  :(";
      }
      $parametros = [
         "tituloventana" => "Admin. Usuarios",
         "datos" =>  $users,
         "numpaginas" => $numpaginas,
         "totalregistros" => $totalregistros,
         "pagina" => $pagina,
         "regsxpag" => $regsxpag,
         "errores" => $errores,
         "inicio" => false
      ];
      $this->view->show("AdminUser", $parametros);
   }

   /**
    * Función para eliminar usuarios de la base de datos
    */
   public function deluser()
   {

      $errores = array();
      // verificamos que hemos recibido los parámetros desde la vista de listado 
      if (isset($_GET['id']) && (is_numeric($_GET['id']))) {

         $id = $_GET["id"];

         if ($_SESSION['id'] == $id) {
            echo '<script language="javascript">';
            echo 'alert("No puedes eliminarte a ti mismo! >:(")';
            echo '</script>';
         } else { //Eliminamos al usuario con el id indicado

            $resultModelo = $this->modelo->deluser($id);

            if (!$resultModelo["correcto"]) {
               $errores["errorEliminar"] = "No se pudo eliminar al usuario correctamente :(";
            } else {
               echo '<script language="javascript">';
               echo 'alert("Este usuario ha sido eliminado")';
               echo '</script>';
            }
         }
      } else { //Ha habido un error con el id del usuario
         $errores["errorId"] = "No se pudo acceder al id del usuario  :(";
      }
      $this->administrarUsuarios();
   }


   /**
    * Función para pasar los datos del usuario seleccionado en la tabla a los cuadros de texto de abajo
    */
   public function modificarUsuarioSeleccionado()
   {
      $errores = array();
      $id = $_GET['id'];
      $usuario = new UserModel();
      $usuario = $usuario->verUsuario($id);

      if ($_SESSION["verificado"]) {

         $user = new UserModel();

         $regsxpag = (isset($_GET['regsxpag'])) ? (int)$_GET['regsxpag'] : 10;  //para poner diez elementos por defecto        
         $pagina = (isset($_GET['pagina'])) ? (int)$_GET['pagina'] : 1; //para que la primera página mostrada muestre el primer elemento

         $offset = ($pagina > 1) ? (($pagina - 1) * $regsxpag) : 0; //offset se usa para indicar la posición desde donde se muestran los registros

         $totalregistros = $user->totalReg(); //para calcular el número total de registros
         $totalregistros = $totalregistros['datos'];
         $totalregistros = $totalregistros["total"];


         $numpaginas = ceil($totalregistros / $regsxpag); //Para ver el número de páginas de la paginación
         $resultModelo = $user->paginarUsuarios($regsxpag, $offset);

         if ($resultModelo["correcto"]) {
            $parametros["datos"] = $resultModelo["datos"];
         } else { //Ha ocurrido un error, creamos el mensaje            
            $errores["cargaListado"] = "Hubo un error a la hora de hacer el listado  :(";
         }

         if ($_SESSION['id'] == $id) {
            echo '<script language="javascript">';
            echo 'alert("Si quieres modificar tus datos, ve a tu perfil en la esquina superior derecha.")';
            echo '</script>';
            $usuario["datos"] = null;
         }

         $parametros = [
            "tituloventana" => "Admin. Usuarios",
            "datos" =>  $resultModelo["datos"],
            "usuario" => $usuario["datos"],
            "numpaginas" => $numpaginas,
            "totalregistros" => $totalregistros,
            "pagina" => $pagina,
            "regsxpag" => $regsxpag,
            "errores" => $errores
         ];

         $this->view->show("AdminUser", $parametros);
      } else {
         $this->redirect("Index", "index");
      }
   }


   /**
    * Función para añadir usuarios a la base de datos.
    */
   public function adduser()
   {

      $errores = array();
      $anadido = false;

      if (isset($_POST) && !empty($_POST)) { // y hemos recibido las variables del formulario y éstas no están vacías...


         $nombre = filter_var($_POST['nombre'], FILTER_SANITIZE_STRING);
         $apellidos = filter_var($_POST['apellidos'], FILTER_SANITIZE_STRING);
         $nif = filter_var($_POST['nif'], FILTER_SANITIZE_STRING);
         $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
         $telefono = filter_var($_POST['telefono'], FILTER_SANITIZE_STRING);
         $direccion = filter_var($_POST['direccion'], FILTER_SANITIZE_STRING);
         $usuario = filter_var($_POST['login'], FILTER_SANITIZE_STRING);
         $password = $_POST['password'];


         $comprobarUsuario = new UserModel();
         $comprobarUsuario = $comprobarUsuario->comprobarRegistroUsuario($usuario, $email);
         $comprobarUsuario = $comprobarUsuario["correcto"];


         if (!$comprobarUsuario) {


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
                  //Para asegurarnos que el nombre va a ser único...
                  $nombrefichimg = time() . "-" . $_FILES["imagen"]["name"];
                  // Movemos el fichero de la carpeta temportal a la nuestra
                  $movfichimg = move_uploaded_file($_FILES["imagen"]["tmp_name"], "assets/img/avatarUsers/" . $nombrefichimg);
                  $imagen = $nombrefichimg;
                  // Verficamos que la carga se ha realizado correctamente
                  if (!$movfichimg) {
                     $errores["imagen"] = "La imagen no se cargó correctamente";
                  }
               }
            }
            // Si no se han producido errores realizamos el registro del usuario
            if (count($errores) == 0) {
               $password = md5($password);
               $this->modelo->adduser([
                  'nombre' => $nombre,
                  'usuario' => $usuario,
                  "password" => $password,
                  'email' => $email,
                  'imagen' => $imagen,
                  "nif" =>  $nif,
                  "telefono" => $telefono,
                  "direccion" => $direccion,
                  "apellidos" => $apellidos,
                  "inicio" => false
               ]);
               $anadido = true;
            }
         } else { //usuario ya registrado
            $errores["yaRegistrado"] = "Error, usuario o correo ya registrados";
         }
      }



      $regsxpag = (isset($_GET['regsxpag'])) ? (int)$_GET['regsxpag'] : 10;    //para poner diez elementos por defecto   
      $pagina = (isset($_GET['pagina'])) ? (int)$_GET['pagina'] : 1;  //para que la primera página mostrada muestre el primer elemento


      $offset = ($pagina > 1) ? (($pagina - 1) * $regsxpag) : 0;  //offset se usa para indicar la posición desde donde se muestran los registros


      $totalregistros = $this->modelo->totalReg(); //para calcular el número total de registros
      $totalregistros = $totalregistros['datos'];
      $totalregistros = $totalregistros["total"];



      $numpaginas = ceil($totalregistros / $regsxpag); //Para ver el número de páginas de la paginación
      $resultModelo = $this->modelo->listado($regsxpag, $offset);

      if ($anadido) {
         $parametros = [
            "tituloventana" => "Admin. Usuarios",
            "datos" => $resultModelo["datos"],
            "numpaginas" => $numpaginas,
            "totalregistros" => $totalregistros,
            "pagina" => $pagina,
            "regsxpag" => $regsxpag,
            "errores" => $errores,
            "inicio" => false
         ];
      } else {

         $parametros = [
            "tituloventana" => "Admin. Usuarios",
            "nombre" => isset($nombre) ? $nombre : "",
            "login" => isset($usuario) ? $usuario : "",
            "password" => isset($password) ? $password : "",
            "apellidos" => isset($email) ? $email : "",
            "imagen" => isset($imagen) ? $imagen : "",
            "nif" => isset($nif) ? $nif : "",
            "telefono" => isset($telefono) ? $telefono : "",
            "direccion" => isset($direccion) ? $direccion : "",
            "apellidos" => isset($apellidos) ? $apellidos : "",
            "datos" => $resultModelo["datos"],
            "numpaginas" => $numpaginas,
            "totalregistros" => $totalregistros,
            "pagina" => $pagina,
            "regsxpag" => $regsxpag,
            "errores" => $errores,
            "inicio" => false
         ];
      }
      $this->view->show("AdminUser", $parametros);
   }

   /**
    * Función para actualizar los usuarios de la base de datos
    */

   public function actuser()
   {
      $errores = array();

      $regsxpag = (isset($_GET['regsxpag'])) ? (int)$_GET['regsxpag'] : 10;   //para poner diez elementos por defecto   
      $pagina = (isset($_GET['pagina'])) ? (int)$_GET['pagina'] : 1; //para que la primera página mostrada muestre el primer elemento


      $offset = ($pagina > 1) ? (($pagina - 1) * $regsxpag) : 0; //offset se usa para indicar la posición desde donde se muestran los registros



      $totalregistros = $this->modelo->totalReg(); //para calcular el número total de registros
      $totalregistros = $totalregistros['datos'];
      $totalregistros = $totalregistros["total"];


      $numpaginas = ceil($totalregistros / $regsxpag); //Para ver el número de páginas de la paginación
      $resultModelo = $this->modelo->paginarUsuarios($regsxpag, $offset);



      if (isset($_POST) && !empty($_POST)) {

         $id = $_GET['id'];
         $nombre = filter_var($_POST['nombre'], FILTER_SANITIZE_STRING);
         $apellidos = filter_var($_POST['apellidos'], FILTER_SANITIZE_STRING);
         $nif = filter_var($_POST['nif'], FILTER_SANITIZE_STRING);
         $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
         $telefono = filter_var($_POST['telefono'], FILTER_SANITIZE_STRING);
         $direccion = filter_var($_POST['direccion'], FILTER_SANITIZE_STRING);
         $usuario = filter_var($_POST['login'], FILTER_SANITIZE_STRING);

         $user = ($this->modelo->verUsuario($id))["datos"];

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


         $nuevaimagen = "";


         if (isset($_FILES["imagen"]) && (!empty($_FILES["imagen"]["tmp_name"]))) { //si "tmp_name" no está vacio, se ha recibido la imagen 

            if (!is_dir("assets/img/avatarUsers")) {  // Si la carpeta con los avatares no existe, la creamos
               $dir = mkdir("assets/img/avatarUsers", 0777, true);
            } else {
               $dir = true;
            }

            if ($dir) {
               $nombrefichimg = time() . "-" . $_FILES["imagen"]["name"]; //Para que el nombre sea único               
               $movfichimg = move_uploaded_file($_FILES["imagen"]["tmp_name"], "assets/img/avatarUsers/" . $nombrefichimg);
               $nuevaimagen = $nombrefichimg;

               if (!$movfichimg) {
                  $errores["imagen"] = "La imagen no se cargó correctamente";
               }
            }
         }

         if (count($errores) == 0) {

            $password = $user["password"];

            if (isset($_POST["password"]) && !empty($_POST["password"])) { //si se ha metido una nueva pass, la actualizamos
               $password = $_POST["password"];
               $password = md5($password);
            }

            if (isset($_FILES["imagen"]) && !empty($_FILES["imagen"]["tmp_name"])) { //si se ha subido una imagen, la actualizamos
               $resultModelo = $this->modelo->actuserConImagen([
                  'id' => $id,
                  'nombre' => $nombre,
                  'email' => $email,
                  'imagen' => $nuevaimagen,
                  'direccion' => $direccion,
                  'telefono' => $telefono,
                  'login' => $usuario,
                  'apellidos' => $apellidos,
                  'nif' => $nif,
                  'password' => $password
               ]);
            } else {
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


            if (!$resultModelo["correcto"]) {
               $errores["actualizarMal"] = "No se pudo actualizar el usuario";
            }
         } else { //hay errores
            $errores["actualizarMal"] = "No se pudo actualizar el usuario";
         }
      }

      $resultModelo = $this->modelo->listado($regsxpag, $offset);

      $parametros = [
         "tituloventana" => "Admin. Usuarios",
         "datos" => $resultModelo["datos"],
         "errores" => $errores,
         "numpaginas" => $numpaginas,
         "totalregistros" => $totalregistros,
         "pagina" => $pagina,
         "regsxpag" => $regsxpag,
         "inicio" => false

      ];
      $this->view->show("AdminUser", $parametros);
   }

   /**
    * Función para mostrar cargar la administración de actividades
    */
   public function modificarActividad()
   {
      if ($_SESSION["verificado"]) {

         $actividad = new ActivityModel();

         $regsxpag = (isset($_GET['regsxpag'])) ? (int)$_GET['regsxpag'] : 10;  //para poner diez elementos por defecto        
         $pagina = (isset($_GET['pagina'])) ? (int)$_GET['pagina'] : 1; //para que la primera página mostrada muestre el primer elemento

         $offset = ($pagina > 1) ? (($pagina - 1) * $regsxpag) : 0; //offset se usa para indicar la posición desde donde se muestran los registros

         $totalregistros = $actividad->totalReg(); //para calcular el número total de registros
         $totalregistros = $totalregistros['datos'];
         $totalregistros = $totalregistros["total"];


         $numpaginas = ceil($totalregistros / $regsxpag); //Para ver el número de páginas de la paginación
         $resultModelo = $actividad->listado($regsxpag, $offset);


         $parametros = [
            "tituloventana" => "Admin. Actividades",
            "datos" => $resultModelo["datos"],
            "edact" => isset($act) ? $act : null,
            "numpaginas" => $numpaginas,
            "totalregistros" => $totalregistros,
            "pagina" => $pagina,
            "regsxpag" => $regsxpag,
            "inicio" => true

         ];
         $this->view->show("AdminActivity", $parametros);
      } else {
         $this->redirect("Index", "index");
      }
   }

   /**
    * Función para actualizar las actividades en la base de datos
    */
   public function actualizarActividad()
   {
      $inicio = true;  //variable que nos ayuda a mostrar mensajes de error o de notificación positiva  
      $actualizado = false; //variable para comprobar si se ha actualizado o no la actividad
      $errores = array();
      $actividad = new ActivityModel();

      $regsxpag = (isset($_GET['regsxpag'])) ? (int)$_GET['regsxpag'] : 10; //para poner diez elementos por defecto
      $pagina = (isset($_GET['pagina'])) ? (int)$_GET['pagina'] : 1; //para que la primera página mostrada muestre el primer elemento

      $offset = ($pagina > 1) ? (($pagina - 1) * $regsxpag) : 0; //offset se usa para indicar la posición desde donde se muestran los registros


      $totalregistros = $actividad->totalReg(); //para calcular el número total de registros
      $totalregistros = $totalregistros['datos'];
      $totalregistros = $totalregistros["total"];

      $numpaginas = ceil($totalregistros / $regsxpag); //Para ver el número de páginas de la paginación



      if (isset($_POST) && !empty($_POST)) { //Si han metido datos

         $id = $_GET['id'];
         $nombre = filter_var($_POST['nombre'], FILTER_SANITIZE_STRING);
         $descripcion = filter_var($_POST['descripcion'], FILTER_SANITIZE_STRING);
         $aforo = (int)$_POST['aforo'];


         if ($aforo <= 0) {
            $errores["aforoIncorrecto"] = "Introduzca un aforo válido";
         }

         if (count($errores) == 0) {

            $resultModel = $actividad->actact([
               'id' => $id,
               'nombre' => $nombre,
               'descripcion' => $descripcion,
               'aforo' => $aforo,
            ]);

            if (!$resultModel["correcto"]) {
               $errores["incorrecto"] = "No se pudo actualizar la actividad : (";
            } else {
               $inicio = false;
               $actualizado = true;
            }
         } else {
            $errores["incorrecto"] = "No se pudo actualizar la actividad : (";
         }
      } else {

         if (isset($_GET['id']) && (is_numeric($_GET['id']))) {
            $id = $_GET['id'];
            
            $resultModelo = $actividad->verActividad($id);

            $act = $resultModelo["datos"];
            $nombre = $act["nombre"];
            $descripcion = $act["descripcion"];
            $aforo = $act["aforo"];

            if (!$resultModelo["correcto"]) {
               $errores["listarDatos"] = "Hubo un error al obtener los datos :(";
            }
         }
      }

      $resultModelo1 = $actividad->listado($regsxpag, $offset);

      if ($actualizado) {
         $parametros = [
            "tituloventana" => "Admin. Actividades",
            "datos" => $resultModelo1["datos"],
            "edact" => isset($act) ? $act : null,
            "nombre" => "",
            "descripcion" => "",
            "aforo" => "",
            "id" => $id,
            "numpaginas" => $numpaginas,
            "totalregistros" => $totalregistros,
            "pagina" => $pagina,
            "regsxpag" => $regsxpag,
            "errores" => $errores,
            "inicio" => $inicio
         ];
      } else {
         $parametros = [
            "tituloventana" => "Admin. Actividades",
            "datos" => $resultModelo1["datos"],
            "edact" => isset($act) ? $act : null,
            "nombre" => isset($nombre)  ? $nombre : "",
            "descripcion" => isset($descripcion)  ? $descripcion : "",
            "aforo" => isset($aforo)  ? $aforo : "",
            "id" => $id,
            "numpaginas" => $numpaginas,
            "totalregistros" => $totalregistros,
            "pagina" => $pagina,
            "regsxpag" => $regsxpag,
            "errores" => $errores,
            "inicio" => $inicio
         ];
      }
      $this->view->show("AdminActivity", $parametros);
   }

   /**
    * Función para eliminar actividades.
    */
   public function delact()
   {

      $errores = array();

      if (isset($_GET['id']) && (is_numeric($_GET['id']))) {

         $id = $_GET["id"];

         $actividad = new ActivityModel();
         //Realizamos la operación de suprimir el usuario con el id=$id

         $resultModelo = $actividad->delact($id);

         if (!$resultModelo["correcto"]) {
            $errores["errorEliminar"] = "No se pudo eliminar la actividad :(";
         } else{
            echo '<script language="javascript">';
            echo 'alert("Esta actividad ha sido eliminada")';
            echo '</script>';
         }
      } else { //Si no recibimos el valor del parámetro $id generamos el mensaje indicativo:
         $errores["errorId"] = "No se pudo acceder al id de la actividad :(";
      }
      //Realizamos el listado de los usuarios
      $this->modificarActividad();
   }

   /**
    * Función para añadir nuevas actividades a la base de datos
    */
   public function addact()
   {
      $errores = array();
      $inicio = true;
      $actividad = new ActivityModel();

      $regsxpag = (isset($_GET['regsxpag'])) ? (int)$_GET['regsxpag'] : 10;  //para poner diez elementos por defecto  
      $pagina = (isset($_GET['pagina'])) ? (int)$_GET['pagina'] : 1; //para que la primera página mostrada muestre el primer elemento

      $offset = ($pagina > 1) ? (($pagina - 1) * $regsxpag) : 0; //offset se usa para indicar la posición desde donde se muestran los registros

      $totalregistros = $actividad->totalReg(); //para calcular el número total de registros
      $totalregistros = $totalregistros['datos'];
      $totalregistros = $totalregistros["total"];

      $numpaginas = ceil($totalregistros / $regsxpag); //Para ver el número de páginas de la paginación


      if (isset($_POST) && !empty($_POST)) {

         $nombre = filter_var($_POST['nombre'], FILTER_SANITIZE_STRING);
         $descripcion = filter_var($_POST['descripcion'], FILTER_SANITIZE_STRING);
         $aforo = (int)$_POST['aforo'];


         if ($aforo <= 0) {
            $errores["aforoIncorrecto"] = "Introduzca un aforo válido";
         }


         if (count($errores) == 0) {
            $resultModelo = $actividad->addact(["nombre" => $nombre, "descripcion" => $descripcion, "aforo" => $aforo]);

            if (!$resultModelo["correcto"]) {
               $errores["incorrecto"] = "No se pudo añadir la actividad :(";
            } else {
               $inicio = false;
            }
         }
      }

      $resultModelo1 = $actividad->listado($regsxpag, $offset);

      $parametros = [
         "tituloventana" => "Admin. Actividades",
         "datos" => $resultModelo1["datos"],
         "edact" => isset($act) ? $act : null,
         "nombre" => isset($nombre) ? $nombre : "",
         "descripcion" => isset($descripcion) ? $descripcion : "",
         "aforo" => isset($aforo) ? $aforo : "",
         "numpaginas" => $numpaginas,
         "totalregistros" => $totalregistros,
         "pagina" => $pagina,
         "regsxpag" => $regsxpag,
         "errores" => $errores,
         "inicio" => $inicio

      ];

      //Mostramos la vista actuser
      $this->view->show("AdminActivity", $parametros);
   }
}
