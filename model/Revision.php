<?php
/* ARCHIVO: Revision.php: 
   TIPO: Modelo - Clase (hereda)
   CONTENIDO: Clase Revision, corresponde con el modelo de datos, tiene los métodos GET/SET y funciones para guardar/actualizar/borrar
   AUTORES: Carlos Muñoz - Carlos Román - Gabriel Villamagua - Miguel Yachimba
*/
class Revision extends EntidadBase{
    private $id;
    private $idcita;
    private $idtecnico;
    private $fechafin;
    private $observaciones;
    private $estado;
    
    //Constructor de la clase
    public function __construct($adapter) {
        $table="revisiones";
        parent::__construct($table,$adapter);
    }
    
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }
    public function getIdcita() {
        return $this->idcita;
    }

    public function setIdcita($idcita) {
        $this->idcita = $idcita;
    }
    

    public function getIdtecnico() {
        return $this->idtecnico;
    }

    public function setIdtecnico($idtecnico) {
        $this->idtecnico = $idtecnico;
    }

    public function getFechafin() {
        return $this->fechafin;
    }

    public function setFechafin($fechafin) {
        $this->fechafin = $fechafin;
    }

    public function getObservaciones() {
        return $this->oservaciones;
    }

    public function setObservaciones($observaciones) {
        $this->observaciones = $observaciones;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    //Guarda una revisión
    public function save(){
        $query="INSERT INTO revisiones (id,idcita,idtecnico,fechafin,observaciones,estado)
                VALUES(NULL,
                       '".$this->idcita."',
                       '".$this->idtecnico."',
                       '".$this->fechafin."',
                       '".$this->observaciones."',
                       '".$this->estado."');";
        $save=$this->db()->query($query);
        return $save;
    }

    //Devuelve el listado de revisiones dato un id de usuario
    public function getMisRevisiones($idUsr){
        $query=$this->db()->query("SELECT revisiones.id, revisiones.idtecnico,citas2.cliente, citas2.marca, citas2.modelo, citas2.placa, revisiones.fechafin, revisiones.observaciones
        FROM revisiones 
        INNER JOIN 
        (SELECT citas.id, citas.idcliente, CONCAT(usuarios.nombre, ' ' ,usuarios.apellido) as cliente, usuarios.telefono, motos.marca, motos.modelo, motos.anio, motos.placa, citas.fecha, citas.instrucciones, 
        CASE WHEN (citas.estado = 1 AND citas.fecha >= NOW()) THEN 'PENDIENTE' 
        WHEN citas.estado = 0 THEN 'CANCELADA' 
        WHEN (citas.fecha < NOW() AND citas.estado = 1) THEN 'CADUCADA' ELSE 'N/A' END AS estado
        FROM citas 
        INNER JOIN motos ON citas.idmoto = motos.id
        INNER JOIN usuarios ON citas.idcliente = usuarios.id) AS
        citas2 ON revisiones.idcita = citas2.id
        WHERE revisiones.idtecnico='$idUsr';");

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

}
?>