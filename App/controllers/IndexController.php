<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

$_SESSION["verificado"] = false;
$_SESSION["usuario"] = "";
$_SESSION["password"] = "";
$_SESSION["rol"] = "";
$_SESSION["id"] = "";
$_SESSION["email"] = "";

require_once MODELS_FOLDER . 'UserModel.php';

/**
 * Controlador inicial para todas las acciones que no impliquen estar validado.
 */

class IndexController extends BaseController
{

   public function __construct()
   {
      parent::__construct();
   }

   /** Función inicial para dirigir al usuario en base a si se ha logeado correctamente o no */
   public function index()
   {
      if (isset($_SESSION["verificado"]) && $_SESSION["verificado"] == true) {
         $parametros = [
            "tituloventana" => "Inicio"
         ];

         $this->redirect("Home", "index", $parametros);
      }
      $parametros = [
         "tituloventana" => "Login"
      ];

      $this->view->show("Login", $parametros);
   }

   /**
    * Función para realizar el logeo de los usuarios
    */
   public function login()
   {

     
      if (isset($_POST) && !empty($_POST)) { //Para que no nos de error si refrescamos justo después de que nos de error de login

         $userlog = filter_var($_POST["usuario"], FILTER_SANITIZE_STRING); //filtramos la cadena
         $passlog = md5($_POST["password"], false); //utilizamos el md5 para cifrar la pass

         $usuario = new UserModel();

         $login = $usuario->comprobarLogin($userlog, $passlog);

         $user = $login["datos"]; // el usuario introducido

         $secret = "6Ld7NhwaAAAAAFVTjcejbr5zss9RmRQ-0Mr9VxG4"; //Código para el captcha. Tutorial de https://www.esthersola.com/ejemplo-implementar-google-captcha-php/
         $activado = $user[0]["activado"];

         if (isset($_POST['g-recaptcha-response'])) {
            $captcha = $_POST['g-recaptcha-response'];
            $url = 'https://www.google.com/recaptcha/api/siteverify';
            $data = array(
               'secret' => $secret,
               'response' => $captcha,
               'remoteip' => $_SERVER['REMOTE_ADDR']
            );

            $curlConfig = array(
               CURLOPT_URL => $url,
               CURLOPT_POST => true,
               CURLOPT_RETURNTRANSFER => true,
               CURLOPT_POSTFIELDS => $data
            );

            $ch = curl_init();
            curl_setopt_array($ch, $curlConfig);
            $response = curl_exec($ch);
            curl_close($ch);
         }

         $jsonResponse = json_decode($response);
         if ($jsonResponse->success === true) { //se ha validado el captcha

            if ($login["correcto"]) { //Usuario y pass han sido correctas


               if ($activado == 1) { //El usuario está activado

                  $_SESSION["verificado"] = true; //Para ver si el usuario se ha validado correctamente
                  $_SESSION["usuario"] = $_POST["usuario"]; //el nick del user
                  $_SESSION["nombre"] = $user[0]["nombre"];
                  $_SESSION["apellidos"] = $user[0]["apellidos"];
                  $_SESSION["nif"] = $user[0]["nif"];
                  $_SESSION["telefono"] = $user[0]["telefono"];
                  $_SESSION["direccion"] = $user[0]["direccion"];
                  $_SESSION["rol"] = $user[0]["rol_id"]; //1 si es admin, 0 si es user
                  $_SESSION["id"] = $user[0]["id"];
                  $_SESSION["email"] = $user[0]["email"];
                  $_SESSION["horaInicio"] =  date("h:i a"); //la hora a la que se logeo el usuario
                  $_SESSION["img"] = $user[0]["imagen"];



                  if (isset($_POST['recuerdame']) && $_POST['recuerdame']=="on") {  // Creamos las cookies para ambas variables
                     setcookie('usuario', $_POST["usuario"], time() + (15 * 24 * 60 * 60));
                     setcookie('password', $_POST["password"], time() + (15 * 24 * 60 * 60));
                     setcookie('recuerdame', "on");
                  } else {
                     // Eliminamos las cookies                     
                     if (isset($_COOKIE["usuario"])) {
                        setcookie('usuario', "", time() - 3600);
                     }
                     if (isset($_COOKIE["password"])) {
                        setcookie('password', "", time() - 3600);
                     }
                     if (isset($_COOKIE["recuerdame"])) {
                        setcookie('recuerdame', "", time() - 3600);
                     }
                  }

                  $this->redirect("Home", "index"); //Lo llevamos al Home controller accion index

               } else { //La cuenta no está activada

                  $parametros = [
                     "tituloventana" => "Login",
                     "loginIncorrecto" => "Error, su cuenta no se encuentra activada, espere a que el administrador lo haga."
                  ];
                  $this->view->show("Login", $parametros);
               }
            } else { //users y pass no correctas
               $parametros = [
                  "tituloventana" => "Login",
                  "loginIncorrecto" => "Error, user y/o pass incorrectas."
               ];
               $this->view->show("Login", $parametros);
            }
         } else { //no se ha validado el captcha

            $parametros = [
               "tituloventana" => "Login",
               "loginIncorrecto" => "Debe verificar que no es un robot."
            ];
            $this->view->show("Login", $parametros);
         }
      }
      $this->view->show("Login");
   }


   /**
    * Función para enviar al usuario a la página de registro
    */
   public function register()
   {
      $parametros = [
         "tituloventana" => "Registro"
      ];
      $this->view->show("Register", $parametros);
   }

   /**
    * Función para enviar al usuario a la página de recuperación de contraseña
    */
   public function recuperarContrasena()
   {
      $parametros = [
         "tituloventana" => "Recuperar Contraseña"
      ];
      $this->view->show("RecoverPassword", $parametros);
   }

   /**
    * Función para que el usuario reciba un email con la nueva contraseña
    */
   public function enviarRecuperacionContrasena()
   {
      $errores = "";

      //Cargamos los ficheros necesarios
      require_once 'PHPMailer/src/Exception.php';
      require_once 'PHPMailer/src/PHPMailer.php';
      require_once 'PHPMailer/src/SMTP.php';
      require_once 'vendor/autoload.php';

      if (isset($_POST['submit'])) {

         $userModel = new UserModel();

         //Buscamos el email
         $encontrado = ($userModel->getByEmail($_POST["email"]))["correct"];

         if ($encontrado) { //email correcto
            try {

               $nuevaPass = uniqid(); //da una cadena aleatoria de 13 dígitos


               //Luego se cambia esta contraseña en la bd.
               $cambiarPass = $userModel->cambiarContrasena($_POST["email"], $nuevaPass); //luego la ciframos con md5 antes de meterla en la base de datos

               //Usamos el servicio : https://ethereal.email/

               //Ahora configuramos el $mail con los siguientes datos:

               $mail = new PHPMailer(true);
               $mail->isSMTP();
               $mail->Host = 'smtp.ethereal.email';
               $mail->SMTPAuth = true;
               $mail->Username = 'ivory.ryan38@ethereal.email';
               $mail->Password = 'EhB6uN3NDrVeeTcGKF';
               $mail->SMTPSecure = 'tls';
               $mail->Port = 587;

               //Recipients
               $mail->setFrom("ivory.ryan38@ethereal.email", 'ONASIO'); //Se deberá modificar por el email del cual se quiera enviar los correos.
               $mail->addAddress($_POST["email"]);

               // Content
               $mail->isHTML(false);
               $mail->Subject = 'GIMNASIO ONASIO: Pass Actualizado';
               $mail->Body    = 'Hola, has solicitado una nueva pass. Tu nueva pass es: ' . $nuevaPass . ' .Gracias por ser cliente en Gimnasio Onasio.';
               $mail->send();


               if (!$cambiarPass) {
                  $errores = "Ha ocurrido un error, inténtelo más tarde";
               }
            } catch (Exception $e) {
               $errores = "Ha ocurrido un error, inténtelo más tarde";
            }
         } else {
            //Si el user no es correcto, se manda un error.
            $errores = "El correo introducido es incorrecto o no está en nuestra base de datos";
         }
      }

      $parametros = [
         "tituloventana" => "Recuperar Contraseña",
         "errores" => $errores
      ];
      $this->view->show("RecoverPassword", $parametros);
   }
}
