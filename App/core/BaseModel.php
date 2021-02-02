<?php
/**
 * Módelo base para las clases  model
 */
abstract class BaseModel
{

   protected $table; //Tabla con los datos del modelo
   protected $db; //la base de datos


   public function __construct()
   {
      $this->db = DBManager::getInstance()->getConnection(); //al ejecutar el constructor nos conectamos al a base de datos
   }

   /**
    * Para conseguir todos los datos de una tabla de la base de datos
    */
   public function getAll() {
      $resultSet = null;
      
      $query = $this->db->query("SELECT * FROM $this->table WHERE deleted_at is null ORDER BY id DESC");
        
      //Devolvemos el resultset en forma de array de objetos
      while ($row = $query->fetchObject()) {
         $resultSet[] = $row;
      }
       
      return $resultSet;
  }

   /**
   * Para conseguir elementos de una tabla de la base de datos en base a parametros  introducidos
   * @param string $column la columna donde queremos buscar
   * @param string $value el valor de la columna del elemento que queremos 
  */ 
  public function getBy($column, $value) {
      $resultSet = null;

      $query = $this->db->query("SELECT * FROM $this->table WHERE $column = '$value'");

      while($row = $query->fetchObject()) {
         $resultSet[] = $row;
      }       
      return $resultSet;
  }
}