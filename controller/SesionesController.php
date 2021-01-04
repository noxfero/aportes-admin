<?php
/* ARCHIVO: SesionesController.php: 
   TIPO: Controlador - Clase (hereda)
   CONTENIDO: Clase SesionesController, contiene las acciones para gestionar el login y las sesiones
   AUTORES: Diego Peralta - Carlos Román
*/
class SesionesController extends ControladorBase{
    public $conectar;
	public $adapter;
    
    //Constructor de la clase
    public function __construct() {
        parent::__construct();
		// Instancia Conectar y conexión 
        $this->conectar=new Conectar();
        $this->adapter=$this->conectar->conexion();
    }
    
    public function index(){
        //Creamos el objeto
        $usuario=new Usuario($this->adapter);
        //Conseguimos todos los usuarios
        $msj=$usuario->bienvenido();
       //Cargamos la vista index y le pasamos valores
       $this->view("login",array(
        "bienvenida"=>$msj,
    ));
    }

    //Realiza el login e inicia sesión si el usuario está registrado
    public function iniciar(){
        if (isset($_POST['login'])) { //si se han enviado datos para login
            //Creamos el objeto 
            $usuario=new Usuario($this->adapter);
            // Si los campos no están vacíos o null
            if(isset($_POST["usuario"]) && isset($_POST["password"]) && !empty($_POST['usuario']) && !empty($_POST['password']) ){
                //Conseguimos el password del usuario
                $passwordDB=$usuario->getCampoByValConEstados('"password"','"email"',$_POST["usuario"],'"estado"','1');
                $userCorrecto = false;
                if(!empty($passwordDB))
                {
                    $userCorrecto = password_verify($_POST["password"],$passwordDB->password); // Verifica la contraseña cifrada
                }
                if ($userCorrecto == true) // Si el usuario y password son correctos
                {
                    $usr=$usuario->getCampoByVal('id','email',$_POST["usuario"]);
                    $tipoUsr=$usuario->getCampoByVal('tipo','email',$_POST["usuario"]);
                  
                    $date = new \DateTime('now');
                    $length = 20;
                    // SesionId es generada
                    $sesionId = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
                    //Iniciamos sesión
                    session_start();
                    $_SESSION['miSesion']=$sesionId;
                    $_SESSION['miUserId'] = $usr->id;
                    $sesion=new Sesion($this->adapter);
                    $sesion->setUsuario($_POST["usuario"]);
                    $sesion->setSesion($sesionId);
                    $sesion->setFecha($date->format('D M d, Y G:i'));
                    $sesion->setEstado(1);
                    $save=$sesion->save(); // Manda a guardar la sesión en el modelo
                    if ($tipoUsr->tipo == 1) // Si es usuario normal
                    {
                        $this->redirect("BandejaAdmins", "index"); // Controlador + Acción
                    }
                    else if ($tipoUsr->tipo == 2) //Si es un usuario del cruce bancario
                    {
                        $this->redirect("BandejaBancos", "index"); // Controlador + Acción
                    }
                    else if ($tipoUsr->tipo == 3) //Si es un usuario del taller mecánico
                    {
                        $this->redirect("BandejaCallcenters", "index"); // Controlador + Acción
                    }
					
                }
                else
                {
                    //Usuario o clave incorrectos
                    echo ("Usuario incorrecto");
                    $usuario->phpAlert("Usuario o Password incorrectos",$this->baseUrl()); // Alerta y redirecciona
                                    }
            }
            else
            {
                $usuario->phpAlert("Debe colocar el usuario y password",$this->baseUrl()); // Alerta y redirecciona
            }
        } else if (isset($_POST['registrar'])) { //Para registrarse
           $this->redirect("Usuarios", "index"); // COntrolador + Acción
        } 
    }
    
    //Acción para cerrar la sesión, llama a un método que hereda de EntidadBase.php
    public function salir(){
        // Si hay un ID enviado
        if(isset($_GET["id"])){ 
            $id=(int)$_GET["id"];
            // Instancia un usuario y llama a disableById de la Entidad Base 
            $usuario=new Usuario($this->adapter);
            $usuario->disableById($id,"estado",0); 
        }
        $this->redirect(); //Redirije al controlador por defecto
    }


}
?>
