<?php
/* ARCHIVO: AyudaVistas.php: 
   TIPO: Core de nuestro "Mini Framework" MVC - Clase
   CONTENIDO: Clase AyudaVistas, contiene las acciones manejar los parámetros de la URL
   AUTORES: Carlos Muñoz - Carlos Román - Gabriel Villamagua - Miguel Yachimba
*/
class AyudaVistas{
    
    //Devuelve la url con los parámetros del controlador y acción
    public function url($controlador=CONTROLADOR_DEFECTO,$accion=ACCION_DEFECTO){
        $urlString="index.php?controller=".$controlador."&action=".$accion;
        return $urlString;
    }
    
    
}
?>
