<?php
/* ARCHIVO: Conectar.php: 
   TIPO: Core de nuestro "Mini Framework" MVC - Clase
   CONTENIDO: Clase Conectar, Establece la conexión con la DB e inicializa el framework FluentPDO
   AUTORES: Carlos Muñoz - Carlos Román - Gabriel Villamagua - Miguel Yachimba
*/
class Conectar{
    private $driver;
    private $host, $user, $pass, $database, $charset;
  
    public function __construct() {
        $db_cfg = require_once 'config/database.php';
        $this->driver=$db_cfg["driver"];
        $this->host=$db_cfg["host"];
        $this->user=$db_cfg["user"];
        $this->pass=$db_cfg["pass"];
        $this->database=$db_cfg["database"];
        $this->charset=$db_cfg["charset"];
    }
    
    //Conecta con la DB
    public function conexion(){
        
        if($this->driver=="pgsql" || $this->driver==null){
            //$con=new PDO($this->host, $this->user, $this->pass, $this->database);
            //$con->query("SET NAMES '".$this->charset."'");
			$base_de_datos = new PDO("pgsql:host=$this->host;port=5432;dbname=$this->database", $this->user, $this->pass);
			$base_de_datos->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        
        //return $con;
		return $base_de_datos;
    }
    
    //Inicializa el FluentPDO
    public function startFluent(){
        require_once "FluentPDO/FluentPDO.php";
        
        if($this->driver=="pgsql" || $this->driver==null){
            $pdo = new PDO($this->driver.":dbname=".$this->database, $this->user, $this->pass);
            $fpdo = new FluentPDO($pdo);
        }
        
        return $fpdo;
    }
}
?>
