<?php

/**
 *  Esta clase nos sirve para acceder a la tabla tramos 
 */
class TramosModel extends BaseModel
{


   public function __construct()
   {
      parent::__construct();
      $this->table = "tramos";
   }

   /**
    * Función que nos devuelve un listado con los datos necesarios para confeccionar el horario de actividades.
    * @return array $return  array con distintos datos: "correcto" es true si la operación se llevó a cabo con éxito.
    * "datos" son los datos en cuestión que hemos consultado. "error" son los mensajes de excepciones.
    */
   public function listadoHorario()
   {
      $return = [
         "correcto" => FALSE,
         "datos" => NULL,
         "error" => NULL
      ];

      try {
         $sql = 'SELECT t.id,  date_format(t.hora_inicio, "%H:%i") hora_inicio,date_format(t.hora_fin, "%H:%i") hora_fin , a.nombre, t.dia dia 
                     FROM tramos t inner join actividades a on (t.actividad_id = a.id) ORDER BY 1';

         $resultsquery = $this->db->query($sql);

         if ($resultsquery) { //se hizo correctamente
            $return["correcto"] = TRUE;
            $return["datos"] = $resultsquery->fetchAll(PDO::FETCH_ASSOC);
         }
      } catch (PDOException $ex) {
         $return["error"] = $ex->getMessage();
      }
      return $return;
   }

   /**
    * Función que nos devuelve un listado con las horas y días en las que hay alguna actividad programada
    * @return array $return array con distintos datos: "correcto" es true si la operación se llevó a cabo con éxito.
    * "datos" son los datos en cuestión que hemos consultado. "error" son los mensajes de excepciones.
    */
   public function listadoHoras()
   {
      $return = [
         "correcto" => FALSE,
         "datos" => NULL,
         "error" => NULL
      ];

      try {
         $sql = 'SELECT  date_format(t.hora_inicio, "%H:%i") hora_inicio,date_format(t.hora_fin, "%H:%i") hora_fin 
          FROM tramos t group by hora_inicio,hora_fin ORDER BY 1';

         $resultsquery = $this->db->query($sql);


         if ($resultsquery) { //se hizo correctamente
            $return["correcto"] = TRUE;
            $return["datos"] = $resultsquery->fetchAll(PDO::FETCH_ASSOC);
         }
      } catch (PDOException $ex) {
         $return["error"] = $ex->getMessage();
      }
      return $return;
   }

   /**
    * Función que elimina los tramos asociados a la actividad pasada por parametro
    * @param int $id el id de la actividad cuyos tramos asociados queremos borrar   
    * @return array $return array con distintos datos: "correcto" es true si la operación se llevó a cabo con éxito.
    * "datos" son los datos en cuestión que hemos consultado. "error" son los mensajes de excepciones.
    */
   public function delTramosAsociados($id)
   {

      $return = [
         "correcto" => FALSE,
         "datos" => NULL,
         "error" => NULL
      ];

      try {
         $sql = 'delete from tramos where actividad_id = :id';
         $resultsquery = $this->db->prepare($sql);
         $resultsquery->execute(["id" => $id]);

         if ($resultsquery) { //se hizo correctamente
            $return["correcto"] = TRUE;
         }
      } catch (PDOException $ex) {
         $return["error"] = $ex->getMessage();
      }
      return $return;
   }
}
