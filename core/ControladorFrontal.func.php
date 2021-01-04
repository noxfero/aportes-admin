<?php
/* ARCHIVO: ControladorFrontal.func.php: 
   TIPO: Core de nuestro "Mini Framework" MVC - Clase
   CONTENIDO: Funciones, Establece funciones que usa un ControladorBase
   AUTORES: Carlos Muñoz - Carlos Román - Gabriel Villamagua - Miguel Yachimba
*/

//Carga un COntrolador
function cargarControlador($controller){
    $controlador=ucwords($controller).'Controller';
    $strFileController='controller/'.$controlador.'.php';
    
    if(!is_file($strFileController)){
        $strFileController='controller/'.ucwords(CONTROLADOR_DEFECTO).'Controller.php';   
    }
    
    require_once $strFileController;
    $controllerObj=new $controlador();
    return $controllerObj;
}

//Carga una acción
function cargarAccion($controllerObj,$action){
    $accion=$action;
    $controllerObj->$accion();
}

//Lanza una acción
function lanzarAccion($controllerObj){
    if(isset($_GET["action"]) && method_exists($controllerObj, $_GET["action"])){
        cargarAccion($controllerObj, $_GET["action"]);
    }else{
        cargarAccion($controllerObj, ACCION_DEFECTO);
    }
}

?>
