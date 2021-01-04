<!DOCTYPE HTML>
<html lang="es">
 <!-- ARCHIVO: bandejaUserView.php: 
   TIPO: Vista
   CONTENIDO: Vista del Menú del usuario
   AUTORES: Carlos Muñoz - Carlos Román - Gabriel Villamagua - Miguel Yachimba
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
				<h3 class="text-center">Usuario Digitador</h3>
			</div>
			<div class="col-sm-4" style="vertical-align:middle">
				<br/>
				<a href="<?php echo $helper->url("Sesiones","index"); ?>" class="btn btn-danger right">Salir</a>
			
			</div>
		</div>
		
		<div class="form-group"> 
                     <!-- Formulario  cuyo post hará un llamado al controlador "BandejaUsers", con la acción "agregarMoto"--> 
                     <form name="add_name" id="add_name" action="<?php echo $helper->url("BandejaAdmins","agregaAportantes"); ?>" method="post">  
                     Registre un nuevo aportante

                          <div class="table-responsive">  
                               <table class="table" id="dynamic_field"> 
                                    <!-- Listado de inputs necesarios para capturar la información de una nueva moto --> 
                                    <tr>  
                                         <td><input type="text" name="cedula[]" placeholder="Cédula" class="form-control name_list" /></td>
                                         <td><input type="text" name="names[]" placeholder="Nombres" class="form-control name_list" /></td> 
                                         <td><input type="text" name="lastnames[]" placeholder="Apellidos" class="form-control name_list" /></td>  
                                         <td><input type="text" name="addressCountry[]" placeholder="País de Residencia" class="form-control name_list" /></td>  
										 
                                    </tr> 
									<tr>
										<td><input type="text" name="addressProvince[]" placeholder="Provincia de Residencia" class="form-control name_list" /></td>                                           
										<td><input type="text" name="addressCity[]" placeholder="Ciudad de residencia" class="form-control name_list" /></td>
                                         <td><input type="text" name="addressStreet[]" placeholder="Calle de residencia" class="form-control name_list" /></td> 
                                         <td><input type="text" name="phoneHome[]" placeholder="Teléfono convencional" class="form-control name_list" /></td>  
									</tr>
									<tr>
										 
                                         <td><input type="text" name="phoneMobile[]" placeholder="Teléfono móvil" class="form-control name_list" /></td>  
										 <td><input type="text" name="email[]" placeholder="Correo electrónico" class="form-control name_list" /></td>
										 <td><input type="text" name="originProvince[]" placeholder="Provincia de Origen" class="form-control name_list" /></td>
										 <td><input type="text" name="originCity[]" placeholder="Ciudad de origen" class="form-control name_list" /></td>
										<td style="vertical-align: middle; display:none"><button type="button" name="add" id="add" class="btn btn-success right" style="display:none">Agregar otro aportante</button></td>  
									</tr>
                               </table>
                               <!-- Botón que ejecuta submit para este formulario"-->  
                               <input type="submit" class="btn btn-primary" name="submit" id="submit" class="btn btn-info" value="Registrar aportante" />  
                          </div>  
                     </form>  
                </div>  
		
		<br/>&nbsp;<br/>
        <div class="col-sm-12">
			<h3>APORTANTES - Registrados</h3> 
            <hr/>
        </div>
        <!-- Formulario  cuyo post hará un llamado al controlador "BandejaUsers", con la acción "editarMoto"-->
        <form action="<?php echo $helper->url("BandejaAdmins","editarAportante"); ?>" method="post" class="col-sm-12 justify-content-center">
        <section class="col-sm-12 moto">
            <?php 
            //Carga el array que contiene MisMotos en una tabla siempre y cuando haya más de un registro
             if (isset($allMisAportantes) && count($allMisAportantes)>=1)
             {
                echo '<table class="table">
                <thead>
                  <tr>
                    <th scope="col">Cedula</th>
                    <th scope="col">Nombres</th>
                    <th scope="col">Apellidos</th>      
					<th scope="col">Teléfono convencional</th>
					<th scope="col">Teléfono celular</th>
					<th scope="col">Correo</th>
                    <th scope="col"></th>
                  </tr>
                </thead>
                <tbody>'; 
                $editMode = false;
                $thisId = "-1";
                if(isset($_GET["datos2"]))
                {
                    $thisId = $_GET["id2"];
                }
                else
                {}
                 // Directorios usados para redireccionar
                $dir =  $helper->url("BandejaAdmins","borrarMoto");
                $dir2 =  $helper->url("BandejaAdmins","index");
                $idUpd = "0";
                foreach($allMisAportantes as $aportante) { // Para toda la lista
                    
                    if ($thisId != $aportante->aportanteID) // Solo lista los aportantes
                    {
                        echo '<tr><th scope="row">'.$aportante->cedula.'</th>
                        <td>'.$aportante->names.'</td>
                        <td>'.$aportante->lastnames.'</td>
                        <td>'.$aportante->phoneHome.'</td>
						<td>'.$aportante->phoneMobile.'</td>
						<td>'.$aportante->email.'</td>
                        <td class="right">
                        <a name="editar" href="'.$dir2.'&id2='.$aportante->aportanteID.'&datos2='.$aportante->cedula.' - '.$aportante->names.' - '.$aportante->lastnames.' - '.$aportante->phoneHome.' - '.$aportante->phoneMobile.' - '.$aportante->email.'" class="btn btn-info">Editar</a>
                        <a name="agendar" onclick="myFunction()" href="'.$dir2.'&id='.$aportante->aportanteID.'&datos='.$aportante->cedula.' - '.$aportante->names.' - '.$aportante->lastnames.' - '.$aportante->email.'" class="btn btn-primary btn_agendar">Agregar Aporte</a>
                        
                        </td></tr>';
                    }
                    else{ //Carga los controles input necesarios para la edición
                        echo '<tr><th scope="row"><input type="text" name="cedulaE" value="'.$aportante->cedula.'" class="form-control"/></th>
                        <td><input type="text" name="namesE" value="'.$aportante->names.'" class="form-control" /></td>
                        <td><input type="text" name="lastnamesE" value="'.$aportante->lastnames.'" class="form-control"/></td>
                        <td><input type="text" name="phoneHomeE" value="'.$aportante->phoneHome.'" class="form-control"/></td>
						<td><input type="text" name="phoneMobileE" value="'.$aportante->phoneMobile.'" class="form-control"/></td>
						<td><input type="text" name="emailE" value="'.$aportante->email.'" class="form-control"/></td>
                        <td class="right">
                        <input type="submit" value="Actualizar" class="btn btn-danger" name="registrar"/>
                        </td></tr>';
                        $idUpd = $aportante->aportanteID;
                    }
                     
                }
                echo '</tbody>
                </table>
                <input  type="hidden" name="idE" value="'.$idUpd.'"/>'; 
            } else { echo "No tiene aún aportantes registrados. Debe agregarlos.<br/><br/>";} 
            ?>
        </section>
        </form>
        
        
		<br/>&nbsp;<br/>
		<div id="divAgendar"> 
          <!-- Formulario  cuyo post hará un llamado al controlador "BandejaUsers", con la acción "agregaCitas"-->
          <form id="form-cita" action="<?php echo $helper->url("BandejaAdmins","agregaAportes"); ?>" method="post" class="col-sm-12 justify-content-center">
			Registre un nuevo aporte
			
			
			<div class="row"> 
                
				<div class="col-sm-8">
                    <!-- Recupera los datos de la moto para la cita -->
                    <input type="text" name="aportanteID" value="<?php  if(isset($_GET["id"])){echo ($_GET["id"]);} ?>" class="form-control" style="display:none" readonly/>
                    Aportante: <input type="text" name="aportante" value="<?php  if(isset($_GET["id"])){echo ($_GET["datos"]);} ?>" class="form-control" readonly/>
                    
                </div>
                <div class="col-sm-2"> 
				</div>
			</div>
            <div class="row"> 
            
				
                <div class="col-sm-2"> 
				Valor: <input type="text" name="value" id="value" class="form-control" />
				</div>
				<div class="col-sm-2"> 
				Banco: <input type="text" name="bank" id="bank" class="form-control" />
				</div>
				<div class="col-sm-2"> 
				Cuenta de Origen: <input type="text" name="account" id="account" class="form-control" />
				</div>
				<div class="col-sm-2"> 
				<br/>
					<input type="submit" value="Registrar" class="btn btn-primary" name="registrar"/>
				</div>
            </div>
            
            
            
        </form>
        
		</div>
		<br/>&nbsp;<br/>
        <div class="col-sm-12">
			<h3>APORTES - Registrados (Pendientes cruzar con el banco)</h3>
            <hr/>
        </div>
		<form action="<?php echo $helper->url("BandejaAdmins","editarAporte"); ?>" method="post" class="col-sm-12 justify-content-center">
        <section class="col-sm-12 moto">
            <?php 
             //Carga el array que contiene MisCitas en una tabla siempre y cuando haya más de un registro
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
				$dir =  $helper->url("BandejaAdmins","index");
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
						<td><input type="text" name="transactionE" value="'.$aporte->transactionID.'" class="form-control"/></td>
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