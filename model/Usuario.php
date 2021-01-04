<?php
/* ARCHIVO: Usuario.php: 
   TIPO: Modelo - Clase (hereda)
   CONTENIDO: Clase Usuario, corresponde con el modelo de datos, tiene los métodos GET/SET y una función para guardar
   AUTORES: Carlos Muñoz - Carlos Román - Gabriel Villamagua - Miguel Yachimba
*/
class Usuario extends EntidadBase{
    private $id;
    private $nombre;
    private $apellido;
    private $telefono;
    private $email;
    private $password;
    private $tipo;
    private $estado;
    
    //Constructor de la clase
    public function __construct($adapter) {
        $table="usuarios";
        parent::__construct($table, $adapter);
    }
    
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }
    
    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getApellido() {
        return $this->apellido;
    }

    public function setApellido($apellido) {
        $this->apellido = $apellido;
    }
    public function getTelefono() {
        return $this->telefono;
    }

    public function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    public function save(){
        $query="INSERT INTO usuarios (nombre,apellido,telefono,email,password,tipo,estado)
                VALUES(
                       '".$this->nombre."',
                       '".$this->apellido."',
                       '".$this->telefono."',
                       '".$this->email."',
                       '".$this->password."',
                       '".$this->tipo."',
                       '".$this->estado."');";
        $save=$this->db()->query($query);
        return $save;
    }

}
?>