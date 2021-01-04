<?php
/* ARCHIVO:EntidadBase.php: 
   TIPO: Core de nuestro "Mini Framework" MVC - Clase
   CONTENIDO: Super Clase EntidadBase, Establece el comportamiento de toda entidad
   AUTORES: Diego Peralta - Carlos Román
*/
class EntidadBase{
    private $table;
    private $db;
    private $conectar;

    public function __construct($table, $adapter) {
        $this->table=(string) $table;
        
		$this->conectar = null;
		$this->db = $adapter;
    }
    
    //Conecta a la DB
    public function getConetar(){
        return $this->conectar;
    }
    
    // Retona el objeto DB
    public function db(){
        return $this->db;
    }
    
    //Devuelve todos los registros de la tabla que se envíe en el Adapter
    public function getAll(){
        $query=$this->db->query("SELECT * FROM $this->table ORDER BY id DESC");

        while ($row = $query->fetchObject()) {
           $resultSet[]=$row;
        }
        
        return $resultSet;
    }

    //Devuelve todos los registros de la tabla que se envíe en el Adapter, considerando una columna=valor y con la condición colEstado=estado
    public function getAllofOneConEstado($columna,$valor,$colEstado,$estado){
        $query=$this->db->query("SELECT * FROM $this->table WHERE $columna='$valor' AND $colEstado='$estado' ORDER BY $columna DESC");

        while ($row = $query->fetchObject()) {
           $resultSet[]=$row;
        }
        
        if (isset($resultSet) == false)
        {
            $resultSet = NULL;
        }

        return $resultSet;
    }
	
	public function getAllofOneConEstadoLimit($columna,$valor,$colEstado,$estado,$orderby,$limit){
        $query=$this->db->query("SELECT * FROM $this->table WHERE $columna='$valor' AND $colEstado='$estado' ORDER BY $orderby DESC LIMIT 20 OFFSET $limit");

        while ($row = $query->fetchObject()) {
           $resultSet[]=$row;
        }
        
        if (isset($resultSet) == false)
        {
            $resultSet = NULL;
        }

        return $resultSet;
    }
	

    //Devuelve todos los registros de la tabla que se envíe en el Adapter asado en el campo enviado id
    public function getById($id){
        $query=$this->db->query("SELECT * FROM $this->table WHERE id=$id");

        if($row = $query->fetchObject()) {
           $resultSet=$row;
        }
        
        return $resultSet;
    }

    //Devuelve todos los registros de la tabla que se envíe en el Adapter, devuelve la columna campo cuando columna=valor
    public function getCampoByVal($campo,$columna,$valor){
        $query=$this->db->query("SELECT $campo FROM $this->table WHERE $columna='$valor'");

        if($row = $query->fetchObject()) {
           $resultSet=$row;
        }
        if (!empty($resultSet))
        {
            return  $resultSet;
        }
        else
        {
            return NULL;
        }
        
    }

    //Devuelve todos los registros de la tabla que se envíe en el Adapter, se selecciona campo cuando columna=valor AND colestado=estado
    public function getCampoByValConEstados($campo,$columna,$valor,$colEstado,$estados){
        $query=$this->db->query("SELECT $campo FROM $this->table WHERE $columna='$valor' AND $colEstado IN('$estados')");
		//$query=$this->db->query("SELECT $campo FROM $this->table WHERE $columna='$valor' AND $colEstado ='$estados'");

        if($row = $query->fetchObject()) {
           $resultSet=$row;
        }
        if (!empty($resultSet))
        {
            return  $resultSet;
        }
        else
        {
            return NULL;
        }
        
    }
    
    //Devuelve todos los registros de la tabla que se envíe en el Adapter, cuando columna=valor
    public function getBy($column,$value){
        $query=$this->db->query("SELECT * FROM $this->table WHERE $column='$value'");

        while($row = $query->fetchObject()) {
           $resultSet[]=$row;
        }
        
        return $resultSet;
    }
    
    //Borra un registro basado en un Id
    public function deleteById($id){
        $query=$this->db->query("DELETE FROM $this->table WHERE id=$id"); 
        return $query;
    }
    
    //Borra un registro basado en columna=valor
    public function deleteBy($column,$value){
        $query=$this->db->query("DELETE FROM $this->table WHERE $column='$value'"); 
        return $query;
    }

    //Deshabilita un campo basado en un id, siendo campo=valor cuando se tiene el id
    public function disableById($id, $campo, $valor){
        $query=$this->db->query("UPDATE $this->table SET $campo='$valor' WHERE id=$id"); 
        return $query;
    }
    
    //Devuelve un saludo
    public function bienvenido(){
        return 'Bienvenido al Laboratorio UNIR-CSW';
    }

    //Devuelve en pantalla una alerta de tipo javascript
    function phpAlert($msg,$redir) {
        echo '<script type="text/javascript">
        alert("' . $msg . '");
        window.location.href=\''.$redir.'\';
        </script>';
    }
    
}
?>
