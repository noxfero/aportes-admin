<!DOCTYPE HTML>
<html lang="es">
 <!-- ARCHIVO: loginView.php: 
   TIPO: Vista
   CONTENIDO: Vista del Login
   AUTORES: Diego Peralta - Carlos Román
 -->
    <head>
        <meta charset="utf-8"/>
        <title>Administrador de Aportes - Unión por la Esperanza</title>
        <!-- Librerías externas -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="./estilo/estilo.css">
    </head>
    <body>
	<div class="bg">
	<div class="container">
        <!-- Formulario  cuyo post hará un llamado al controlador "Sesiones", con la acción "iniciar"-->
        <form action="<?php echo $helper->url("Sesiones","iniciar"); ?>" method="post" class="col-sm-12 justify-content-center">

			<h3>Administrador de Aportes - Unión por la Esperanza</h3>
            <hr/>
            <br/>&nbsp;<br/>
            <div class="row"> 
                <div class="col-sm-4"> 
				</div>
				<div class="col-sm-4 text-center"> 
                <h4>Inicio de sesión</h4>
                </div>
                <div class="col-sm-4"> 
				</div>
			</div>
			<div class="row"> 
                <div class="col-sm-4"> 
				</div>
				<div class="col-sm-4"> 
                    <br/>
					Usuario: <input type="text" name="usuario" class="form-control"/>
                </div>
                <div class="col-sm-4"> 
				</div>
			</div>
            <div class="row"> 
            <div class="col-sm-4"> 
				</div>
				<div class="col-sm-4"> 
                    <br/>
					Contraseña: <input type="password" name="password" class="form-control"/>
                </div>
                <div class="col-sm-4"> 
				</div>
				
            </div>
            <div class="row"> 
            <div class="col-sm-4"> 
				</div>
				<div class="col-sm-4 text-center"> 
                    <br/>
                    <!-- Botones para iniciar sesión o registrarse -->
                    <input type="submit" value="Ingresar" class="btn btn-primary" name="login" value="login"/>
                   <!-- <input type="submit" value="Registrarse" class="btn btn-info" name="registrar" value="registrar"/>-->
                </div>
                <div class="col-sm-4"> 
				</div>
				
            </div>
        </form>
        <br/>&nbsp;<br/>
        <br/>&nbsp;<br/>
        <!-- Instrucciones de usuario y contraseñas usados para el ejemplo -->
        <br/>&nbsp;<br/>
		<br/>&nbsp;<br/>
        <br/>&nbsp;<br/>
        <br/>&nbsp;<br/>

        <footer class="col-sm-12 text-center">
            <hr/>
           Administrador de Aportes - Unión por la Esperanza | Copyright &copy; <?php echo  date("Y"); ?>
		   <br/><br/>
        </footer>
		</div>
		</div>
    </body>
</html>