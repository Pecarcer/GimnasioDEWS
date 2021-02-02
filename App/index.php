<?php
/**
 * Con esta función hacemos un require de los elementos de la carpeta core conforme se vayan necesitando.
 */

spl_autoload_register(function ($nombre) {
   require 'core/' . $nombre . '.php';
});

try {

   session_start();
   FrontController::main();
} catch (\Exception $e) {
   echo $e->getMessage();
}
