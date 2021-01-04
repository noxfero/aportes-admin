<?php

require_once 'SimpleXLSX.php';
echo '<pre>';
$dato="";
$fecha="";
if ( $xlsx = SimpleXLSX::parse( 'Datos.xlsx' ) ) {
	
		   
	foreach ( $xlsx->rows() as $r => $row ) {
		
		if ($r > 0)
		{
			if ($row[5]!= 'Depósito')
			{
				$fecha = substr($row[3], 0, 19) ;
				$fecha = str_replace(".",":",$fecha);
				$fecha = substr_replace($fecha, " ", 10, 1);
					//echo $fecha.':'.$row[5].'|||'.$fecha .'<br/>';
					
				$dato = "UPDATE aporte set  \"transactionId\"='".$row[4]."', \"bank\"='".$row[14]."', \"registeredDate\"='".$fecha."', \"bankValidated\"='true' WHERE \"account\"='".$row[13]."' AND \"value\"='".$row[6]."' AND \"bankValidated\"='false' AND \"callCenterValidated\"='false' AND \"transactionId\"= 0;";
				echo $dato . '<br/>';
			}
		
		
		}
	}
} else {
	echo SimpleXLSX::parseError();
}
echo '</pre>';

?>