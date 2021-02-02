<?php

/**
 *  Esta clase nos sirve para acceder a la tabla usuarios
 */
class UserModel extends BaseModel
{
   public function __construct()
   {
      parent::__construct();
      $this->table = "usuarios";
   }

   /**
    * Función que nos devuelve un listado de las usuarios.
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
         $sql = 'SELECT * FROM usuarios ORDER BY 1 LIMIT ? OFFSET ?';
         $resultsquery = $this->db->prepare($sql);
         $resultsquery->bindParam(1, $regsxpag, PDO::PARAM_INT);
         $resultsquery->bindParam(2, $offset, PDO::PARAM_INT);
         $resultsquery->execute();

         if ($resultsquery) {
            $return["correcto"] = TRUE;
            $return["datos"] = $resultsquery->fetchAll(PDO::FETCH_ASSOC);
         }
      } catch (PDOException $ex) {
         $return["error"] = $ex->getMessage();
      }

      return $return;
   }

   /**
    * Función para eliminar a un usuario  
    * @param int $id clave del usuario a eliminar
    * @return boolean true si se eliminó correctamente, false si no
    */
   public function deluser($id)
   {
      $return = [
         "correcto" => FALSE,
         "error" => NULL
      ];
      if ($id && is_numeric($id)) {
         try {
            //Creamos transacción
            $this->db->beginTransaction();
            $sql = "DELETE FROM usuarios WHERE id=:id";
            $query = $this->db->prepare($sql);
            $query->execute(['id' => $id]);

            if ($query) { //se hizo correctamente
               $this->db->commit();  // con commit confirmamos los cambios
               $return["correcto"] = TRUE;
            }
         } catch (PDOException $ex) {
            $this->db->rollback(); // con rollback() descartamos los cambios
            $return["error"] = $ex->getMessage();
         }
      } else {
         $return["correcto"] = FALSE;
      }
      return $return;
   }

   /**
    * Función para registrar a un usuario 
    * @param array $datos son los datos necesarios para añadir un nuevo usuario a la base de datos
    * @return array $return array con distintos datos: "correcto" es true si la operación se llevó a cabo con éxito.
    * "error" son los mensajes de excepciones.
    */
   public function adduser($datos)
   {
      $return = [
         "correcto" => FALSE,
         "error" => NULL
      ];

      try {
         //Creamos una transacción
         $this->db->beginTransaction();
         $sql = "insert into usuarios values(null,:nif,:nombre,:apellidos,
                  :imagen,:login,:password,:email,:telefono,:direccion,0,0)";

         $query = $this->db->prepare($sql);
         $query->execute([
            'nif' => $datos["nif"],
            'nombre' => $datos["nombre"],
            'apellidos' => $datos["apellidos"],
            'imagen' => $datos["imagen"],
            'login' => $datos["usuario"],
            'password' => $datos["password"],
            'email' => $datos["email"],
            'telefono' => $datos["telefono"],
            'direccion' => $datos["direccion"]

         ]);

         if ($query) { //si se hizo sin fallos
            $this->db->commit(); // con commit confirmamos los cambios 
            $return["correcto"] = TRUE;
         }
      } catch (PDOException $ex) {
         $this->db->rollback(); // con rollback descartamos los cambios 
         $return["error"] = $ex->getMessage();
      }

      return $return;
   }

   /**
    * Función para actualizar a un usuario sin cambiar su imagen
    * @param array $datos son los datos necesarios para actualizar un usuario en la base de datos (sin imagen)
    * @return array $return array con distintos datos: "correcto" es true si la operación se llevó a cabo con éxito.
    * "error" son los mensajes de excepciones.
    */
   public function actuserSinImagen($datos)
   {
      $return = [
         "correcto" => FALSE,
         "error" => NULL
      ];

      try {
         //creamos transacción
         $this->db->beginTransaction();
         $sql = "UPDATE usuarios SET nombre= :nombre, email= :email, apellidos = :apellidos, telefono = :telefono, nif = :nif, direccion= :direccion, login = :usuario, password = :password WHERE id=:id";
         $query = $this->db->prepare($sql);
         $query->execute([
            'id' => $datos["id"],
            'nombre' => $datos["nombre"],
            'email' => $datos["email"],
            'apellidos' => $datos["apellidos"],
            'nif' => $datos["nif"],
            'telefono' => $datos["telefono"],
            'direccion' => $datos["direccion"],
            'usuario' => $datos["login"],
            'password' => $datos["password"]
         ]);

         if ($query) { //si se hizo correctamente
            $this->db->commit();  //confirmamos con commit
            $return["correcto"] = TRUE;
         }
      } catch (PDOException $ex) {
         $this->db->rollback(); // o hacemos rollback para descartar los cambios
         $return["error"] = $ex->getMessage();
      }

      return $return;
   }

   /**
    * Función para actualizar a un usuario cambiando también su imagen
    * @param array $datos son los datos necesarios para actualizar un usuario en la base de datos 
    * @return array $return array con distintos datos: "correcto" es true si la operación se llevó a cabo con éxito.
    * "error" son los mensajes de excepciones.
    */
   public function actuserConImagen($datos)
   {
      $return = [
         "correcto" => FALSE,
         "error" => NULL
      ];

      try {
         //Creamos transacción
         $this->db->beginTransaction();
         $sql = "UPDATE usuarios SET nombre= :nombre, email= :email, imagen= :imagen, apellidos = :apellidos, telefono = :telefono, nif = :nif, direccion= :direccion, login = :usuario, password = :password WHERE id=:id";
         $query = $this->db->prepare($sql);
         $query->execute([
            'id' => $datos["id"],
            'nombre' => $datos["nombre"],
            'email' => $datos["email"],
            'imagen' => $datos["imagen"],
            'apellidos' => $datos["apellidos"],
            'nif' => $datos["nif"],
            'telefono' => $datos["telefono"],
            'direccion' => $datos["direccion"],
            'usuario' => $datos["login"],
            'password' => $datos["password"]
         ]);

         if ($query) { //se hizo correctamente
            $this->db->commit();  // confirmamos con commit
            $return["correcto"] = TRUE;
         }
      } catch (PDOException $ex) {
         $this->db->rollback(); // descartamos con rollback
         $return["error"] = $ex->getMessage();
      }
      return $return;
   }


   /**
    * Función para ver los datos de un usuario 
    * @param array $id el id del usuario que quieras ver 
    * @return array $return array con distintos datos: "correcto" es true si la operación se llevó a cabo con éxito. "datos" son los datos del usuario
    * "error" son los mensajes de excepciones.
    */
   public function verUsuario($id)
   {
      $return = [
         "correcto" => FALSE,
         "datos" => NULL,
         "error" => NULL
      ];

      if ($id && is_numeric($id)) {
         try {
            $sql = "SELECT * FROM usuarios WHERE id=:id";
            $query = $this->db->prepare($sql);
            $query->execute(['id' => $id]);
            if ($query) { //se hizo correctamente
               $return["correcto"] = TRUE;
               $return["datos"] = $query->fetch(PDO::FETCH_ASSOC);
            }
         } catch (PDOException $ex) {
            $return["error"] = $ex->getMessage();
         }
      }
      return $return;
   }

   /**
    * Función para comprobar que el user y el pass coinciden y así poder hacer login
    * @param string $user el nick 
    * @param string $pass la contraseña
    * @return array $return array con distintos datos: "correcto" es true si la operación se llevó a cabo con éxito. "datos" son los datos del usuario
    * "error" son los mensajes de excepciones.
    */
   public function comprobarLogin($user, $pass)
   {
      $return = [
         "correcto" => FALSE,
         "datos" => NULL,
         "error" => NULL
      ];

      try {
         $sql = "select * FROM usuarios WHERE login=:user and password=:pass";
         $query = $this->db->prepare($sql);
         $query->execute([
            'user' => $user,
            'pass' => $pass
         ]);

         $query = $query->fetchAll(PDO::FETCH_ASSOC);
         // Si no encuentra nada es que el login está mal


         if ($query) { //tiene algún dato
            $return["correcto"] = TRUE;
            $return["datos"] = $query;
         } // no tiene datos
      } catch (PDOException $ex) {
         $return["error"] = $ex->getMessage();
      }
      return $return;
   }

   /**
    * Función para comprobar que el user y el email no estén ya registrados
    * @param string $login el nick 
    * @param string $email el correo
    * @return array $return array con distintos datos: "correcto" es true si la operación se llevó a cabo con éxito. "datos" son los datos del usuario
    * "error" son los mensajes de excepciones.
    */
   public function comprobarRegistroUsuario($login, $email)
   {
      $return = [
         "correcto" => FALSE,
         "datos" => NULL,
         "error" => NULL
      ];

      try {
         $sql = "select count(*) as total FROM usuarios WHERE login=:user or email=:email";
         $query = $this->db->prepare($sql);
         $query->execute([
            'user' => $login,
            'email' => $email
         ]);

         $query = $query->fetchAll(PDO::FETCH_ASSOC);
         $total = $query[0]["total"];

         if ($total > 0) { //si ya hay usuarios registrados con ese login o email, "correcto" es true
            $return["correcto"] = TRUE;
            $return["datos"] = $query;
         }
      } catch (PDOException $ex) {
         $return["error"] = $ex->getMessage();
      }

      return $return;
   }

   /**
    * Función para activar usuarios
    * @param int $id el id del usuario que queremos activar 
    * @return array $return array con distintos datos: "correcto" es true si la operación se llevó a cabo con éxito. "datos" son los datos del usuario
    * "error" son los mensajes de excepciones.
    */
   public function activarUsuario($id)
   {

      $return = [
         "correcto" => FALSE,
         "datos" => NULL,
         "error" => NULL
      ];

      try {
         $sql = "update usuarios set activado=1 where id=:id";
         $query = $this->db->prepare($sql);
         $query->execute(['id' => $id]);
         if ($query) { //la consulta se hizo correctamente
            $return["correcto"] = TRUE;
            $return["datos"] = $query->fetch(PDO::FETCH_ASSOC);
         }
      } catch (PDOException $ex) {
         $return["error"] = $ex->getMessage();
      }
      return $return;
   }

   /**
    * Función para desactivar usuarios
    * @param int $id el id del usuario que queremos desactivar 
    * @return array $return array con distintos datos: "correcto" es true si la operación se llevó a cabo con éxito. "datos" son los datos del usuario
    * "error" son los mensajes de excepciones.
    */
   public function desactivarUsuario($id)
   {

      $return = [
         "correcto" => FALSE,
         "datos" => NULL,
         "error" => NULL
      ];

      try {
         $sql = "update usuarios set activado=0 where id=:id";
         $query = $this->db->prepare($sql);
         $query->execute(['id' => $id]);

         if ($query) { //la consulta se hizo correctamente
            $return["correcto"] = TRUE;
            $return["datos"] = $query->fetch(PDO::FETCH_ASSOC);
         } // o no :(
      } catch (PDOException $ex) {
         $return["error"] = $ex->getMessage();
         //die();
      }

      return $return;
   }

   /**
    * Función que nos devuelve un listado de los usuarios.
    * @param int $regsxpag el número de registros por página
    * @param int $offset la posición desde donde se muestran los registros

    * @return array $return  array con distintos datos: "correcto" es true si la operación se llevó a cabo con éxito.
    * "datos" son los datos en cuestión que hemos consultado. "error" son los mensajes de excepciones.
    */
   public function paginarUsuarios($regsxpag, $offset)
   {
      $return = [
         "correcto" => FALSE,
         "datos" => NULL,
         "error" => NULL
      ];

      try {
         $regsxpag = (int)$regsxpag;
         $offset = (int)$offset;
         $sql = "select * FROM usuarios ORDER BY id LIMIT ? OFFSET ?";
         $resultsquery = $this->db->prepare($sql);
         $resultsquery->bindParam(1, $regsxpag, PDO::PARAM_INT);
         $resultsquery->bindParam(2, $offset, PDO::PARAM_INT);
         $resultsquery->execute();

         if ($resultsquery) { //se hizo bien la consulta
            $return["correcto"] = TRUE;
            $return["datos"] = $resultsquery->fetchAll(PDO::FETCH_ASSOC);
         }
      } catch (PDOException $ex) {
         $return["error"] = $ex->getMessage();
      }
      return $return;
   }


   /**
    * Función que nos devuelve el número total de usuarios

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
         $sql = 'SELECT count(*) as total FROM usuarios';

         $resultsquery = $this->db->query($sql);


         if ($resultsquery) { //la consulta fue correcta
            $return["correcto"] = TRUE;
            $return["datos"] = $resultsquery->fetch();
         }
      } catch (PDOException $ex) {
         $return["error"] = $ex->getMessage();
      }
      return $return;
   }



   /**
    * Función para cambiar la contraseña en la base de datos
    *
    * @param string $email el email del usuario a cambiar
    * @param string $password la nueva pass

    * @return array $return array con distintos datos: "correcto" es true si la operación se llevó a cabo con éxito.
    * "error" son los mensajes de excepciones.
    */
   public function cambiarContrasena($email, $password)
   {
      $return = [
         "correct" => FALSE,
         "error" => NULL
      ];

      try {
         $sql = "UPDATE usuarios SET password = MD5('$password') WHERE email = '$email'"; //pasamos la pass nueva por el cifrado md5

         //creamos una transacción
         $this->db->beginTransaction();
         $query = $this->db->query($sql);

         
         if ($query) { //se hizo correctamente
            $this->db->commit(); //con commit confirmamos los cambios
            $return["correct"] = TRUE;
         }
      } catch (PDOException $ex) {
         $this->db->rollback(); //con rollback descartamos los cambios
         $return["error"] = $ex->getMessage();
      }
      return $return;
   }

   /**
    * Función que nos dice si algún usuario con el correo indicado 
    * @param string $email el email que queremos comprobar si ya existe en la base de datos
    * @return array $return array con distintos datos: "correcto" es true si la operación se llevó a cabo con éxito.
    * "error" son los mensajes de excepciones.
    */
   public function getByEmail($email)
   {
      $result = [
         "correct" => true,
         "error" => null,
      ];
      try {
         $query = $this->getBy('email', $email);


         if ($query) { //se ha encotrado un usuario con ese correo
            $result["correct"] = true;
         } else {
            $result["correct"] = false;
            
         }
      } catch (PDOException $ex) {
         $result["error"] = $ex->getMessage();
         $result["correct"] = false;
      }
      return $result;
   }
}
