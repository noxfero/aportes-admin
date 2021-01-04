<?php
/* ARCHIVO: ControladorBase.php: 
   TIPO: Core de nuestro "Mini Framework" MVC - Clase
   CONTENIDO: Super Clase ControladorBase, Establece el comportamiento de todo controlador
   AUTORES: Carlos Muñoz - Carlos Román - Gabriel Villamagua - Miguel Yachimba
*/
class ControladorBase{

    public function __construct() {
		require_once 'Conectar.php';
        require_once 'EntidadBase.php';
        require_once 'ModeloBase.php';
        
        //Incluir todos los modelos
        foreach(glob("model/*.php") as $file){
            require_once $file;
        }
    }
    
    //Plugins y funcionalidades
    public function view($vista,$datos){
        foreach ($datos as $id_assoc => $valor) {
            ${$id_assoc}=$valor; 
        }
        
        require_once 'core/AyudaVistas.php';
        $helper=new AyudaVistas();
    
        require_once 'view/'.$vista.'View.php';
    }
    
    //Hace un redirect al controlador y acción que se le indique
    public function redirect($controlador=CONTROLADOR_DEFECTO,$accion=ACCION_DEFECTO){
        header("Location:index.php?controller=".$controlador."&action=".$accion);
    }

    //devuelve al URL Base de inicio
    public function baseUrl($controlador=CONTROLADOR_DEFECTO,$accion=ACCION_DEFECTO){
        return "index.php?controller=".$controlador."&action=".$accion;
    }


}
?>
