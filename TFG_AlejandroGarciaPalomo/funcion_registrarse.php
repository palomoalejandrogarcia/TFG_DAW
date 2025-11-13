<?php
// Cargamos PHPMailer
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Inicializamos variables
$errores=null;
//Esta funcion lo que hace es controlar los datos que se introduzca en el formulario del registro
function procesarFormulario() {
    global $errores;
    $conexion = new mysqli("localhost", "root", "", "venta_cursos");
    if ($conexion->connect_error) {
        die("Conexion fallida: " . $conexion->connect_error);
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $usuario = htmlspecialchars($_POST['usuario']);
        $nombre = htmlspecialchars($_POST['nombre']);
        $apellidos = htmlspecialchars($_POST['apellidos']);
        $correo = htmlspecialchars($_POST['correo']);
        $edad = $_POST['edad'];
        $contraseña = $_POST['contraseña'];
        $repetir_contraseña = $_POST['repetir_contraseña'];
        $hora_registro = date("Y-m-d H:i:s");
        $rol = isset($_POST['opcion']) ? $_POST['opcion'] : '';

        if (!preg_match('/^[a-zA-Z0-9]{1,10}$/', $usuario)) {
            return $errores = "El nombre de usuario no debe superar los 10 caracteres, usando solo letras y numeros";
        }
        if (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{1,10}$/', $nombre)) {
            return $errores = "El nombre no debe superar las 10 letras";
        }
        if (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{1,20}$/', $apellidos)) {
            return $errores = "El apellido no debe superar las 20 letras";
        }

        if (!preg_match('/^[a-zA-Z0-9.]+@gmail\.com$/', $correo)) {
            return $errores = "El correo debe contener solo letras y numeros, y terminar en @gmail.com";
        }
        if ($edad < 12 || $edad > 100) {
            return $errores = "La edad debe estar entre 12 y 100 años";
        }
        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z0-9*]{5,15}$/', $contraseña)) {
            return $errores = "La contraseña debe tener entre 5 y 15 caracteres, incluir al menos una letra mayuscula, una minuscula y un numero. No debe contener simbolos.";
        }
        if ($contraseña !== $repetir_contraseña) {
            return $errores="Las contraseñas no coinciden";
        }
        if(empty($rol)){
            return $errores="Seleccione un rol";
        }
        // Verificamos si el nombre de usuario ya esta registrado
        $stmt_usuario = $conexion->prepare("SELECT * FROM usuarioss WHERE usuario = ?");
        $stmt_usuario->bind_param("s", $usuario);
        $stmt_usuario->execute();
        $stmt_usuario->store_result();

        if ($stmt_usuario->num_rows > 0) {
            return $errores = "El nombre de usuario ya esta registrado.";
        }

        // Verificamos si el correo ya esta registrado
        $stmt_correo = $conexion->prepare("SELECT * FROM usuarioss WHERE correo = ?");
        $stmt_correo->bind_param("s", $correo);
        $stmt_correo->execute();
        $stmt_correo->store_result();

        if ($stmt_correo->num_rows > 0) {
            return $errores = "El correo electronico ya esta registrado.";
        }

        // Creamos el usuario
        crearUsuario($usuario, $nombre, $apellidos, $correo,$edad, $contraseña, $hora_registro,$rol);
    }
}


//Esta funcion lo que hara sera crear el usuario y lo registrara en la base de datos y enviara un correo al correo del usuario registrado
function crearUsuario($usuario, $nombre, $apellidos, $correo, $edad, $contraseña, $hora_registro, $rol) {
    global $errores;

    $conexion = new mysqli("localhost", "root", "", "venta_cursos");

    if ($conexion->connect_error) {
        die("Conexion fallida: " . $conexion->connect_error);
    }

    // Cifra la contraseña
    $contraseña_cifrada = password_hash($contraseña, PASSWORD_DEFAULT);

    //Si no hay ningun problema, se inserta el usuario registrado
    $stmt = $conexion->prepare("INSERT INTO usuarioss (usuario, nombre, apellidos, edad, correo, contraseña, rol, hora_registro) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssissss", $usuario, $nombre, $apellidos, $edad, $correo, $contraseña_cifrada, $rol, $hora_registro);


    //  Ejecutar la consulta
    if ($stmt->execute()) {
        if ($rol === 'Usuario') {
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
                $mail->Subject = '👋 ¡Bienvenido a LeatoMaster!';
                $mail->Body = "
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Bienvenido a LeatoMaster</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }
        .contenedor { max-width: 600px; margin: 20px auto; background: #fff; padding: 20px; border-radius: 8px;
                     box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); text-align: center; }
        .cabeza { background: #1e3a8a; padding: 20px; color: #fff; font-size: 24px; border-top-left-radius: 8px;
                  border-top-right-radius: 8px; }
        .contenido { padding: 20px; color: #333; font-size: 16px; }
        .boton { display: inline-block; background: #1e3a8a; color: #fff; padding: 12px 20px; text-decoration: none;
                  border-radius: 5px; font-weight: bold; margin: 10px 5px 0 5px; }
        .pie { font-size: 12px; color: #888; margin-top: 20px; }
    </style>
</head>
<body>
    <div class='contenedor'>
        <div class='cabeza'>
             ¡Bienvenido a LeatoMaster, $nombre!
        </div>
        <div class='contenido'>
            <p>Hola <strong>$nombre $apellidos</strong>,</p>
            <p>Estamos emocionados de que te unas a nuestra plataforma. Ahora tienes acceso a cursos exclusivos para mejorar tus habilidades y conocimientos.</p>
            <p>Como muestra de agradecimiento te regalamos un codigo de 20% de descuento:</p>
            <div>
                <span class='boton'>000</span>
            </div>
            <p>¿Listo para comenzar? Haz clic en el siguiente boton para ir al inicio:</p>
            <div>
                <a href='https://192.168.1.49/TFG_AlejandroGarciaPalomo/fronted/Usuario/Inicio.php' class='boton'>Ir al inicio</a>
            </div>
            <p>Si necesitas ayuda, no dudes en contactarnos. ¡Nos vemos dentro! </p>
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
            } catch (Exception $e) {
                echo "Error al enviar el correo: {$mail->ErrorInfo}";
            }
        }
        header("Location: ../../fronted/Inicio_Web/Inicio_de_sesion.php");
        exit();
    } else {
      return $errores="Error al registrar el usuario: " . $stmt->error;
    }

    // Cerrar la conexion
    $stmt->close();
    $conexion->close();
}

// Llamamos la funcion para procesar el formulario
procesarFormulario();
?>
