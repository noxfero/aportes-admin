<?php
/* ARCHIVO: BandejaUsersController.php: 
   TIPO: Controlador - Clase (hereda)
   CONTENIDO: Clase BandejaUsersController, contiene las acciones para gestionar las operaciones que realiza el usuario (cliente)
   AUTORES: Carlos Muñoz - Carlos Román - Gabriel Villamagua - Miguel Yachimba
*/
class BandejaAdminsController extends ControladorBase{
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
        session_start();
        //Creamos el objeto usuario
        $aportante=new Aportante($this->adapter);
        $aporte=new Aporte($this->adapter);
        $usrId =  $_SESSION['miUserId'];
        //Conseguimos todos los usuarios
        $allMisAportantes=$aportante->getAllofOneConEstado('"isActive"','1','"isActive"','1');
        $allMisAportes=$aporte->getMisAportes('"bankValidated"','0');

         //Cargamos la vista index y le pasamos valores
         $this->view("bandejaAdmin",array(
            "allMisAportantes"=>$allMisAportantes,
            "allMisAportes"=>$allMisAportes
        ));
        
    }
    
    //Registra N motos pasados desde el contendeor dinámico de la vista mediante arrays
    public function agregaAportantes(){
        session_start();
        $usrId= $_SESSION['miUserId'];
        $number = count($_POST["cedula"]);  
        if($number > 0)  //Si hay al menos una moto
        {  
            for($i=0; $i<$number; $i++)  // Para cada moto enviada en el array
            {  
                if(trim($_POST["cedula"][$i] != ''))  // Si hay datos de la moto
                {  
                    $aportante=new Aportante($this->adapter);
                    $aportante->setCedula($_POST["cedula"][$i]);
                    $aportante->setNames($_POST["names"][$i]);
                    $aportante->setLastnames($_POST["lastnames"][$i]);
                    $aportante->setType('N');
                    $aportante->setAddressCountry($_POST["addressCountry"][$i]);
					$aportante->setAddressProvince($_POST["addressProvince"][$i]);
                    $aportante->setAddressCity($_POST["addressCity"][$i]);
                    $aportante->setAddressStreet($_POST["addressStreet"][$i]);
                    $aportante->setPhoneHome($_POST["phoneHome"][$i]);
					$aportante->setPhoneMobile($_POST["phoneMobile"][$i]);
                    $aportante->setEmail($_POST["email"][$i]);
                    $aportante->setIsActive('true');
                    $aportante->setOriginProvince($_POST["originProvince"][$i]);
					$aportante->setOriginCity($_POST["originCity"][$i]);
                    
					
                    $save=$aportante->save(); // Manda a guardar la moto en el modelo
                }      
            }  
        }  
        else  
        {   
        } 
        $this->redirect("BandejaAdmins", "index");  // COntrolador + Vista
    }

    //Edita los datos de una moto   
    public function editarAportante(){  
        if(isset($_POST["cedulaE"]))
        {
            $aportante=new Aportante($this->adapter);
            $aportante->setAportanteID($_POST["idE"]);
            $aportante->setCedula($_POST["cedulaE"]);
            $aportante->setNames($_POST["namesE"]);
            $aportante->setLastnames($_POST["lastnamesE"]);
            $aportante->setPhoneHome($_POST["phoneHomeE"]);
			$aportante->setPhoneMobile($_POST["phoneMobileE"]);
			$aportante->setEmail($_POST["emailE"]);
            $save=$aportante->update(); // Manda a actualizar la moto en el modelo
        }     
        $this->redirect("BandejaAdmins", "index");  // COntrolador + Vista
    }
	
	
	//Edita los datos de una moto   
    public function editarAporte(){  
        if(isset($_POST["valueE"]) && isset($_POST["bankE"]) && isset($_POST["accountE"]))
        {
			$valx = "0";
			if (isset($_POST["transactionE"]))
			{
				$valx = $_POST["transactionE"];
			}
            $aporte=new Aporte($this->adapter);
            $aporte->setAporteID($_POST["idxE"]);
			$aporte->setValue($_POST["valueE"]);
            $aporte->setBank($_POST["bankE"]);
            $aporte->setAccount($_POST["accountE"]);
            $aporte->setTransactionID($valx);
            
            $save=$aporte->update(); // Manda a actualizar la moto en el modelo
        }     
        $this->redirect("BandejaAdmins", "index");  // COntrolador + Vista
    }

    //Demo de carga de Cita
    public function cargarCita(){
        if(isset($_GET["id"])){
            echo ($_GET["datos"]);
        }
        else
        {
            echo ("No hay Id");
        }
    }

    //Registra una cita
    public function agregaAportes(){
        session_start();
        $usrId= $_SESSION['miUserId'];
        $aporte=new Aporte($this->adapter);
        if(isset($_POST["aportanteID"]) && !empty($_POST["aportanteID"])){ // Si hay datos
            if(isset($_POST["value"]) && isset($_POST["account"]) && isset($_POST["bank"])){
                //Creamos un usuario
                       
                $aporte->setAportanteID($_POST["aportanteID"]);
                $aporte->setValue($_POST["value"]);
                $aporte->setType('1');
                $aporte->setBank($_POST["bank"]);
				$aporte->setAccount($_POST["account"]);
				$aporte->setTransactionID('0');
				$aporte->setRegisteredDate(date("Y-m-d H:i:s", time()));
				$aporte->setBankValidated('false');
				$aporte->setCallCenterValidated('false');
				$aporte->setIsPdfGenerated('false');
				$aporte->setIsActive('true');
                $save=$aporte->save(); // Manda a guardar una cita en el modelo
                if ($save == TRUE)
                {
                    $aporte->phpAlert("Aporte creado con éxito",$this->baseUrl("BandejaAdmins", "index")); // Alerta y redirige
                }
                else
                {
                    $aporte->phpAlert("Error con el registro. Interente nuevamente",$this->baseUrl("BandejaAdmins", "index")); // Alerta y redirige
                    
                }
                
            }

        }
        else
        {
            $aporte->phpAlert("Debe seleccionar priemro un aportante para poder guardar el aporte.",$this->baseUrl("BandejaAdmins", "index")); // Alerta y redirige
        }
        
        
    }
    
    //Acción para desabilitar una moto (cambia de estado), llama a un método que hereda de EntidadBase.php
    public function borrarMoto(){
        if(isset($_GET["id"])){ 
            $id=(int)$_GET["id"];
            // Instancia moto y llama a un método heredado para deshabilitar
            $moto=new Moto($this->adapter);
            $moto->disableById($id,"estado","0"); 
        }
        $this->redirect("BandejaAdmins", "index");
    }

    //Acción para desabilitar una cita, llama a un método que hereda de EntidadBase.php
    public function cancelarCita(){
        if(isset($_GET["id"])){ 
            $id=(int)$_GET["id"];
            // Instancia cita y llama a un método heredado para deshabilitar
            $cita=new Cita($this->adapter);
            $cita->disableById($id,"estado","0"); 
        }
        $this->redirect("BandejaAdmins", "index");
    }
    

}
?>
