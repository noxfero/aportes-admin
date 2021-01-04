<?php
/* ARCHIVO: Moto.php: 
   TIPO: Modelo - Clase (hereda)
   CONTENIDO: Clase Moto, corresponde con el modelo de datos, tiene los métodos GET/SET y funciones para guardar/actualizar/borrar
   AUTORES: Carlos Muñoz - Carlos Román - Gabriel Villamagua - Miguel Yachimba
*/
class Moto extends EntidadBase{
    private $id;
    private $idusr;
    private $marca;
    private $modelo;
    private $anio;
    private $placa;
    private $estado;
    
    public function __construct($adapter) {
        $table="motos";
        parent::__construct($table,$adapter);
    }
    
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }
    public function getIdusr() {
        return $this->idusr;
    }

    public function setIdusr($idusr) {
        $this->idusr = $idusr;
    }
    

    public function getMarca() {
        return $this->marca;
    }

    public function setMarca($marca) {
        $this->marca = $marca;
    }

    public function getModelo() {
        return $this->modelo;
    }

    public function setModelo($modelo) {
        $this->modelo = $modelo;
    }

    public function getAnio() {
        return $this->anio;
    }

    public function setAnio($anio) {
        $this->anio = $anio;
    }
    public function getPlaca() {
        return $this->placa;
    }

    public function setPlaca($placa) {
        $this->placa = $placa;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    //Registra una nueva moto (para un usuario)
    public function save(){
        $query="INSERT INTO motos (id,idusr,marca,modelo,anio,placa,estado)
                VALUES(NULL,
                       '".$this->idusr."',
                       '".$this->marca."',
                       '".$this->modelo."',
                       '".$this->anio."',
                       '".$this->placa."',
                       '".$this->estado."');";
        $save=$this->db()->query($query);
        //$this->db()->error;
        return $save;
    }

    //Actualiza los datos de la moto
    public function update(){
        $query="UPDATE motos SET marca='$this->marca', modelo='$this->modelo', anio='$this->anio', placa='$this->placa' WHERE id='$this->id'";
        $save=$this->db()->query($query);
        //$this->db()->error;
        return $save;
        
    }

}
?>