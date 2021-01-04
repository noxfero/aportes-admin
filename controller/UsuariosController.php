<?php
/* ARCHIVO: UsuariosController.php: 
   TIPO: Controlador - Clase (hereda)
   CONTENIDO: Clase UsuariosController, contiene las acciones para gestionar el registro y eliminación de usuarios
   AUTORES: Carlos Muñoz - Carlos Román - Gabriel Villamagua - Miguel Yachimba
*/
class UsuariosController extends ControladorBase{
    public $conectar;
	public $adapter;
    
    //Constructor de la clase
    public function __construct() {
        parent::__construct();
		// Instancia Conectar y conexión
        $this->conectar=new Conectar(); 
        $this->adapter=$this->conectar->conexion();
    }
    
    //Acción por defecto
    public function index(){
        //Creamos el objeto 
        $usuario=new Usuario($this->adapter);
        //Conseguimos todos los usuarios
        $msj=$usuario->bienvenido();
       //Cargamos la vista index y le pasamos valores
       $this->view("registro",array(
        "bienvenida"=>$msj,
    ));
    }
    
    //Accion para registrar un usuario
    public function crear(){

        if(isset($_POST["nombre"])){ // Si en el post fue enviado el nombre
            $usuario=new Usuario($this->adapter); //Instancia un usuario
            $usr=$usuario->getCampoByVal('email','email',$_POST["email"]); // recupero su e-mail
            $existe = false;
            if ((isset($usr) || !empty($usr))) // Si el usuario existe en la DB
            {
                if (trim($usr->email) == trim($_POST["email"])) // SI el usuario ya existe
                {
                    $usuario->phpAlert("Usuario ya registrado en el sistema",$this->baseUrl("usuarios","index")); // Alerta y redirecciona al index
                    $existe = true;
                }
            }
            if ($existe == false) // SI es un usuario nuevo
            {
                $usuario->setNombre($_POST["nombre"]);
                $usuario->setApellido($_POST["apellido"]);
                $usuario->setTelefono($_POST["telefono"]);
                $usuario->setEmail($_POST["email"]);
                $usuario->setPassword(password_hash($_POST["password"],PASSWORD_DEFAULT));
                $usuario->setTipo(1);
                $usuario->setEstado(1);
                $save=$usuario->save(); // Manda a guardar el usuario en el modelo
                if ($save == TRUE) // Si se guardó con éxito
                {
                    $usuario->phpAlert("Usuario registrado con éxito",$this->baseUrl()); // Alerta y redirecciona al index
                }
                else
                {
                    $usuario->phpAlert("Error con el registro. Interente nuevamente",$this->baseUrl("usuarios","index")); // Alerta y redirecciona al index
                    
                }
            }
        }
    }
    
    //Acción para desabilitar un usuario, llama a un método que hereda de EntidadBase.php
    public function borrar(){
        if(isset($_GET["id"])){ // Si se proporcionó un id
            $id=(int)$_GET["id"];
            // Instancia usuario y llama al método heredado de EntidadBase para deshabilitar
            $usuario=new Usuario($this->adapter);
            $usuario->disableById($id,"estado",0); 
        }
        $this->redirect("Usuarios", "index"); // Redirecciona al controlador por defecto de usuarios
    }

}
?>
