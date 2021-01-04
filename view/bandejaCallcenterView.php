<!DOCTYPE HTML>
<html lang="es">
 <!-- ARCHIVO: bandejaUserView.php: 
   TIPO: Vista
   CONTENIDO: Vista del Menú del usuario
   AUTORES: Diego Peralta - Carlos Román
 -->
    <head>
        <meta charset="utf-8"/>
        <title>Administrador de Aportes - Unión por la Esperanza</title>
        <!-- Librerías externas -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="./estilo/estilo.css">

        <!-- Script con jQuery utilizado para agregar de manera dinámica N nuevas motocicletas"-->
        <script type="text/javascript"> 
		
        </script>
    </head>
    <body>
	<div class="bg">
	<div class="container">
		<div class="row">
			<div class="col-sm-4">			
			</div>
			<div class="col-sm-4">
				<h3 class="text-center">Usuario de Call Center</h3>
				
			</div>
			<div class="col-sm-4" style="vertical-align:middle">
				<br/>
				<a href="<?php echo $helper->url("Sesiones","index"); ?>" class="btn btn-danger right">Salir</a>
			
			</div>
		</div>
		
		<?php
    if (isset($_SESSION['message']) && $_SESSION['message'])
    {
      printf('<b>%s</b>', $_SESSION['message']);
      unset($_SESSION['message']);
    }
  ?>
      
        <div class="col-sm-12">
			<h3>APORTES - Registrados (Pendientes cruzar con el banco)</h3>
            <hr/>
        </div>
		<form action="<?php echo $helper->url("BandejaCallcenters","editarAporte"); ?>" method="post" class="col-sm-12 justify-content-center">
        <section class="col-sm-12 moto">
            <?php 
             //Carga el array que contiene MisCitas en una tabla siempre y cuando haya más de un registro
			 
			  $tab1 = 20;
			 $display1a="inline";
			 $display1b ="inline";
			 if(isset($_POST["tab1"]))
			 {
					$tab1 = $_POST["tab1"];
					if(isset($_POST["paginar1a"]))
					{
						$tab1 = $tab1 - 20;
						if ($tab1<0)
						{
							$tab1 =  20;;
							$display1a="none";
						}
						else{$display1a="inline";}
					}
					else if(isset($_POST["paginar1b"]))
					{
						$tab1 = $tab1 + 20;	
						if (isset($allMisAportes))
						{
							if (count($allMisAportes)<20)
							{
							   $tab1 = $tab1 - 40;
							   $display1b="none";
							}
						}
						else{$display1b="inline";}
					}	
			 }
			 
			 
             if (isset($allMisAportes) && count($allMisAportes)>=1)
             {
                echo '<table class="table">
                <thead>
                  <tr>
                    <th scope="col">Aporte</th>
                    <th scope="col">Aportante</th>
                    <th scope="col">Valor</th>
                    <th scope="col">Banco</th>
                    <th scope="col">Cuenta</th>
                    <th scope="col">Transacción</th>
                    <th scope="col">Fecha</th>
					<th scope="col">Validada Banco</th>
                    <th scope="col"></th>
                  </tr>
                </thead>
                <tbody>';
				$editMode = false;
                $thisId = "-1";
				$idUpd = "0";
				if(isset($_GET["datosx"]))
                {
                    $thisId = $_GET["idx"];
                }
				$display="block";
				$dir =  $helper->url("BandejaCallcenters","index");
                foreach($allMisAportes as $aporte) {
                    // Directorios usados para redireccionar
                   
					if ($thisId != $aporte->aporteID) // Solo lista los aportantes
                    {
                    echo '<tr><th scope="row">'.$aporte->aporteID.'</th>
                    <td>'.$aporte->aportanteID.'</td>
					<td>'.$aporte->value.'</td>
                     <td>'.$aporte->bank.'</td>
                     <td>'.$aporte->account.'</td>
                     <td>'.$aporte->transactionID.'</td>
					 <td>'.$aporte->registeredDate.'</td>
                     <td>'.$aporte->bankValidated.'</td>
                    <td class="right">
                    <a name="editar" href="'.$dir.'&idx='.$aporte->aporteID.'&datosx='.$aporte->value.' - '.$aporte->bank.' - '.$aporte->account.'" class="btn btn-info">Editar</a>
					</td></tr>'; 
					}
                    else{ //Carga los controles input necesarios para la edición
					echo '<tr><th scope="row">'.$aporte->aporteID.'</th>
                        <td>'.$aporte->aportanteID.'</td>
						<td><input type="text" name="valueE" value="'.$aporte->value.'" class="form-control" /></td>
						<td><input type="text" name="bankE" value="'.$aporte->bank.'" class="form-control" /></td>
                        <td><input type="text" name="accountE" value="'.$aporte->account.'" class="form-control"/></td>
						<td><input type="text" name="transactionE" value="'.$aporte->transactionId.'" class="form-control"/></td>
                        <td>'.$aporte->registeredDate.'</td>
                     <td>'.$aporte->bankValidated.'</td>
                        <td class="right">
                        <input type="submit" value="Actualizar" class="btn btn-danger" name="registrar"/>
                        </td></tr>';
                        $idUpd = $aporte->aporteID;
					}
                }
                echo '</tbody>
                </table>
                <input  type="hidden" name="idxE" value="'.$idUpd.'"/>';
            } else { echo "No tiene aún aportes regsitrados.<br/><br/>";} 
				echo '<input  type="hidden" name="tab1" value="'.$tab1.'"/>
				<button name="paginar1a"  type="submit" class="btn btn-success"  style="display:'.$display1a.'">Anteriores</button>
                 <button name="paginar1b"  type="submit" class="btn btn-success" style="display:'.$display1b.'">Siguientes</button>';
            ?>
        </section>
		</form>
		<br/>&nbsp;<br/>
		<br/>&nbsp;<br/>
        <div class="col-sm-12">
			<h3>APORTES - Validados (Cruzados con el banco)</h3>
            <hr/>
        </div>
		
		<form action="<?php echo $helper->url("BandejaCallcenters","enviarCorreo"); ?>" method="post" class="col-sm-12 justify-content-center">
        <section class="col-sm-12 moto">
            <?php 
             //Carga el array que contiene MisCitas en una tabla siempre y cuando haya más de un registro
			  $tab2 = 20;
			 $display2a="inline";
			 $display2b ="inline";
			 if(isset($_POST["tab2"]))
			 {
					$tab2 = $_POST["tab2"];
					if(isset($_POST["paginar2a"]))
					{
						$tab2 = $tab2 - 20;
						if ($tab2<0)
						{
							$tab2 =  20;;
							$display2a="none";
						}
						else{$display2a="inline";}
					}
					else if(isset($_POST["paginar2b"]))
					{
						$tab2 = $tab2 + 20;	
						if (isset($allMisAportes2))
						{
							if (count($allMisAportes2)<20)
							{
							   $tab2 = $tab2 - 40;
							   $display2b="none";
							}
						}
						else{$display2b="inline";}
					}	
			 }
             if (isset($allMisAportes2) && count($allMisAportes2)>=1)
             {
                echo '<table class="table">
                <thead>
                  <tr>
                    <th scope="col">Aporte</th>
                    <th scope="col">Aportante</th>
                    <th scope="col">Valor</th>
                    <th scope="col">Banco</th>
                    <th scope="col">Cuenta</th>
                    <th scope="col">Transacción</th>
                    <th scope="col">Fecha</th>
					<th scope="col">Validada Banco</th>
					<th scope="col">Solicitud enviada</th>
                    <th scope="col"></th>
                  </tr>
                </thead>
                <tbody>';
				$editMode = false;
                $thisId = "-1";
				$idUpd = "0";
				if(isset($_GET["datosx"]))
                {
                    $thisId = $_GET["idx"];
                }
				$display="block";
				$dir =  $helper->url("BandejaCallcenters","index");
                foreach($allMisAportes2 as $aporte) {
                    // Directorios usados para redireccionar
                    $cedula = explode("-",$aporte->aportanteID);
                    $ced = rtrim($cedula[0]);
                    $visValidar = "inline";
					if ($thisId != $aporte->aporteID) // Solo lista los aportantes
                    {
                        if ($aporte->callCenterValidated =="SI")
                        {
                            $visValidar ="none";
                        }
                    echo '<tr><th scope="row">'.$aporte->aporteID.'</th>
                    <td>'.$aporte->aportanteID.'</td>
					<td>'.$aporte->value.'</td>
                     <td>'.$aporte->bank.'</td>
                     <td>'.$aporte->account.'</td>
                     <td>'.$aporte->transactionID.'</td>
					 <td>'.$aporte->registeredDate.'</td>
                     <td>'.$aporte->bankValidated.'</td>
					 <td>'.$aporte->callCenterValidated.'</td>
                    <td class="right">
                    <a name="formulario" href="'.'https://aportes.andresarauz.ec/api/v1/pdf/formulario/'.$aporte->aporteID.'" class="btn btn-warning">Solicitud</a>
                    <a name="cedula" href="'.'https://aportes.andresarauz.ec/api/v1/upload/download/cedula/'.$ced.'" class="btn btn-success">Cédula</a>
                  
					</td></tr>'; 
					}
                    else{ //Carga los controles input necesarios para la edición
					echo '<tr><th scope="row">'.$aporte->aporteID.'</th>
                        <td>'.$aporte->aportanteID.'</td>
						<td>'.$aporte->value.'<input type="hidden" name="aporteIDx" value="'.$aporte->aporteID.'" class="form-control" /></td>
						<td>'.$aporte->bank.'<input type="hidden" name="aportanteIDx" value="'.$aporte->aportanteID.'" class="form-control" /></td>
                        <td>'.$aporte->account.'<input type="hidden" name="isActivex" value="'.$aporte->isActive.'" class="form-control"/></td>
						<td>'.$aporte->transactionID.'</td>
                        <td>'.$aporte->registeredDate.'</td>
                     <td>'.$aporte->bankValidated.'</td>
					 <td>'.$aporte->callCenterValidated.'</td>
                        <td class="right">
                        <input type="submit" value="Enviar Correo" class="btn btn-danger" name="registrar"/>
                        </td></tr>';
                        $idUpd = $aporte->aporteID;
					}
                }
                echo '</tbody>
                </table>
                <input  type="hidden" name="idxE" value="'.$idUpd.'"/>';
            } else { echo "No tiene aún aportes validados por el banco.<br/><br/>";} 
			echo '<input  type="hidden" name="tab2" value="'.$tab2.'"/>
				<button name="paginar2a"  type="submit" class="btn btn-success"  style="display:none">Anteriores</button>
                 <button name="paginar2b"  type="submit" class="btn btn-success" style="display:none">Siguientes</button>';
            ?>
        </section>
		</form>
		
		
		<br/>&nbsp;<br/>
		<br/>&nbsp;<br/>
        <div class="col-sm-12">
			<h3>APORTES - Sin registrar (Transferencias bancarias sin formulario en sistema)</h3>
            <hr/>
        </div>
		
		<form action="<?php echo $helper->url("BandejaCallcenters","index"); ?>" method="post" class="col-sm-12 justify-content-center">
        <section class="col-sm-12 moto">
            <?php 
             //Carga el array que contiene MisCitas en una tabla siempre y cuando haya más de un registro
			 
			 //Para manejar la paginación
			 $tab3 = 20;
			 $display3a="inline";
			 $display3b ="inline";
			 if(isset($_POST["tab3"]))
			 {
					$tab3 = $_POST["tab3"];
					if(isset($_POST["paginar3a"]))
					{
						$tab3 = $tab3 - 20;
						if ($tab3<0)
						{
							$tab3 =  20;;
							$display3a="none";
						}
						else{$display3a="inline";}
					}
					else if(isset($_POST["paginar3b"]))
					{
						$tab3 = $tab3 + 20;	
						if (isset($allMisAportes3))
						{
							if (count($allMisAportes3)<20)
							{
							   $tab3 = $tab3 - 40;
							   $display3b="none";
							}
						}
						else{$display3b="inline";}
					}	
			 }
			 
             if (isset($allMisAportes3) && count($allMisAportes3)>=1)
             {
                echo '<table class="table">
                <thead>
                  <tr>
                    <th scope="col">Transacción</th>
                    <th scope="col">Valor</th>
                    <th scope="col">Cédula</th>
                    <th scope="col">Banco</th>
                    <th scope="col">Cuenta Origen</th>
                    <th scope="col">Fecha Transacción</th>
                    
                  </tr>
                </thead>
                <tbody>';
				$editMode = false;
                $thisId = "-1";
				$idUpd = "0";
				
				
				if(isset($_GET["datosx"]))
                {
                    $thisId = $_GET["idx"];
                }
				$display="block";
				$dir =  $helper->url("BandejaCallcenters","index");
                foreach($allMisAportes3 as $payment) {
                    // Directorios usados para redireccionar
                   
					
                    echo '<tr><th scope="row">'.$payment->transactionID.'</th>
                    <td>'.$payment->value.'</td>
					<td>'.$payment->cedula.'</td>
                     <td>'.$payment->bank.'</td>
                     <td>'.$payment->account.'</td>
					 <td>'.$payment->registeredDate.'</td>
                    </tr>'; 
					
                }
                echo '</tbody>
                </table>';
				
            } else { echo "No tiene aún aportes validados por el banco.<br/><br/>";}
				echo '<input  type="hidden" name="tab3" value="'.$tab3.'"/>
				<button name="paginar3a"  type="submit" class="btn btn-success"  style="display:'.$display3a.'">Anteriores</button>
                 <button name="paginar3b"  type="submit" class="btn btn-success" style="display:'.$display3b.'">Siguientes</button>';
            ?>
        </section>
		</form>
		  
        
        <footer class="col-sm-12 text-center">
            <hr/>
            Administrador de Aportes - Unión por la Esperanza | Copyright &copy; <?php echo  date("Y"); ?>
		   <br/><br/>
        </footer>
		</div>
		</div>
    </body>
</html>