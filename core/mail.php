<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'Exception.php';
require 'PHPMailer.php';
require 'SMTP.php';


function enviarMail($mailDestino,$nombreDestinatario,$aporteID){

$mail = new PHPMailer();

$mail->IsSMTP();                       // telling the class to use SMTP

$mail->SMTPDebug = 0;                  
// 0 = no output, 1 = errors and messages, 2 = messages only.

$mail->SMTPAuth = true;                // enable SMTP authentication
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;              // sets the prefix to the servier
$mail->Host = "correo.unionporlaesperanza.com";        // sets Gmail as the SMTP server
$mail->Port = 587;                     // set the SMTP port for the GMAIL
$mail->SMTPOptions = array(
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    )
                );


$mail->Username = "aportes@unionporlaesperanza.com";  // Gmail username
$mail->Password = "8F62caJCzj";      // Gmail password

$mail->CharSet = 'windows-1250';
$mail->SetFrom ('aportes@unionporlaesperanza.com', 'Union por la Esperanza');
$mail->Subject = "Union por la esperanza -  Aportes";
$mail->ContentType = 'text/plain';
$mail->IsHTML(true);

$mail->Body = "Estimado ciudadano ".$nombreDestinatario.", le informamos se han validado satisfactoriamente sus datos y se ha verificado su aporte econ&oacute;mico al binomio Uni&oacute;n por la Esperanza.
<br/><br/><br/>A continuaci&oacute;n debe imprimir y firmar la solicitud que ya contiene sus datos y est&aacute; disponible <strong><a href=\"https://aportes.andresarauz.ec/api/v1/pdf/formulario/".$aporteID."\">AQUI</a></strong>. 
<br/><br/><br/>Una vez firmada, esta debe ser entregada en las sedes provinciales o cantonales del partido. 
<br/><br/>Muchas gracias por su valioso aporte.";



// you may also use $mail->Body = file_get_contents('your_mail_template.html');

$mail->AddAddress ($mailDestino, $nombreDestinatario);     
// you may also use this format $mail->AddAddress ($recipient);
//$mail->addAttachment('Formulario.pdf');
//$mail->addAttachment('/var/www/aportes.andresarauz.ec/api-node/aportes-master/upload/formulario/'.$aporteID.'.pdf');  
// /var/www/aportes.andresarauz.ec/api-node/aportes-master/upload/formulario/xx.pdf

$res = false;
if(!$mail->Send())
{
        $error_message = "Mailer Error: " . $mail->ErrorInfo;
} else 
{
        $error_message = "Successfully sent!";
        $res = true;
}
//echo $error_message;
return $res;
}

?>