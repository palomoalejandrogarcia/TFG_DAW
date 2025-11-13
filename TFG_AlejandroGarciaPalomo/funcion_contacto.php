<?php
// Cargamos PHPMailer
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();

//Verificamos que si se ha logueado un usuario con rol de 'Usuario' si no es asi nos redirije al login de la pagina
if(empty($_SESSION['usuario']) ||  $_SESSION['rol'] !=='Usuario'){
    header("Location: ../../fronted/Inicio_Web/Inicio_de_sesion.php");
exit;
}
//Inicializamos variables
$asunto = $mensaje = "";
$select = ['Soporte tecnico', 'Consulta de cursos', 'Colaboracion'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //Inicializando las variables y controlando el formulario de posibles errores
    $asunto = $_POST['asunto'] ?? '';

    if (!in_array($asunto, $select)) {
        return $errores="Selecciona una de las opciones en el apartado de asunto.";
    }

    $mensaje = $_POST['mensaje'];
    if (!preg_match('/^[a-zA-Z0-9¿?!¡.\s]{1,100}$/u', $mensaje)) {
        return $errores="Solo puedes introducir letras,espacios,numeros y signo de interrogacion,exclamacion, puntos y tiene un maximo de 100 caracteres";
    }

    //Configuracion y envio de el correo electronico
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'leatomaster@gmail.com';
        $mail->Password = 'iwrh yuvs kfli enhs';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->CharSet = 'UTF-8';
        $mail->setFrom($_SESSION['correo'], htmlspecialchars($_SESSION['usuario']));
        $mail->addAddress('leatomaster@gmail.com', 'Leatomaster');
        $mail->isHTML(true);
        $mail->Subject = '📬  ¡Mensaje de atencion al usuario!';

        $mail->Body = "
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }
        .contenedor  { max-width: 600px; margin: 20px auto; background: #fff; padding: 20px; border-radius: 8px; 
                     box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); }
        .cabeza { background: #1e3a8a; padding: 20px; color: #fff; font-size: 22px; text-align: center; 
                  border-top-left-radius: 8px; border-top-right-radius: 8px; }
        .contenido { padding: 20px; color: #333; font-size: 16px; line-height: 1.6; }
        .pie { font-size: 12px; color: #888; text-align: center; margin-top: 20px; }
        .campo { font-weight: bold; color: #1e3a8a; }
    </style>
</head>
<body>
    <div class='contenedor '>
        <div class='cabeza'>
            Nuevo mensaje de atencion al usuario
        </div>
        <div class='contenido'>
            <p><span class='campo'>Usuario:</span> " . htmlspecialchars($_SESSION['usuario']) . "</p>
            <p><span class='campo'>Correo:</span> " . htmlspecialchars($_SESSION['correo']) . "</p>
            <p><span class='campo'>Asunto:</span> " . htmlspecialchars($asunto) . "</p>
            <p><span class='campo'>Mensaje:</span><br>" . nl2br(htmlspecialchars($mensaje)) . "</p>
        </div>
        <div class='pie'>
                    © 2025 LeatoMaster | Todos los derechos reservados.
        </div>
    </div>
</body>
</html>";
        // Esto nos permite hacer conexiones SSL sin verificar certificado
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        $mail->send();
        $mensajeContacto="Se ha enviado el mensaje con exito.";
    } catch (Exception $e) {
        $errores=$mail->ErrorInfo;
    }
}