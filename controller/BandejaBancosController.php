<?php
/* ARCHIVO: BandejaUsersController.php: 
   TIPO: Controlador - Clase (hereda)
   CONTENIDO: Clase BandejaUsersController, contiene las acciones para gestionar las operaciones que realiza el usuario (cliente)
   AUTORES: Diego Peralta - Carlos Román
*/
class BandejaBancosController extends ControladorBase{
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
		$payment=new Payment($this->adapter);
        $usrId =  $_SESSION['miUserId'];
		$offset1 = 0;
		if (isset($_POST["tab1"]))
		{
			$offset1 = $_POST["tab1"];
		}
		$offset2 = 0;
		if (isset($_POST["tab2"]))
		{
			$offset2 = $_POST["tab2"];
		}
		$offset3 = 0;
		if (isset($_POST["tab3"]))
		{
			$offset3 = $_POST["tab3"];
		}
		
        //Conseguimos todos los usuarios
        //$allMisAportes=$aporte->getAllofOneConEstado('"isActive"','1','"bankValidated"','0');
		$allMisAportes=$aporte->getMisAportes('"bankValidated"','0','"regsteredDate"',$offset1);
	    $allMisAportes2=$aporte->getMisAportes('"bankValidated"','1','"regsteredDate"',$offset2);
		$allMisAportes3=$payment->getAllofOneConEstadoLimit('"isActive"','1','"isMatched"','0','"registeredDate"',$offset3);	

         //Cargamos la vista index y le pasamos valores
         $this->view("bandejaBanco",array(
            
            "allMisAportes"=>$allMisAportes,
			"allMisAportes2"=>$allMisAportes2,
			"allMisAportes3"=>$allMisAportes3
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
        $this->redirect("BandejaBancos", "index");  // COntrolador + Vista
    }
	
	//Edita los datos de una moto   
    public function procesarPagos(){ 
		require_once './core/SimpleXLSX.php';
		$dato="";
		$fecha="";
		$reg=0;
		$act=0;
		$count1=0;
		$aporte0=new Aporte($this->adapter);
		$porCruzar= $aporte0->contarCruceAportes();
		if (isset($porCruzar) && count($porCruzar)>=1)
             {
				 foreach($porCruzar as $aporte)
				 {
					 $count1 = $aporte->aporteID;
				 }
			 }
		
		if ( $xlsx = SimpleXLSX::parse( './uploads/Datos.xlsx' ) ) {
			   
	  foreach ( $xlsx->rows() as $r => $row ) {
		
		if ($r > 0)
		{
			if ($row[5]!= 'Depósito')
			{
				$fecha = substr($row[3], 0, 19) ;
				$fecha = str_replace(".",":",$fecha);
				$fecha = substr_replace($fecha, " ", 10, 1);
					//echo $fecha.':'.$row[5].'|||'.$fecha .'<br/>';
					
				$aporte=new Aporte($this->adapter);
				$aporte->setTransactionID($row[4]);
				$aporte->setBank($row[14]);
				$aporte->setRegisteredDate($fecha);
				$aporte->setValue($row[6]);
				$aporte->setAccount($row[13]);
				
				$save=$aporte->updateCruce(); // Manda a actualizar la moto en el modelo
				if ($save == TRUE)
				{
					$act = $act+1;
				}
				$reg = $reg+1;	
				//$dato = "UPDATE aporte set  \"transactionId\"='".$row[4]."', \"bank\"='".$row[14]."', \"registeredDate\"='".$fecha."', \"bankValidated\"='true' WHERE \"account\"='".$row[13]."' AND \"value\"='".$row[6]."' AND \"bankValidated\"='false' AND \"callCenterValidated\"='false' AND \"transactionId\"= '0';";
				//echo strval($save) . '<br/>';
				try{
				$payment=new Payment($this->adapter);
				$payment->setTransactionID($row[4]);
				$payment->setValue($row[6]);
				$payment->setCedula($row[10]);
				$payment->setBank($row[14]);
				$payment->setAccount($row[13]);
				$payment->setRegisteredDate($fecha);
				$payment->setIsMatched('false');
				$payment->setIsActive('true');
				$save=$payment->save();
				}
				catch (Exception $e) {
					//echo 'Excepción capturada: ',  $e->getMessage(), "\n";
				}
				
			}
		
		}
		}
		} else {
		echo SimpleXLSX::parseError();
		}
			$count2=0;
		$aporte1=new Aporte($this->adapter);
		$porCruzar1= $aporte1->contarCruceAportes();
		if (isset($porCruzar1) && count($porCruzar1)>=1)
             {
				 foreach($porCruzar1 as $aporte)
				 {
					 $count2 = $aporte->aporteID;
				 }
			 }
		$payment0=new Payment($this->adapter);
	    $save=$payment0->updateMatch();
	
		$aporte1->phpAlert('Registros econtrados en excel: ' .$reg 
		.'\nRegistros procesados desde el excel: ' .$act
		.'\nAportes pendientes por cruzar antes del cruce: ' .$count1
		.'\nAportes pendientes de cruzar luego del cruce: ' .$count2
		.'\nTOTAL CRUZADOS en esta carga: ' .($count1 - $count2),
		$this->baseUrl("BandejaBancos", "index")); // Alerta y redirige
        //$this->redirect("BandejaBancos", "index");  // COntrolador + Vista
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
        $this->redirect("BandejaBancos", "index");  // COntrolador + Vista
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
                    $aporte->phpAlert("Aporte creado con éxito",$this->baseUrl("BandejaBancos", "index")); // Alerta y redirige
                }
                else
                {
                    $aporte->phpAlert("Error con el registro. Interente nuevamente",$this->baseUrl("BandejaBancos", "index")); // Alerta y redirige
                    
                }
                
            }

        }
        else
        {
            $aporte->phpAlert("Debe seleccionar priemro un aportante para poder guardar el aporte.",$this->baseUrl("BandejaBancos", "index")); // Alerta y redirige
        }
        
        
    }

    public function enviarCorreo(){
        session_start();
        require_once './core/mail.php';
        $usrId= $_SESSION['miUserId'];
        $aporte=new Aporte($this->adapter);
        if(isset($_POST["aporteIDx"])){ // Si hay datos
            if(isset($_POST["isActivex"]) && isset($_POST["aportanteIDx"])){
               
                $save = enviarMail($_POST["isActivex"],$_POST["aportanteIDx"],$_POST["aporteIDx"]);
                if ($save == TRUE)
                {
                    $aporte->phpAlert("Correo enviado éxito a ".$_POST["isActivex"] ,$this->baseUrl("BandejaBancos", "index")); // Alerta y redirige
                    $aporte=new Aporte($this->adapter);
                    $aporte->setAporteID($_POST["aporteIDx"]);
                    $aporte->setCallCenterValidated('true');
                    $save=$aporte->updateValidacion(); 

                }
                else
                {
                    $aporte->phpAlert("Error con el envío de correo. Interente nuevamente",$this->baseUrl("BandejaBancos", "index")); // Alerta y redirige
                    
                }
                
            }

        }
        else
        {
            $aporte->phpAlert("Seleccione datos.",$this->baseUrl("BandejaBancos", "index")); // Alerta y redirige
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
