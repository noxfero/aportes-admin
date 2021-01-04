<?php
session_start();

$message = ''; 
if (isset($_POST['uploadBtn']))
{
  if (isset($_FILES['uploadedFile']) && $_FILES['uploadedFile']['error'] === UPLOAD_ERR_OK)
  {
    // get details of the uploaded file
    $fileTmpPath = $_FILES['uploadedFile']['tmp_name'];
    $fileName = $_FILES['uploadedFile']['name'];
    $fileSize = $_FILES['uploadedFile']['size'];
    $fileType = $_FILES['uploadedFile']['type'];
    $fileNameCmps = explode(".", $fileName);
    $fileExtension = strtolower(end($fileNameCmps));

    // sanitize file-name
    $newFileName = "Datos.xlsx";//$fileName;

    // check if file has one of the following extensions
    $allowedfileExtensions = array('xlsx','xls');

    if (in_array($fileExtension, $allowedfileExtensions))
    {
      // directory in which the uploaded file will be moved
      $uploadFileDir = './uploads/';
      $dest_path = $uploadFileDir . $newFileName;

      if(move_uploaded_file($fileTmpPath, $dest_path)) 
      {
        $message ='Archivo subido con éxito. ' . "Datos.xlsx";
      }
      else 
      {
        $message = 'Error al cargar el archivo.';
      }
    }
    else
    {
      $message = 'Solo se admiten tipos de archivos de excel: ' . implode(',', $allowedfileExtensions);
    }
  }
  else
  {
    $message = 'Hubo un probema con la carga, hay un error.<br>';
    $message .= 'Error:' . $_FILES['uploadedFile']['error'];
  }
}
$_SESSION['message'] = $message;
header("Location: index.php?controller=BandejaBancos&action=index");