<?php
/* ARCHIVO: Moto.php: 
   TIPO: Modelo - Clase (hereda)
   CONTENIDO: Clase Moto, corresponde con el modelo de datos, tiene los métodos GET/SET y funciones para guardar/actualizar/borrar
   AUTORES: Diego PEralta - Carlos Román
*/
class Payment extends EntidadBase{
      private $paymentID;
    private $transactionID;
    private $value;
    private $cedula;
    private $bank;
    private $account;
    private $registeredDate;
    private $isMatched;
    private $isActive;
    private $fullname;
    
    public function __construct($adapter) {
        $table="payment";
        parent::__construct($table,$adapter);
    }
    
    public function getFullname(){
		return $this->fullname;
	}

	public function setFullname($fullname){
		$this->fullname = $fullname;
	}


    	public function getPaymentID(){
		return $this->paymentID;
	}

	public function setPaymentID($paymentID){
		$this->paymentID = $paymentID;
	}

	public function getTransactionID(){
		return $this->transactionID;
	}

	public function setTransactionID($transactionID){
		$this->transactionID = $transactionID;
	}

	public function getValue(){
		return $this->value;
	}

	public function setValue($value){
		$this->value = $value;
	}

	public function getCedula(){
		return $this->cedula;
	}

	public function setCedula($cedula){
		$this->cedula = $cedula;
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

	public function getRegisteredDate(){
		return $this->registeredDate;
	}

	public function setRegisteredDate($registeredDate){
		$this->registeredDate = $registeredDate;
	}

	public function getIsMatched(){
		return $this->isMatched;
	}

	public function setIsMatched($isMatched){
		$this->isMatched = $isMatched;
	}

	public function getIsActive(){
		return $this->isActive;
	}

	public function setIsActive($isActive){
		$this->isActive = $isActive;
	}
	

    //Registra una nueva moto (para un usuario)
    public function save(){
        $query="INSERT INTO payment (\"transactionID\", value, cedula, bank, account, \"registeredDate\", \"isMatched\", \"isActive\", \"fullname\")
                VALUES(
                       '".$this->transactionID."',
                       '".$this->value."',
                       '".$this->cedula."',
                       '".$this->bank."',
					   '".$this->account."',
                       '".$this->registeredDate."',
                       '".$this->isMatched."',
                       '".$this->isActive."',
                       '".$this->fullname."');";
        $save=$this->db()->query($query);
        //$this->db()->error;
        return $save;
    }

    //Actualiza los datos de la moto
    public function update(){
        $query="UPDATE aporte SET value='$this->value', bank='$this->bank', account='$this->account', \"transactionId\"='$this->transactionID' WHERE \"aporteID\"='$this->aporteID'";
        $save=$this->db()->query($query);
        //$this->db()->error;
        return $save;
        
    }
	
	public function updateMatch(){
		//$query ="UPDATE aporte set  \"transactionId\"='$this->transactionID', \"bank\"='$this->bank', \"registeredDate\"='$this->registeredDate', \"bankValidated\"='true' WHERE \"account\"='$this->account' AND \"value\"='$this->value' AND \"bankValidated\"='false' AND \"callCenterValidated\"='false' AND \"transactionId\"= '0';";
		$query ="UPDATE payment SET \"isMatched\"=true WHERE \"transactionID\" IN (select \"transactionId\" from aporte where \"bankValidated\"=true)";
        $save=$this->db()->query($query);
        //$this->db()->error;
        return $save;
        
    }
	
	
	//Obetiene las citas con estado dado el id de usuario 
    public function getMisAportes(){
        $query=$this->db()->query("SELECT aporte.\"aporteID\", aportante.cedula ||  ' - ' || aportante.names || ' ' || aportante.lastnames as \"aportanteID\", aporte.value,
aporte.bank, aporte.account, aporte.\"transactionId\" as \"transactionID\", aporte.\"registeredDate\",
        CASE 
        WHEN (aporte.\"bankValidated\" = 'true') THEN 'SI' 
        WHEN (aporte.\"bankValidated\" = 'false') THEN 'AUN NO' ELSE 'N/A' END AS \"bankValidated\"
                FROM aporte
                INNER JOIN aportante
                ON aporte.\"aportanteID\" = aportante.\"aportanteID\";");

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