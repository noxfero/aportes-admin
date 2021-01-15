<?php
/* ARCHIVO: Moto.php: 
   TIPO: Modelo - Clase (hereda)
   CONTENIDO: Clase Moto, corresponde con el modelo de datos, tiene los métodos GET/SET y funciones para guardar/actualizar/borrar
   AUTORES: Carlos Muñoz - Carlos Román - Gabriel Villamagua - Miguel Yachimba
*/
class Aporte extends EntidadBase{
    private $aporteID;
	private $aportanteID;
    private $value;
    private $type;
    private $bank;
    private $account;
    private $transactionID;
    private $registeredDate;
    private $bankValidated;
    private $callCenterValidated;
    private $isPdfGenerated;
    private $isActive;
    
    public function __construct($adapter) {
        $table="aporte";
        parent::__construct($table,$adapter);
    }
    
    public function getAporteID(){
		return $this->aporteID;
	}

	public function setAporteID($aporteID){
		$this->aporteID = $aporteID;
	}

	public function getAportanteID(){
		return $this->aportanteID;
	}

	public function setAportanteID($aportanteID){
		$this->aportanteID = $aportanteID;
	}

	public function getValue(){
		return $this->value;
	}

	public function setValue($value){
		$this->value = $value;
	}

	public function getType(){
		return $this->type;
	}

	public function setType($type){
		$this->type = $type;
	}

	public function getBank(){
		return $this->bank;
	}

	public function setBank($bank){
		$this->bank = $bank;
	}

	public function getAccount(){
		return $this->account;
	}

	public function setAccount($account){
		$this->account = $account;
	}

	public function getTransactionID(){
		return $this->transactionID;
	}

	public function setTransactionID($transactionID){
		$this->transactionID = $transactionID;
	}

	public function getRegisteredDate(){
		return $this->registeredDate;
	}

	public function setRegisteredDate($registeredDate){
		$this->registeredDate = $registeredDate;
	}

	public function getBankValidated(){
		return $this->bankValidated;
	}

	public function setBankValidated($bankValidated){
		$this->bankValidated = $bankValidated;
	}

	public function getCallCenterValidated(){
		return $this->callCenterValidated;
	}

	public function setCallCenterValidated($callCenterValidated){
		$this->callCenterValidated = $callCenterValidated;
	}

	public function getIsPdfGenerated(){
		return $this->isPdfGenerated;
	}

	public function setIsPdfGenerated($isPdfGenerated){
		$this->isPdfGenerated = $isPdfGenerated;
	}

	public function getIsActive(){
		return $this->isActive;
	}

	public function setIsActive($isActive){
		$this->isActive = $isActive;
	}
	

    //Registra una nueva moto (para un usuario)
    public function save(){
        $query="INSERT INTO aporte (\"aportanteID\", value, type, bank, account, \"transactionId\", \"registeredDate\", \"bankValidated\", \"callCenterValidated\", \"isPdfGenerated\", \"isActive\")
                VALUES('".$this->aportanteID."',
                       '".$this->value."',
                       '".$this->type."',
                       '".$this->bank."',
                       '".$this->account."',
					   '".$this->transactionID."',
                       '".$this->registeredDate."',
                       '".$this->bankValidated."',
                       '".$this->callCenterValidated."',
                       '".$this->isPdfGenerated."',
                       '".$this->isActive."');";
        $save=$this->db()->query($query);
        //$this->db()->error;
        return $save;
    }

    //Actualiza los datos de la moto
    public function update(){
        //$query="UPDATE aporte SET value='$this->value', bank='$this->bank', account='$this->account', \"transactionId\"='$this->transactionID' WHERE \"aporteID\"='$this->aporteID'";
        $query="UPDATE aporte SET value='$this->value', bank='$this->bank', account='$this->account' WHERE \"aporteID\"='$this->aporteID'";
        $save=$this->db()->query($query);
        //$this->db()->error;
        return $save;
        
    }

    //Actualiza los datos de la moto
    public function updateValidacion(){
        $query="UPDATE aporte SET \"callCenterValidated\"='$this->callCenterValidated' WHERE \"aporteID\"='$this->aporteID'";
        $save=$this->db()->query($query);
        //$this->db()->error;
        return $save;
        
    }

	
	public function updateCruce(){
        //$query="UPDATE aporte SET value='$this->value', bank='$this->bank', account='$this->account', \"transactionId\"='$this->transactionID' WHERE \"aporteID\"='$this->aporteID'";
		$query ="UPDATE aporte set  \"transactionId\"='$this->transactionID', \"bank\"='$this->bank', \"registeredDate\"='$this->registeredDate', \"bankValidated\"='true' WHERE \"account\"='$this->account' AND \"value\"='$this->value' AND \"bankValidated\"='false' AND \"callCenterValidated\"='false' AND (\"transactionId\"= '0' OR \"transactionId\"='');";
        $save=$this->db()->query($query);
        //$this->db()->error;
        return $save;
        
    }
	
	
	//Obetiene las citas con estado dado el id de usuario 
    public function getMisAportes($col,$estado){
        $query=$this->db()->query("SELECT aporte.\"aporteID\", aportante.cedula ||  '-' || aportante.names || ' ' || aportante.lastnames as \"aportanteID\", aporte.value,
        aporte.bank, aporte.account, aporte.\"transactionId\" as \"transactionID\", aporte.\"registeredDate\",
        aportante.\"phoneHome\" ||  '-' || aportante.\"phoneMobile\" || '-' || aportante.email as \"type\", 
        CASE 
        WHEN (aporte.\"bankValidated\" = 'true') THEN 'SI' 
        WHEN (aporte.\"bankValidated\" = 'false') THEN 'AUN NO' ELSE 'N/A' END AS \"bankValidated\",
		CASE 
        WHEN (aporte.\"callCenterValidated\" = 'true') THEN 'SI' 
        WHEN (aporte.\"callCenterValidated\" = 'false') THEN 'AUN NO' ELSE 'N/A' END AS \"callCenterValidated\",
        aportante.email as \"isActive\"
                FROM aporte
                INNER JOIN aportante
                ON aporte.\"aportanteID\" = aportante.\"aportanteID\"
				WHERE ".$col." = '".$estado."' AND aporte.\"isActive\"='1'
				;");

        while($row = $query->fetchObject()) {
           $resultSet[]=$row;
        }
        if (!empty($resultSet))
        {
            return  $resultSet;
        }
        else
        {
            return NULL;
        }
    }
	
	//Obetiene las citas con estado dado el id de usuario 
    public function getMisAportesLimit($col,$estado,$order,$offset){
        $query=$this->db()->query("SELECT aporte.\"aporteID\", aportante.cedula ||  ' - ' || aportante.names || ' ' || aportante.lastnames as \"aportanteID\", aporte.value,
        aporte.bank, aporte.account, aporte.\"transactionId\" as \"transactionID\", aporte.\"registeredDate\",
        CASE 
        WHEN (aporte.\"bankValidated\" = 'true') THEN 'SI' 
        WHEN (aporte.\"bankValidated\" = 'false') THEN 'AUN NO' ELSE 'N/A' END AS \"bankValidated\",
		CASE 
        WHEN (aporte.\"isPdfGenerated\" = 'true') THEN 'SI' 
        WHEN (aporte.\"isPdfGenerated\" = 'false') THEN 'AUN NO' ELSE 'N/A' END AS \"isPdfGenerated\",
        aportante.email as \"isActive\"
		
                FROM aporte
                INNER JOIN aportante
                ON aporte.\"aportanteID\" = aportante.\"aportanteID\"
				WHERE ".$col." = '".$estado."' AND aporte.\"isActive\"='1' ORDER BY ".$order." DESC LIMIT 20 OFFSET ".$offset."
				;");

        while($row = $query->fetchObject()) {
           $resultSet[]=$row;
        }
        if (!empty($resultSet))
        {
            return  $resultSet;
        }
        else
        {
            return NULL;
        }
    }


    
    //Obetiene las citas con estado dado el id de usuario 
    public function getAportesPorCedula($cedula){
        $query=$this->db()->query("SELECT aporte.\"aporteID\", 
        aportante.cedula ||  ' - ' || aportante.names || ' ' || aportante.lastnames as \"aportanteID\", 
        aportante.\"phoneHome\" ||  ' - ' || aportante.\"phoneMobile\" || ' - ' || aportante.email as \"type\", 
        aporte.value,
        aporte.bank, aporte.account, aporte.\"transactionId\" as \"transactionID\", aporte.\"registeredDate\",
        CASE 
        WHEN (aporte.\"bankValidated\" = 'true') THEN 'SI' 
        WHEN (aporte.\"bankValidated\" = 'false') THEN 'AUN NO' ELSE 'N/A' END AS \"bankValidated\",
		CASE 
        WHEN (aporte.\"callCenterValidated\" = 'true') THEN 'SI' 
        WHEN (aporte.\"callCenterValidated\" = 'false') THEN 'AUN NO' ELSE 'N/A' END AS \"callCenterValidated\",
        aportante.email as \"isActive\"
                FROM aporte
                INNER JOIN aportante
                ON aporte.\"aportanteID\" = aportante.\"aportanteID\"
				WHERE aportante.cedula = '".$cedula."' AND aporte.\"isActive\"='1'
				;");

        while($row = $query->fetchObject()) {
           $resultSet[]=$row;
        }
        if (!empty($resultSet))
        {
            return  $resultSet;
        }
        else
        {
            return NULL;
        }
    }
	
	public function contarCruceAportes(){
        $query=$this->db()->query("SELECT COUNT(*) as \"aporteID\" from aporte where \"bankValidated\" = 'false' and \"isActive\"='true'");

        while($row = $query->fetchObject()) {
           $resultSet[]=$row;
        }
        if (!empty($resultSet))
        {
            return  $resultSet;
        }
        else
        {
            return NULL;
        }
    }

}
?>