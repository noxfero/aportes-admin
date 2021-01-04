<?php
/* ARCHIVO: UsuariosModel.php: 
   TIPO: Modelo - Clase (hereda)
   CONTENIDO: Método de pruea que retorna los datos del usuario de prueba 'mecanico'
   AUTORES: Carlos Muñoz - Carlos Román - Gabriel Villamagua - Miguel Yachimba
*/

class UsuariosModel extends ModeloBase{
    private $table;
    
    //Constructor de la clase
    public function __construct($adapter){
        $this->table="usuarios";
        parent::__construct($this->table, $adapter);
    }
    
    //Metodos de consulta
    public function getUnUsuario(){
        $query="SELECT * FROM usuarios WHERE email='mecanico'";
        $usuario=$this->ejecutarSql($query);
        return $usuario;
    }
}
?>
