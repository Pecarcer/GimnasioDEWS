<?php
/**
 * Front Controller es un patrón de diseño de software muy utilizado consiste en definir un único punto de acceso para todas las peticiones HTTP
 */
class FrontController
{
   static function main()
   {
      //Requerimos todos los archivos con configuraciones.      
      require_once "./config.php"; 
           

      // Ponemos el Controlador o sino, el controlador por defecto
      if (!empty($_GET['controller'])) {
         $controller = ucwords($_GET['controller']);
      } else {
         $controller = DEFAULT_CONTROLLER;
      }

      //Ponemos la acción o sino, la acción por defecto
      if (!empty($_GET['accion'])) {
         $action = $_GET['accion'];
      } else {
         $action = DEFAULT_ACTION;
      }

      $controller .= "Controller"; //Para el nombre del fichero
      $controller_path = CONTROLLERS_FOLDER . $controller . '.php';

      //Incluimos el fichero que contiene nuestra clase controladora solicitada
      if (!is_file($controller_path)) {
         throw new \Exception('El controlador no existe ' . $controller_path . ' - 404 not found');
      }
      require $controller_path;

      //Si la clase y el método no están creados, mostramos un error
      if (!is_callable(array($controller, $action))) {
         throw new \Exception($controller . '->' . $action . ' no existe');
      }
      
      $controller = new $controller(); //Si todo está correcto, lo llamamos
      $controller->$action();
   }
}
