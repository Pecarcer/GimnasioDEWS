<?php
/**
 * Clase que hace de base para todas las vistas
 */
class View
{
   /**
    * Muestra una vista, con posibilidad de añadir parámetros
    *
    * @param string $name el nombre de la vista
    * @param array $vars conjunto de parámetros
    * @return void
    */
   public function show($name, $vars = array())
   {
      //Creamos la ruta real a la plantilla
      $path = VIEWS_FOLDER . ucwords($name). 'View.php';

      //Si no existe el fichero en cuestion, lanzamos una excepción
      if (!file_exists($path))
         throw new \Exception('La plantilla ' . $path . ' no existe');

      //Si hay variables extra, hacemos un bucle para pasarlas todas
      if (is_array($vars)) {
         foreach ($vars as $key => $value) {
            $$key = $value;   // Es una variable variable, el valor de la variable hace de nombre de otra variable
         }
      }
      require_once($path);
   }
}
