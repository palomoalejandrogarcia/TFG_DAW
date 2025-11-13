<?php
// Cargamos PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

session_start();

//Inicializamos variables
$errores = "";
$valorCookie=null;
//Si hay una cookie llamado 'cookie_usuario' se mostrara el valor de esa cookie en el campo 'Usuario' de el login
if (isset($_COOKIE['cookie_usuario'])) {
    $valorCookie = $_COOKIE['cookie_usuario'];
}
//Esta funcion es controlar los posibles errores que se puede producir en el formulario
function procesarFormulario() {
    global $errores;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $usuario = htmlspecialchars($_POST['usuario']);
        $contraseña = $_POST['contraseña'];

        if (!preg_match('/^[a-zA-Z0-9]{1,10}$/', $usuario)) {
            return $errores = "El nombre de usuario no debe superar los 10 caracteres, usando solo letras y numeros";
        }

        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z0-9*]{5,15}$/', $contraseña)) {
            return $errores="La contraseña debe tener entre 5 y 15 caracteres, incluir al menos una letra mayuscula, una minuscula y un numero (Se permite introducir *).";
        }

        iniciarSesion($usuario ,$contraseña);
    }
}

//Esta funcion lo que hara sera comprobar si esta en la base de datos el usuario y la contraseña introducida en el login
//si esta registrado dependiendo el rol del usuario que haya querido entrar se le redije a una parte o otra.Si su rol es 'Usuario' entrara a la pagina web
//si es 'Administrador' se le redirije a la parte de Admnistrador y se le enviara un correo para verificar si es el titular real de la cuenta.
function iniciarSesion($usuario ,$contraseña)
{
    global $errores;

    $conexion = new mysqli("localhost", "root", "", "venta_cursos");
    $stmt = $conexion->prepare("SELECT id_usuario, nombre, apellidos, edad, correo, contraseña,foto, rol FROM usuarioss WHERE usuario = ?");

    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if($resultado->num_rows > 0){
        $fila = $resultado->fetch_assoc();
        $contrasena_hash = $fila['contraseña'];
        $rol = $fila['rol'];
        $id=$fila['id_usuario'];
        $foto_perfil = $fila['foto'];

        if (password_verify($contraseña, $contrasena_hash)) {
            if($rol==="Usuario"){
                $_SESSION['usuario'] = $usuario;
                $_SESSION['id_usuario'] = $id;
                $_SESSION['rol'] = $rol;
                $_SESSION['nombre'] = $fila['nombre'];
                $_SESSION['apellidos'] = $fila['apellidos'];
                $_SESSION['edad'] = $fila['edad'];
                $_SESSION['correo'] = $fila['correo'];
                $_SESSION['foto_perfil'] = $foto_perfil;

                header("Location: ../../fronted/Usuario/Inicio.php");
                // Inicializar contador si no existe
                if (!isset($_SESSION['contador_visitas'])) {
                    $_SESSION['contador_visitas'] = 0;
                }

                // Incrementar contador
                $_SESSION['contador_visitas']++;
                return;
            }
            if ($rol==="Administrador"){
                $_SESSION['usuario'] = $usuario;
                $_SESSION['id_usuario'] = $id;
                $_SESSION['rol'] = $rol;
                $_SESSION['nombre'] = $fila['nombre'];
                $_SESSION['apellidos'] = $fila['apellidos'];
                $_SESSION['edad'] = $fila['edad'];
                $_SESSION['correo'] = $fila['correo'];
                $nombre=$_SESSION['nombre'];

                //sacar la contraseña de verifiacion con random de 4 digitos
                $codigoVeri=random_int(1000, 9999);
                //Guardamos el codigo y su expiracion
                $_SESSION['codigoVeri']=$codigoVeri;
                $_SESSION['codigoVeri_expira'] = time() + 60;

                // Inicializar contador si no existe
                if (!isset($_SESSION['contador_visitas'])) {
                    $_SESSION['contador_visitas'] = 0;
                }

                // Incrementar contador de visitas cuantro entra un administrador
                $_SESSION['contador_visitas']++;

                //Configuracion y envio del correo eletronico
                $mail = new PHPMailer(true);

                try {
                    $mail->isSMTP();//Estamos diciendo a PHPMailer que estamos usando el protocolo SMTP
                    $mail->Host = 'smtp.gmail.com';//Servidor SMTP de gmail
                    $mail->SMTPAuth = true;//Activamos la autenticacion SMTP
                    $mail->Username = 'leatomaster@gmail.com';//El correo que usamos para enviar los correos
                    $mail->Password = 'iwrh yuvs kfli enhs';//La contraseña de la aplicacion del correo
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;//Usamos un cifrado para mejorar la seguridad de la conexion
                    $mail->Port = 587;//El puerto SMTP
                    $mail->CharSet = 'UTF-8';//Usamos la codificacion UTF-8 

                    $mail->setFrom('leatomaster@gmail.com', 'LeatoMaster');//El correo que enviara desde la siguiente direccion
                    $mail->addAddress($_SESSION['correo'], $_SESSION['nombre']);//Recibira el correo al siguiente correo
                    $mail->isHTML(true);//Decimos que el contenido del correo tendra formato HTML
                    $mail->Subject = '✔️ Verificacion de usuario';

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
                    <p>Estamos emocionados de volver a verte, <strong>$nombre</strong>.</p>
                    <p>Te enviamos el siguiente codigo para que confirmes tu usuario:</p>
                    <p class='boton'>$codigoVeri</p>
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
                    header("Location: ../../fronted/Administrador/Verificacion.php");
                    exit;

                } catch (Exception $e) {
                    $errores = $mail->ErrorInfo;
                }
            }
        }else{
            $errores="Introduce la contraseña correctamente";

        }
    }else{
        $errores="Introduce tu usuario correctamente";
    }
    // Cerramos las conexiones
    $stmt->close();
    $conexion->close();

}
// Llamamos la funcion para procesar el formulario
procesarFormulario();
?>