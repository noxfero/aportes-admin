<!DOCTYPE HTML>
<html lang="es">
 <!-- ARCHIVO: registroView.php: 
   TIPO: Vista
   CONTENIDO: Vista del Registro
   AUTORES: Diego Peralta - Carlos Román
 -->
<head>
    <meta charset="utf-8" />
    <title>Registro Taller Motos - UNIR-CSW - Aplicación PHP POO MVC</title>
    <!-- Librerías externas -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="./estilo/estilo.css">
</head>

<body>
    <div class="bg">
        <div class="container">
             <!-- Formulario  cuyo post hará un llamado al controlador "Usuarios", con la acción "crear"-->
            <form action="<?php echo $helper->url("Usuarios","crear"); ?>" method="post"
                class="col-sm-12 justify-content-center">

                <h3>Registrar usuario nuevo</h3>
                <hr />
                <div class="row">
                    <div class="col-sm-4">
                    </div>
                    <div class="col-sm-4 text-center">
                        <h4>Ingrese sus datos</h4>
                    </div>
                    <div class="col-sm-4">
                    </div>
                </div>
                 <!-- Inputs necesarios para el registro, se hace validaciones con expresiones regulares en cada uno-->
                <div class="row">
                    <div class="col-sm-4">
                    </div>
                    <div class="col-sm-4">
                        <br />
                        Nombre: <input type="text" name="nombre" class="form-control" required=""
                            title="Formato de nombre incorrecto" pattern="[a-zA-Z0-9\s]{3,30}"
                            oninvalid="this.setCustomValidity('Nombre incorrecto')" oninput="setCustomValidity('')" />
                    </div>
                    <div class="col-sm-4">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                    </div>
                    <div class="col-sm-4">
                        <br />
                        Apellido: <input type="text" name="apellido" class="form-control" required=""
                            title="Formato de apellido incorrecto" pattern="[a-zA-Z0-9\s]{3,30}"
                            oninvalid="this.setCustomValidity('Apellido incorrecto')" oninput="setCustomValidity('')" />
                    </div>
                    <div class="col-sm-4">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                    </div>
                    <div class="col-sm-4">
                        <br />
                        Teléfono: <input type="text" name="telefono" class="form-control" required=""
                            pattern="[0-9]{10}" oninvalid="this.setCustomValidity('Formato de teléfono no válido')"
                            oninput="setCustomValidity('')" />
                    </div>
                    <div class="col-sm-4">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                    </div>
                    <div class="col-sm-4">
                        <br />
                        Nombre de usuario: <input type="text" name="email"
                            pattern="[a-zA-Z0-9.\s]{3,30}"
                            required="" oninvalid="this.setCustomValidity('Formato de correo electrónico incorrecto')"
                            oninput="setCustomValidity('')" class="form-control" />
                    </div>
                    <div class="col-sm-4">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                    </div>
                    <div class="col-sm-4">
                        <br />
                        Contraseña: <input type="password" name="password" class="form-control" required=""
                            pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                            oninvalid="this.setCustomValidity('Ingresar al menos un número, una letra mayúscula. Longitud mínima de 8 caracteres')"
                            oninput="setCustomValidity('')" />
                    </div>
                    <div class="col-sm-4">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                    </div>
                    <div class="col-sm-4 text-center">
                        <br />
                         <!-- Botón que ejecuta submit para este formulario"-->
                        <input type="submit" value="Registrar" class="btn btn-success" name="registrar" />

                    </div>
                    <div class="col-sm-4">
                    </div>

                </div>
            </form>
            <br />&nbsp;<br />
            <br />&nbsp;<br />
            <br />&nbsp;<br />
            <br />&nbsp;<br />
            <footer class="col-sm-12 text-center">
                <hr />
                Administrador de Aportes - Unión por la Esperanza | Copyright &copy; <?php echo  date("Y"); ?>
                <br /><br />
            </footer>
        </div>
    </div>
</body>

</html>