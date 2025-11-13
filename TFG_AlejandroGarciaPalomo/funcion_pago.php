<?php
// Cargamos PHPMailer y FPDF
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../../vendor/autoload.php';
require '../../fpdf/fpdf.php';
session_start();

//Verificamos que si se ha logueado un usuario con rol de 'Usuario' si no es asi nos redirije al login de la pagina
if(empty($_SESSION['usuario']) ||  $_SESSION['rol'] !=='Usuario'){
    header("Location: ../../fronted/Inicio_Web/Inicio_de_sesion.php");
exit;
}

//Inicializamos variables
$errorBizum=null;
$errorPaypal=null;
$errorTarjeta=null;
$errorDetallesFacturacion=null;
$cvc=null;
$telefono=null;
$cursoId=null;
$cursoPrecio=null;
$cursos=null;
$estado=null;


if (isset($_GET['estado'])) {
    $estado = isset($_GET['estado']) ? $_GET['estado'] : null;
}
//dependiendo de el estado que sea el url pone el precio de una o otra
if ($estado === 'carrito') {
    $cursoPrecio = $_SESSION['precioTotalCurso_carrito'];
}
if($estado === 'compra'){
    $cursoPrecio = $_SESSION['curso_seleccionado']['precio'];
}
$cursosGuardados = [];
$cursos=$_SESSION['carrito'];


//almacenar los datos del carrito a curso
foreach ($cursos as $curso) {
    $cursosGuardados[] = [
        'id'=>$curso['id'],
        'titulo' => $curso['titulo'],
        'precio' => $curso['precio']
    ];
}


//Esta funcion lo que hace es controlar los datos que se introduzca en el formulario de facturacion
function comprobarDetallesFacturacion()
{
    global $errorDetallesFacturacion, $pais, $telefono, $dni,$cursoPrecio;

    if (isset($_POST['pais']) && isset($_POST['telefono_user']) && isset($_POST['dni_user'])) {

        $pais = isset($_POST['pais']) ? $_POST['pais'] : '';
        $telefono = isset($_POST['telefono_user']) ? $_POST['telefono_user'] : '';
        $dni = isset($_POST['dni_user']) ? $_POST['dni_user'] : '';

        if ($pais === 'Selecciona tu pais') {
            return $errorDetallesFacturacion = "Por favor, selecciona un pais.";
        }
        if (empty($_POST['telefono_user'])) {
            return $errorDetallesFacturacion = "Por favor, introduzca su telefono.";
        }
        if (!preg_match('/^[0-9]{9}$/', $_POST['telefono_user'])) {
            return $errorDetallesFacturacion = "Numero de telefono no valido,tiene que contener 9 numeros.";
        }
        if (empty($_POST['dni_user'])) {
            return $errorDetallesFacturacion = "Por favor, introduzca su dni.";
        }
        if (!preg_match('/^\d{8}[A-Z]$/', $_POST['dni_user'])) {
            return $errorDetallesFacturacion = "El dni no es valido.";
        }

        recopilarDatos();
    }

}
//Esta funcion lo que hace es crear la cabeza de la factura
function cabeza($pdf) {
    // Color de fondo
    $pdf->SetFillColor(255, 255, 255);
    $pdf->Rect(0, 0, 210, 40, 'F');

    // Logo
    $pdf->Image($_SERVER['DOCUMENT_ROOT'] . '/TFG_AlejandroGarciaPalomo/fronted/Imagenes/logo_cortado.png', 15, 7, 30); // Ajusta la ruta y tamaño del logo

    // Titulo
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->SetXY(50, 10);
    $pdf->Cell(0, 10, 'LeatoMaster - Factura de Compra', 0, 1, 'L');
    $pdf->SetFont('Arial', '', 11);
    $pdf->SetX(50);
    $pdf->Cell(0, 10, 'Fecha: ' . date('d/m/Y'), 0, 1, 'L');
    $pdf->Ln(5);
}

//Esta funcion lo que hace es crear el pie de la factura
function pie($pdf) {
    // Dibujar fondo azul en el pie (altura 20 mm desde la parte inferior)
    $pdf->SetFillColor(30, 58, 138);
    $pdf->Rect(0, 277, 210, 20, 'F');

}
//Esta funcion genera la factura de la compra automaticamente
function generarFactura($nombreTitular, $numeroTarjeta, $fechaExpiracion, $cvc, $nombre, $apellido, $correo, $telefono, $dni, $pais) {
    global $cursoPrecio, $cursosGuardados, $estado;

    //Comprobamos de que existe la carpeta facturas y si no existe se creara de forma automaticamente
    $directorio = 'Facturas/';
    if (!file_exists($directorio)) {
        mkdir($directorio, 0777, true);
    }

    //Configuracion y creacion de la factura
    $pdf = new FPDF();
    $pdf->AddPage();
    cabeza($pdf);
    $pdf->SetFont('Arial', '', 12);
    $pdf->SetMargins(15, 15, 15);

    $pdf->Ln(10);

    // Datos del cliente
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'Datos del cliente', 0, 1);
    $pdf->SetFont('Arial', '', 11);
    $pdf->Cell(0, 8, "Nombre: $nombre $apellido", 0, 1);
    $pdf->Cell(0, 8, "Correo: $correo", 0, 1);
    $pdf->Cell(0, 8, "Telefono: $telefono", 0, 1);
    $pdf->Cell(0, 8, "DNI: $dni", 0, 1);
    $pdf->Cell(0, 8, "Pais: $pais", 0, 1);

    $pdf->Ln(5);
    $pdf->Cell(0, 0, '', 'T');
    $pdf->Ln(10);

    // Detalled de la compra
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'Detalle de la compra', 0, 1);
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(100, 8, 'Curso', 1);
    $pdf->Cell(40, 8, 'Precio', 1);
    $pdf->Ln();

    $pdf->SetFont('Arial', '', 11);
    $total = 0;
    //La tabla donde se almacenara los cursos
    if ($estado === 'compra' && isset($_SESSION['curso_seleccionado'])) {
        $curso = $_SESSION['curso_seleccionado'];
        $pdf->Cell(100, 8, utf8_decode($curso['titulo']), 1);
        $pdf->Cell(40, 8, number_format($curso['precio'], 2) . ' euros', 1);
        $total += $curso['precio'];
        $pdf->Ln();
    }

    if ($estado === 'carrito' && !empty($cursosGuardados)) {
        foreach ($cursosGuardados as $curso) {
            $pdf->Cell(100, 8, utf8_decode($curso['titulo']), 1);
            $pdf->Cell(40, 8, number_format($curso['precio'], 2) . ' euros', 1);
            $total += $curso['precio'];
            $pdf->Ln();
        }
    }

    // Total de la compra
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(100, 10, 'Total a pagar', 1);
    $pdf->Cell(40, 10, number_format($total, 2) . ' euros', 1);
    $pdf->Ln(10);
    pie($pdf);

    // Guardamos la factura en la carpea Facturas y le damos un nombre unico
    $nombreArchivo = $directorio . 'factura_' . uniqid() . '.pdf';
    $pdf->Output('F', $nombreArchivo);

    return $nombreArchivo;
}

//Esta funcion lo que hara sera controlar los datos introducidos en los metodos de pago,registrar el pago en la base de datos y enviar el pago mediante un correo electronico
function recopilarDatos() {
    global $errorBizum, $errorTarjeta, $telefono, $errorPaypal, $cursoPrecio, $cursoId,$id_usuario;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (isset($_POST['pago_tarjeta'])) {
            if(empty($_POST["nombre_titular"])){
                return $errorTarjeta="Introduce el numero de tarjeta";
            }
            if(empty($_POST["numero_tarjeta"])){
                return $errorTarjeta="Introduce el numero de tarjeta";
            }
            if(empty($_POST["fecha_expiracion"])){
                return $errorTarjeta="Introduce la fecha de expiracion";
            }
            if(empty($_POST["cvc"])){
                return $errorTarjeta="Introduce el cvc";
            }

            if (strlen($_POST["numero_tarjeta"]) != 16 || !ctype_digit($_POST["numero_tarjeta"])) {
                return $errorTarjeta= "Tiene que introducir exactamente 16 numeros en el apartado numero de la tarjeta";
            }

            if (strlen($_POST["fecha_expiracion"]) != 5) {
                return "Tiene que introducir 5 caracteres en el apartado fecha de expiracion (formato XX/XX)";
            }

            if (!preg_match('/^\d{2}\/\d{2}$/', $_POST["fecha_expiracion"])) {
                return $errorTarjeta= "La fecha de caducidad tiene que tener el siguiente formato (XX/XX)";
            }

            if (strlen($_POST["cvc"]) != 3 || !ctype_digit($_POST["cvc"])) {
                return $errorTarjeta="El CVC tiene que tener exactamente 3 numeros";
            }
            //No lo vamos a usar esta informacion
            //Inicializamos las varibles
            $nombreTitular=$_POST["nombre_titular"];
            $numeroTarjeta = $_POST['numero_tarjeta'];
            $fechaExpiracion = $_POST['fecha_expiracion'];
            $cvc = $_POST['cvc'];
            $id_usuario = $_SESSION['id_usuario'];

            registrarPago($cursoId, $id_usuario);
            enviarPago($telefono, $cursoPrecio, $cursoId, $_SESSION['nombre'], $_SESSION['apellidos'], $_SESSION['correo'], $_POST['telefono_user'], $_POST['dni_user'], $_POST['pais']);
            exit;
        } elseif (isset($_POST['pago_bizum'])) {
            // Comprobacion de bizum
            if (!preg_match('/^[0-9]{9}$/', $_POST['telefonoBizum'])) {
                $errorBizum = "Numero de telefono no valido";
            } else {
                //Inicializamos las varibles
                $telefono = $_POST['telefonoBizum'];
                $id_usuario = $_SESSION['id_usuario'];
                registrarPago($cursoId, $id_usuario);
                enviarPago($telefono, $cursoPrecio, $cursoId, $_SESSION['nombre'], $_SESSION['apellidos'], $_SESSION['correo'], $_POST['telefono_user'], $_POST['dni_user'], $_POST['pais']);
                exit;
            }
        } elseif (isset($_POST['pago_paypal'])) {
            // Comprobacion de bizum
            if (!preg_match('/^[0-9]{9}$/', $_POST['telefonoPay'])) {
                $errorPaypal ="Numero de telefono no valido";
            } else {
                //Inicializamos las varibles
                $telefono = $_POST['telefonoPay'];
                $id_usuario = $_SESSION['id_usuario'];
                registrarPago($cursoId, $id_usuario);
                enviarPago($telefono, $cursoPrecio, $cursoId, $_SESSION['nombre'], $_SESSION['apellidos'], $_SESSION['correo'], $_POST['telefono_user'], $_POST['dni_user'], $_POST['pais']);
                exit;
            }
        }
    }

}
//Esta funcion lo que hara sera registrar los cursos que el usuario a comprado en la base de datos
function registrarPago($id_curso,$id_usuario){
    global $estado,$cursosGuardados,$cursoPrecio;

    $conexion = new mysqli("localhost", "root", "", "venta_cursos");

    $fechaCompra=date("Y-m-d H:i:s");

    if ($conexion->connect_error) {
        die("Conexion fallida: " . $conexion->connect_error);
    }

    if ($estado === 'carrito') {
        foreach ($cursosGuardados as $curso) {
            $stmt = $conexion->prepare("INSERT INTO cursos_comprados (id_usuario, id_curso, precio,pais, fecha_compra) VALUES (?, ?, ?, ?,?)");
            $stmt->bind_param("iiiss", $_SESSION['id_usuario'], $curso['id'], $cursoPrecio,$_POST['pais'], $fechaCompra);

            if (!$stmt->execute()) {
                echo "Error al registrar la compra: " . $stmt->error;
            }
            $stmt->close();
        }
    }


    if ($estado === 'compra') {
        $stmt = $conexion->prepare("INSERT INTO cursos_comprados (id_usuario, id_curso,precio,pais, fecha_compra) VALUES (?, ?,?, ?,?)");
        $stmt->bind_param("iiiss", $id_usuario, $_SESSION['curso_seleccionado']['id'],$cursoPrecio,$_POST['pais'], $fechaCompra);


        if (!$stmt->execute()) {
            echo "Error al registrar compra: " . $stmt->error;
        }
        $stmt->close();
    }
}

//Esta funcion lo que hara sera crear,configurar y enviar el correo electronico con los datos introducidos en el formulario de pago con la factura de la compra
function enviarPago($datos,$precio,$nombreCurso,$nombre,$apellido,$correo,$telefono,$dni,$pais)
{

    global $cursoTitulo,$nombre,$numeroTarjeta,$fechaExpiracion,$cvc,$nombreTitular;

    $nombre=$_SESSION['nombre'];

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


        $mail->setFrom('leatomaster@gmail.com','LeatoMaster');
        $mail->addAddress($_SESSION['correo'], $_SESSION['usuario']);
        $mail->isHTML(true);

        $mail->Subject = ' 🛍️ ¡Gracias por contar con nosotros!';
        $mail->Body = "<!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Factura de compra - LeatoMaster</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }
        .contenedor  { max-width: 600px; margin: 20px auto; background: #fff; padding: 20px; border-radius: 8px;
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
         ¡Compra realizada exitosamente!
    </div>
    <div class='contenido'>
        <p>Hola <strong>$nombre $apellido</strong>,</p>
        <p>Gracias por tu compra en LeaToMaster. Te adjuntamos la siguiente factura para que puedas revisar toda la informacion relacionada con tu pedido.</p>
        <p>Si tienes alguna duda o necesitas soporte, no dudes en contactarnos. ¡Gracias por confiar en nosotros!</p>
        <a href='https://192.168.1.49/TFG_AlejandroGarciaPalomo/fronted/Usuario/Mis_cursos.php' class='boton'>Ver mi curso</a>
    </div>
    <div class='pie'>
        © 2025 LeatoMaster | Todos los derechos reservados.
    </div>
</div>
</body>
</html>";
        $archivoPdf = generarFactura($nombreTitular,$numeroTarjeta,$fechaExpiracion,$cvc,$nombre, $apellido, $correo, $telefono ,$dni, $pais);
        $mail->addAttachment($archivoPdf);
        // Esto nos permite hacer conexiones SSL sin verificar certificado
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        $mail->send();
        header("Location: ../../fronted/Pago/Confirmacion_Pago.php");
        exit();
    } catch (Exception $e) {
        echo "Error al enviar el correo: {$mail->ErrorInfo}";
    }

}
// Llamamos la funcion para procesar el formulario
comprobarDetallesFacturacion();

?>
