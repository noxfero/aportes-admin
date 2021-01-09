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

        $cedB ="000";
        if(isset($_POST["cedulaB"]))
        {
            $cedB = $_POST["cedulaB"];
        }
        $allMisAportesX=$aporte->getAportesPorCedula($cedB);

         //Cargamos la vista index y le pasamos valores
         $this->view("bandejaAdmin",array(
            "allMisAportantes"=>$allMisAportantes,
            "allMisAportes"=>$allMisAportes,
            "allMisAportesX"=>$allMisAportesX
        ));
        
    }
    
    //Registra N motos pasados desde el contendeor dinámico de la vista mediante arrays
    public function agregaAportantes(){
        session_start();
        $usrId= $_SESSION['miUserId'];
        $number = count($_POST["cedula"]);  
        if($number > 0)  //Si hay al menos un aportante
        {  
            for($i=0; $i<$number; $i++)  // Para cada moto enviada en el array
            {  
                if(
                    (trim($_POST["cedula"][$i])) != '' && (strlen(trim($_POST["cedula"][$i]))==10) 
                && (strlen(trim($_POST["names"][$i]))>=3) && (strlen(trim($_POST["lastnames"][$i]))>=2) 
                && (strlen(trim($_POST["email"][$i]))>=5) && (strlen(trim($_POST["phoneMobile"][$i]))>=7) 
                && (strlen(trim($_POST["addressCountry"][$i]))>=3) && (strlen(trim($_POST["addressProvince"][$i]))>=3) 
                && (strlen(trim($_POST["addressCity"][$i]))>=3) && (strlen(trim($_POST["addressStreet"][$i]))>=3) 
                && (strlen(trim($_POST["originProvince"][$i]))>=3) && (strlen(trim($_POST["originCity"][$i]))>=3) 

                 )  
                {  
                    $aportante=new Aportante($this->adapter);
                    $aportante->setCedula($_POST["cedula"][$i]);
                    $aportante->setNames($_POST["names"][$i]);
                    $aportante->setLastnames($_POST["lastnames"][$i]);
                    $aportante->setType('C');
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
                    if ($save == TRUE)
                    {
                        $aportante->phpAlert("Aportante creado con éxito",$this->baseUrl("BandejaAdmins", "index")); // Alerta y redirige
                    }
                    else
                    {
                        $aportante->phpAlert("Error con el registro. Interente nuevamente",$this->baseUrl("BandejaAdmins", "index")); // Alerta y redirige
                        
                    }  
                }    
                else
                {
                    $aportantez = new Aportante($this->adapter);
                    $aportantez->phpAlert("Debe llenar todos los campos para poder guardar.",$this->baseUrl("BandejaAdmins", "index")); // Alerta y redirige
                }  
            }  
        }  
        else  
        {   $aportantex = new Aportante($this->adapter);
            $aportantex->phpAlert("Ha enviados datos pero no se guardó.",$this->baseUrl("BandejaAdmins", "index")); // Alerta y redirige
        } 
        //$this->redirect("BandejaAdmins", "index");  // COntrolador + Vista
    }

    //Edita los datos de una moto   
    public function editarAportante(){  
        if((isset($_POST["cedulaE"]))&& (strlen(trim($_POST["cedulaE"]))==10)
        && (strlen(trim($_POST["namesE"]))>=3)
        && (strlen(trim($_POST["lastnamesE"]))>=3) 
        && (strlen(trim($_POST["phoneMobileE"]))>=7) 
        && (strlen(trim($_POST["emailE"]))>=3) 
        )
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
            if ($save == TRUE)
                    {
                        $aportante->phpAlert("Aportante actualizado con éxito",$this->baseUrl("BandejaAdmins", "index")); // Alerta y redirige
                    }
                    else
                    {
                        $aportante->phpAlert("Error con la actualización. Interente nuevamente",$this->baseUrl("BandejaAdmins", "index")); // Alerta y redirige
                        
                    }  
        }
        else
        {
            $aportantex = new Aportante($this->adapter);
            $aportantex->phpAlert("Complete todos los campos para almacenar.",$this->baseUrl("BandejaAdmins", "index")); // Alerta y redirige
        }     
        
        //$this->redirect("BandejaAdmins", "index");  // COntrolador + Vista
    }
	
	
	//Edita los datos de una moto   
    public function editarAporte(){  
        if(isset($_POST["valueE"]) && isset($_POST["bankE"]) && isset($_POST["accountE"]))
        {
			$valx = "0";
			if (isset($_POST["transactionE"]) && (strlen(trim($_POST["transactionE"]))>=3))
			{
				$valx = $_POST["transactionE"];
            }
            if((isset($_POST["idxE"]))&& (strlen(trim($_POST["valueE"]))>=1)
            && (strlen(trim($_POST["bankE"]))>=3)
            && (strlen(trim($_POST["accountE"]))>=3) 
            )
            {
                $aporte=new Aporte($this->adapter);
                $aporte->setAporteID($_POST["idxE"]);
			    $aporte->setValue($_POST["valueE"]);
                $aporte->setBank($_POST["bankE"]);
                $aporte->setAccount($_POST["accountE"]);
                $aporte->setTransactionID($valx);
            
                $save=$aporte->update(); // Manda a actualizar la moto en el modelo
                if ($save == TRUE)
                    {
                        $aporte->phpAlert("Aporte actualizado con éxito",$this->baseUrl("BandejaAdmins", "index")); // Alerta y redirige
                    }
                    else
                    {
                        $aporte->phpAlert("Error con la actualización. Interente nuevamente",$this->baseUrl("BandejaAdmins", "index")); // Alerta y redirige
                        
                    }  

            }
            else
            {
                $aportex = new Aportante($this->adapter);
                $aportex->phpAlert("Complete todos los campos para almacenar.",$this->baseUrl("BandejaAdmins", "index")); // Alerta y redirige
            }
        }
        else
            {
                $aportex = new Aportante($this->adapter);
                $aportex->phpAlert("Complete todos los campos para almacenar.",$this->baseUrl("BandejaAdmins", "index")); // Alerta y redirige
            }     
        //$this->redirect("BandejaAdmins", "index");  // COntrolador + Vista
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
                //Creamos un paorte
                 
                if((isset($_POST["aportanteID"]))&& (strlen(trim($_POST["value"]))>=1)
                && (strlen(trim($_POST["bank"]))>=3)
                && (strlen(trim($_POST["account"]))>=3) 
                )
                {
                    $aporte->setAportanteID($_POST["aportanteID"]);
                    $aporte->setValue($_POST["value"]);
                    $aporte->setType('T');
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
            else{
                $aportex = new Aportante($this->adapter);
            $aportex->phpAlert("Complete todos los campos para almacenar.",$this->baseUrl("BandejaAdmins", "index")); // Alerta y redirige
            }
            
                
            }
            else{
                $aportex = new Aportante($this->adapter);
            $aportex->phpAlert("Complete todos los campos para almacenar.",$this->baseUrl("BandejaAdmins", "index")); // Alerta y redirige
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
