<?php

/**
 * Clase para gestionar las relaciones con la tabla de actividades
 */
class ActivityModel extends BaseModel
{


   public function __construct()
   {
      parent::__construct();
      $this->table = "actividades"; 
   }

   /**
    * Función que nos devuelve un listado de las actividades.
    * @param int $regsxpag el número de registros por página
    * @param int $offset la posición desde donde se muestran los registros

    * @return array $return  array con distintos datos: "correcto" es true si la operación se llevó a cabo con éxito.
    * "datos" son los datos en cuestión que hemos consultado. "error" son los mensajes de excepciones.
    */
   public function listado($regsxpag, $offset)
   {
      $return = [
         "correcto" => FALSE,
         "datos" => NULL,
         "error" => NULL
      ];

      try {
         $sql = 'SELECT * FROM actividades ORDER BY 1 LIMIT ? OFFSET ?';
         $resultsquery = $this->db->prepare($sql);
         $resultsquery->bindParam(1, $regsxpag, PDO::PARAM_INT);
         $resultsquery->bindParam(2, $offset, PDO::PARAM_INT);
         $resultsquery->execute();

         if ($resultsquery) { //la consulta fue correcta
            $return["correcto"] = TRUE;
            $return["datos"] = $resultsquery->fetchAll(PDO::FETCH_ASSOC);
         }
      } catch (PDOException $ex) {
         $return["error"] = $ex->getMessage();
      }
      return $return;
   }

   /**
    * Función que añade una actividad a la base de datos.
    * @param array $datos array con cada uno de los atributos necesarios para crear una nueva actividad

    * @return array $return  array con distintos datos: "correcto" es true si la operación se llevó a cabo con éxito.
    * "error" son los mensajes de excepciones.
    */
   public function addact($datos)
   {
      $return = [
         "correcto" => FALSE,
         "error" => NULL
      ];

      try {
         //creamos una transacción
         $this->db->beginTransaction();

         $sql = "insert into actividades values(null,:nombre,:descripcion,:aforo)";
         $query = $this->db->prepare($sql);
         $query->execute([
            'nombre' => $datos["nombre"],
            'descripcion' => $datos["descripcion"],
            'aforo' => $datos["aforo"],

         ]);
         if ($query) { //Si es true, la inserción es correcta
            $this->db->commit(); //  con commit confirmamos los cambios
            $return["correcto"] = TRUE;
         }
      } catch (PDOException $ex) {
         $this->db->rollback(); // con rollback revertimos los cambios
         $return["error"] = $ex->getMessage();
         //die();
      }

      return $return;
   }

   /**
    * Función que actualiza una actividad de la base de datos.
    * @param array $datos array con los nuevos atributos necesarios para modificar una actividad

    * @return array $return  array con distintos datos: "correcto" es true si la operación se llevó a cabo con éxito.
    * "error" son los mensajes de excepciones.
    */
   public function actact($datos)
   {
      $return = [
         "correcto" => FALSE,
         "error" => NULL
      ];

      try {

         //Creamos una transacción
         $this->db->beginTransaction();

         $sql = "UPDATE actividades SET nombre= :nombre, descripcion= :descripcion, aforo= :aforo WHERE id=:id";
         $query = $this->db->prepare($sql);
         $query->execute([
            'id' => $datos["id"],
            'nombre' => $datos["nombre"],
            'descripcion' => $datos["descripcion"],
            'aforo' => $datos["aforo"]
         ]);

         if ($query) { //si es true, se hizo el update
            $this->db->commit();  // con commit confirmamos los cambios
            $return["correcto"] = TRUE;
         }
      } catch (PDOException $ex) {
         $this->db->rollback(); // con rollback  revertimos los cambios 
         $return["error"] = $ex->getMessage();
      }
      return $return;
   }

   /**
    * Función para eliminar una actividad 
    * @param int $id la clave de la actividad a eliminar
    * @return boolean true si se eliminó correctamente y false en caso contrario
    */
   public function delact($id)
   {
      $return = [
         "correcto" => FALSE,
         "error" => NULL
      ];

      if ($id && is_numeric($id)) {
         try {

            $tramo = new TramosModel();
            //creamos una transacción
            $this->db->beginTransaction();
            $tramo->delTramosAsociados($id);
            $sql = "DELETE FROM actividades WHERE id=:id";
            $query = $this->db->prepare($sql);
            $query->execute(['id' => $id]);

            if ($query) { //la instrucción ha sido correcta
               $this->db->commit();  // con commit confirmamos los cambios
               $return["correcto"] = TRUE;
            }
         } catch (PDOException $ex) {
            $this->db->rollback(); // con rollback revertimos los cambios
            $return["error"] = $ex->getMessage();
         }
      } else {
         $return["correcto"] = FALSE;
      }
      return $return;
   }

   /**
    * Función que nos devuelve el número total de registros
    * @return array $return  array con distintos datos: "correcto" es true si la operación se llevó a cabo con éxito.
    * "datos" son los datos en cuestión que hemos consultado. "error" son los mensajes de excepciones.
    */
   public function totalReg()
   {
      $return = [
         "correcto" => FALSE,
         "datos" => NULL,
         "error" => NULL
      ];

      try {
         $sql = 'SELECT count(*) as total FROM actividades';
         $resultsquery = $this->db->query($sql);

         if ($resultsquery) { //se llevó a cabo correctamente
            $return["correcto"] = TRUE;
            $return["datos"] = $resultsquery->fetch();
         }
      } catch (PDOException $ex) {
         $return["error"] = $ex->getMessage();
      }
      return $return;
   }

   
   /**
    * Función que nos muestra los datos de una actividad en concreto
    * @param int $id el id de la actividad
    * @return array $return  array con distintos datos: "correcto" es true si la operación se llevó a cabo con éxito.
    * "datos" son los datos en cuestión que hemos consultado. "error" son los mensajes de excepciones.
    */
   public function verActividad($id)
   {
      $return = [
         "correcto" => FALSE,
         "datos" => NULL,
         "error" => NULL
      ];

      if ($id && is_numeric($id)) {
         try {
            $sql = "SELECT * FROM actividades WHERE id=:id";
            $query = $this->db->prepare($sql);
            $query->execute(['id' => $id]);
            if ($query) { //es correcto
               $return["correcto"] = TRUE;
               $return["datos"] = $query->fetch(PDO::FETCH_ASSOC);
            } 
         } catch (PDOException $ex) {
            $return["error"] = $ex->getMessage();
         }
      }
      return $return;
   }
}
