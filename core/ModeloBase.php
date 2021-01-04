<?php
/* ARCHIVO:ModeloBase.php: 
   TIPO: Core de nuestro "Mini Framework" MVC - Clase
   CONTENIDO: Super Clase ModeloBase, Establece el comportamiento de todo Modelo
   AUTORES: Carlos Muñoz - Carlos Román - Gabriel Villamagua - Miguel Yachimba
*/
class ModeloBase extends EntidadBase{
    private $table;
    private $fluent;
    
    public function __construct($table, $adapter) {
        $this->table=(string) $table;
        parent::__construct($table, $adapter);
        
        $this->fluent=$this->getConetar()->startFluent();
    }
    
    //Devuelve el objeto Fluent
    public function fluent(){
        return $this->fluent;
    }
    
    //Ejecuta el SQL que se envíe como query
    public function ejecutarSql($query){
        $query=$this->db()->query($query);
        if($query==true){
            if($query->num_rows>1){
                while($row = $query->fetch_object()) {
                   $resultSet[]=$row;
                }
            }elseif($query->num_rows==1){
                if($row = $query->fetch_object()) {
                    $resultSet=$row;
                }
            }else{
                $resultSet=true;
            }
        }else{
            $resultSet=false;
        }
        
        return $resultSet;
    }

    
}
?>


