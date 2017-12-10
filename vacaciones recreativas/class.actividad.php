<?php
require_once 'class.conexion.php';

class Actividad {
    //private $db;
    private $id;
    private $descripcion;
    private $lugar;
    const TABLA = 'actividades';

      public function getId() {
      return $this->id;
      }    
     public function getDescripcion() {
        return $this->descripcion;
     }
     public function getLugar() {
        return $this->lugar;
     }
     public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
     }
     public function setLugar($lugar) {
        $this->lugar = $lugar;
     }

    public function __construct($descripcion,$lugar)
    {
      $this->descripcion = $descripcion;
      $this->lugar = $lugar;
    }
    
     

    public function guardar()
    {
         $conexion = new Conexion();

       try
       {

           $consulta = $conexion->prepare('INSERT INTO ' . self::TABLA .' 
            (act_descripcion, act_lugar) VALUES(:descripcion, :lugar)');
              
          $consulta->bindParam(':descripcion', $this->descripcion);
          $consulta->bindParam(':lugar', $this->lugar);
          $consulta->execute();
          $this->id = $conexion->lastInsertId();
          return $consulta;
          
       }catch(PDOException $e){
           echo $e->getMessage();
       }    
    }
    
    public function redirect($url)
   {
       header("Location: $url");
   }
    

}
?>