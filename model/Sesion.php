<?php
/* ARCHIVO: Sesion.php: 
   TIPO: Modelo - Clase (hereda)
   CONTENIDO: Clase Sesion, corresponde con el modelo de datos, tiene los métodos GET/SET y funciones para guardar
   AUTORES: Carlos Muñoz - Carlos Román - Gabriel Villamagua - Miguel Yachimba
*/
class Sesion extends EntidadBase{
    private $id;
    private $usuario;
    private $sesion;
    private $fecha;
    private $estado;
    
    //Constructor de la clase
    public function __construct($adapter) {
        $table="sesiones";
        parent::__construct($table, $adapter);
    }
    
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }
    
    public function getUsuario() {
        return $this->usuario;
    }

    public function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    public function getSesion() {
        return $this->sesion;
    }

    public function setSesion($sesion) {
        $this->sesion = $sesion;
    }

    public function getFecha() {
        return $this->fecha;
    }

    public function setfecha($fecha) {
        $this->fecha = $fecha;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    //Guardar una sesión
    public function save(){
        $query="INSERT INTO sesiones (usuario,sesion,fecha,estado)
                VALUES(
                       '".$this->usuario."',
                       '".$this->sesion."',
                       '".$this->fecha."',
                       '".$this->estado."');";
        $save=$this->db()->query($query);
        //$this->db()->error;
        return $save;
    }

}
?>