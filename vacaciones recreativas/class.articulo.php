<?php
require_once 'class.conexion.php';
class Articulo{
    private $id;
    private $nombre;
    private $descripcion;
    const TABLA = 'articulos';

      public function getId() {
        return $this->id;
      }    
     public function getNombre() {
        return $this->nombre;
     }
      public function getDescripcion() {
        return $this->descripcion;
     }
     public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
     }
      public function setNombre($nombre) {
        $this->nombre = $nombre;
     }
     

    public function __construct($nombre,$descripcion)
    {
       $this->nombre = $nombre;
      $this->descripcion = $descripcion;
     
    }
    
     

    public function guardar()
    {
         $conexion = new Conexion();

       try
       {

           $consulta = $conexion->prepare('INSERT INTO ' . self::TABLA .' 
            (art_nombre, art_descripcion) VALUES(:nombre, :descripcion)');
              
          $consulta->bindParam(':nombre', $this->nombre);
          $consulta->bindParam(':descripcion', $this->descripcion);
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