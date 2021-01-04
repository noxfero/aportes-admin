<?php
/* ARCHIVO: Moto.php: 
   TIPO: Modelo - Clase (hereda)
   CONTENIDO: Clase Moto, corresponde con el modelo de datos, tiene los métodos GET/SET y funciones para guardar/actualizar/borrar
   AUTORES: Carlos Muñoz - Carlos Román - Gabriel Villamagua - Miguel Yachimba
*/
class Aportante extends EntidadBase{
    private $aportanteID;
    private $cedula;
    private $names;
    private $lastnames;
    private $type;
    private $addressCountry;
    private $addressProvince;
    private $addressCity;
    private $addressStreet;
    private $phoneHome;
    private $phoneMobile;
    private $email;
    private $isActive;
    private $originProvince;
    private $originCity;
    
    public function __construct($adapter) {
        $table="aportante";
        parent::__construct($table,$adapter);
    }
    
    	public function getAportanteID(){
		return $this->aportanteID;
	}

	public function setAportanteID($aportanteID){
		$this->aportanteID = $aportanteID;
	}

	public function getCedula(){
		return $this->cedula;
	}

	public function setCedula($cedula){
		$this->cedula = $cedula;
	}

	public function getNames(){
		return $this->names;
	}

	public function setNames($names){
		$this->names = $names;
	}

	public function getLastnames(){
		return $this->lastnames;
	}

	public function setLastnames($lastnames){
		$this->lastnames = $lastnames;
	}

	public function getType(){
		return $this->type;
	}

	public function setType($type){
		$this->type = $type;
	}

	public function getAddressCountry(){
		return $this->addressCountry;
	}

	public function setAddressCountry($addressCountry){
		$this->addressCountry = $addressCountry;
	}

	public function getAddressProvince(){
		return $this->addressProvince;
	}

	public function setAddressProvince($addressProvince){
		$this->addressProvince = $addressProvince;
	}

	public function getAddressCity(){
		return $this->addressCity;
	}

	public function setAddressCity($addressCity){
		$this->addressCity = $addressCity;
	}

	public function getAddressStreet(){
		return $this->addressStreet;
	}

	public function setAddressStreet($addressStreet){
		$this->addressStreet = $addressStreet;
	}

	public function getPhoneHome(){
		return $this->phoneHome;
	}

	public function setPhoneHome($phoneHome){
		$this->phoneHome = $phoneHome;
	}

	public function getPhoneMobile(){
		return $this->phoneMobile;
	}

	public function setPhoneMobile($phoneMobile){
		$this->phoneMobile = $phoneMobile;
	}

	public function getEmail(){
		return $this->email;
	}

	public function setEmail($email){
		$this->email = $email;
	}

	public function getIsActive(){
		return $this->isActive;
	}

	public function setIsActive($isActive){
		$this->isActive = $isActive;
	}

	public function getOriginProvince(){
		return $this->originProvince;
	}

	public function setOriginProvince($originProvince){
		$this->originProvince = $originProvince;
	}

	public function getOriginCity(){
		return $this->originCity;
	}

	public function setOriginCity($originCity){
		$this->originCity = $originCity;
	}

    //Registra una nueva moto (para un usuario)
    public function save(){
        $query="INSERT INTO aportante (cedula, names, lastnames, type, \"addressCountry\", \"addressProvince\", \"addressCity\", \"addressStreet\", \"phoneHome\", \"phoneMobile\", email, \"isActive\", \"originProvince\", \"originCity\")
                VALUES(
                       '".$this->cedula."',
                       '".$this->names."',
                       '".$this->lastnames."',
                       '".$this->type."',
                       '".$this->addressCountry."',
					   '".$this->addressProvince."',
                       '".$this->addressCity."',
                       '".$this->addressStreet."',
                       '".$this->phoneHome."',
                       '".$this->phoneMobile."',
					   '".$this->email."',
                       '".$this->isActive."',
                       '".$this->originProvince."',
                       '".$this->originCity."');";
        $save=$this->db()->query($query);
        //$this->db()->error;
        return $save;
    }

    //Actualiza los datos de la moto
    public function update(){
        $query="UPDATE aportante SET cedula='$this->cedula', names='$this->names', lastnames='$this->lastnames', \"phoneHome\"='$this->phoneHome', \"phoneMobile\"='$this->phoneMobile', email='$this->email' WHERE \"aportanteID\"='$this->aportanteID'";
        $save=$this->db()->query($query);
        //$this->db()->error;
        return $save;
        
    }

}
?>