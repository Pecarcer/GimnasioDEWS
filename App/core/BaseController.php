<?php
/**
 * Clase que usaremos como base para todos los controladores
 */
abstract class BaseController
{
   protected $view;

   function __construct()
   {
      $this->view = new View();
   }

   /**
    * Redirige al usuario a donde le indiquemos
    *
    * @param string $controlador el controlador que se usará
    * @param string $accion la acción que se ejecutará dentro del controlador
    * @param array $params  datos adicionales para usar en el controlador
    */
   public function redirect($controlador = DEFAULT_CONTROLLER, $accion = DEFAULT_ACTION, $params = null)
   {
      if ($params != null) {
         $urlpar="";
         foreach ($params as $key => $valor) {
            $urlpar .= "&$key=$valor";
         }
         header("Location: ?controller=" . $controlador . "&action=" . $accion . $urlpar);
      } else {
         header("Location: ?controller=" . $controlador . "&action=" . $accion);
      }
   }
}
