<?php
session_start();
// Cargamos PHPMailer
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Verificamos que si se ha logueado un usuario con rol de 'Usuario' si no es asi nos redirije al login de la pagina
if(empty($_SESSION['usuario']) ||  $_SESSION['rol'] !=='Administrador'){
    header("Location: ../../fronted/Inicio_Web/Inicio_de_sesion.php");
exit;
}
//Inicializamos las variables
$errores = '';
$mensaje = '';

// Verificamos el codigo si se ha expirado o no, si no ha expirado nos redirecciona al panel de control
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['enviar_codigo'])) {
    $codigoIngresado = $_POST['codigo'];
    if (time() > $_SESSION['codigoVeri_expira']) {
        return $errores = " El codigo ha expirado. Por favor, solicite uno nuevo.";
    } elseif ($codigoIngresado == $_SESSION['codigoVeri']) {
        header("Location: ../../fronted/Administrador/Panel_Control.php");
        exit;
    } else {
        return $errores = " Codigo incorrecto. Intentelo de nuevo.";
    }
}
// Se reenvia el codigo al gmail del usuario logueado si presiona el boton de reenviar codigo y se enviara un nuevo codigo y se reinicia la expiracion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reenviar_codigo'])) {
    $codigo = random_int(1000, 9999); // Nuevo codigo
    $_SESSION['codigoVeri'] = $codigo;
    $_SESSION['codigoVeri_expira'] = time() + 60; //Reiniciamos la expiracion
    $nombre = $_SESSION['nombre'];
    $correo = $_SESSION['correo'];

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

        $mail->setFrom('leatomaster@gmail.com', 'LeatoMaster');
        $mail->addAddress($correo, $nombre);
        $mail->isHTML(true);
        $mail->Subject = '🔁 Reenvio de codigo de verificacion';
        $mail->Body = "
        <html lang='es'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <style>
                body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }
                .contenedor { max-width: 600px; margin: 20px auto; background: #fff; padding: 20px; border-radius: 8px; 
                             box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); text-align: center; }
                .cabeza { background: #1e3a8a; padding: 20px; color: #fff; font-size: 24px; border-top-left-radius: 8px;
                          border-top-right-radius: 8px; }
                .contenido { padding: 20px; color: #333; font-size: 16px; }
                .pie { font-size: 12px; color: #888; margin-top: 20px; }
                .boton { display: inline-block; background: #1e3a8a; color: #fff; padding: 12px 20px; text-decoration: none;
                  border-radius: 5px; font-weight: bold; margin-top: 20px; }
            </style>
        </head>
        <body>
            <div class='contenedor'>
                <div class='cabeza'>
                     ¡Verificacion de usuario, $nombre!
                </div>
                <div class='contenido'>
                    <p>Tu nuevo codigo de verificacion es el siguiente:</p>
                    <p class='boton'>$codigo</p>
               </div>
                <div class='pie'>
        © 2025 LeatoMaster | Todos los derechos reservados.
                </div>
            </div>
        </body>
        </html>";
        // Esto nos permite hacer conexiones SSL sin verificar certificado
        $mail->SMTPOptions = [
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true,
            ]
        ];

        $mail->send();
        $mensaje = "Codigo reenviado.Revise su correo electronico";
    } catch (Exception $e) {
        $errores = "Error al enviar el correo: {$mail->ErrorInfo}";
    }
}
?>
