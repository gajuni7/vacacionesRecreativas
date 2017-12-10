<?php
class Conexion extends PDO { 

private $DB_tipo = "mysql";
private $DB_host = "localhost";
private $DB_name = "dblogin";
private $DB_user = "root";
private $DB_pass = "";

	public function __construct() {
		try
		{
		     //$DB_con = new PDO("mysql:host={$DB_host};dbname={$DB_name}",$DB_user,$DB_pass);
		     //$DB_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		     parent::__construct($this->DB_tipo.':host='.$this->DB_host.';dbname='.
		     	$this->DB_name, $this->DB_user, $this->DB_pass);

		}catch(PDOException $e){

		     echo 'Ha surgido un error y no se puede conectar a la base de datos. Detalle: ' . $e->getMessage();
		         exit;
		}
	}
}

?>