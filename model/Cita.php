<?php
/* ARCHIVO: Cita.php: 
   TIPO: Modelo - Clase (hereda)
   CONTENIDO: Clase Cita, corresponde con el modelo de datos, tiene los métodos GET/SET y funciones para guardar/actualizar/borrar
   AUTORES: Carlos Muñoz - Carlos Román - Gabriel Villamagua - Miguel Yachimba
*/
class Cita extends EntidadBase{
    private $id;
    private $idcliente;
    private $idmoto;
    private $fecha;
    private $instrucciones;
    private $estado;
    
    //Constructor de la clase
    public function __construct($adapter) {
        $table="citas";
        parent::__construct($table,$adapter);
    }
    
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }
    public function getIdcliente() {
        return $this->idcliente;
    }

    public function setIdcliente($idcliente) {
        $this->idcliente = $idcliente;
    }
    

    public function getIdmoto() {
        return $this->idmoto;
    }

    public function setIdmoto($idmoto) {
        $this->idmoto = $idmoto;
    }

    public function getFecha() {
        return $this->fecha;
    }

    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    public function getInstrucciones() {
        return $this->instrucciones;
    }

    public function setInstrucciones($instrucciones) {
        $this->instrucciones = $instrucciones;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    //Guarda la cita
    public function save(){
        $query="INSERT INTO citas (id,idcliente,idmoto,fecha,instrucciones,estado)
                VALUES(NULL,
                       '".$this->idcliente."',
                       '".$this->idmoto."',
                       '".$this->fecha."',
                       '".$this->instrucciones."',
                       '".$this->estado."');";
        $save=$this->db()->query($query);
        return $save;
    }

    //Obetiene las citas con estado dado el id de usuario 
    public function getMisCitas($idUsr){
        $query=$this->db()->query("SELECT citas.id, citas.idcliente, motos.marca, motos.modelo, motos.placa, citas.fecha, citas.instrucciones, 
        CASE 
        WHEN (citas.estado = 1 AND citas.fecha >= NOW()) THEN 'PENDIENTE' 
        WHEN citas.estado = 0 THEN 'CANCELADA' 
        WHEN citas.estado = 2 THEN 'REALIZADA' 
        WHEN (citas.fecha < NOW() AND citas.estado = 1) THEN 'CADUCADA' ELSE 'N/A' END AS estado
                FROM citas 
                INNER JOIN motos
                ON citas.idmoto = motos.id
        WHERE citas.idCliente='$idUsr';");

        while($row = $query->fetchObject()) {
           $resultSet[]=$row;
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

    // Obtiene las citas considerando el estado
    public function getCitas($estado){
        $query=$this->db()->query("SELECT citas.id, citas.idcliente, CONCAT(usuarios.nombre, ' ' ,usuarios.apellido) as cliente, usuarios.telefono, motos.marca, motos.modelo, motos.anio, motos.placa, citas.fecha, citas.instrucciones, 
        CASE WHEN (citas.estado = 1 AND citas.fecha >= NOW()) THEN 'PENDIENTE' 
        WHEN citas.estado = 0 THEN 'CANCELADA'
        WHEN citas.estado = 2 THEN 'REALIZADA'
        WHEN (citas.fecha < NOW() AND citas.estado = 1) THEN 'CADUCADA' ELSE 'N/A' END AS estado
                FROM citas 
                INNER JOIN motos ON citas.idmoto = motos.id
                INNER JOIN usuarios ON citas.idcliente = usuarios.id
                WHERE citas.estado=1 AND citas.fecha >= NOW();");

        while($row = $query->fetchObject()) {
           $resultSet[]=$row;
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

    //Actualiza las citas
    public function update(){
        $query="UPDATE citas SET fecha='$this->fecha', instrucciones='$this->instrucciones' WHERE id='$this->id'";
        $save=$this->db()->query($query);
        //$this->db()->error;
        return $save;
        
    }

}
?>