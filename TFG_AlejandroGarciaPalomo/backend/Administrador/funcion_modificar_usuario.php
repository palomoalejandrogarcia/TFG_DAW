<?php
//Verificamos que si no hay una sesion iniciada se inicia una sesion 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
//Verificamos que si se ha logueado el usuario con rol de administrador, si no es asi nos redirije al login de la pagina
if(empty($_SESSION['usuario']) ||  $_SESSION['rol'] !=='Administrador'){
    header("Location: ../../fronted/Inicio_Web/Inicio_de_sesion.php");
exit;
}
//Inicializamos las variables
$existe = false;
$datos = [];
$valorUsuario=null;
$valorNombre=null;
$valorApellidos=null;
$valorEdad=null;
$erroresId=null;
$erroresModificar=null;
function procesarFormulario()
{
    global $existe, $datos,$valorUsuario,$valorNombre,$valorEdad,$valorApellidos,$erroresId,$erroresModificar;

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_usuario'])) {
        // Recoger el ID del curso
        $id_curso = $_POST['id_usuario']; // Recoge el id del curso
        if (!is_numeric($id_curso)) {
            return  $erroresId="El id tiene que ser numerico";
        }
        $existe = comprobarUsuario($id_curso); // Verificar si el usuario existe


        if ($existe) {
            $valorUsuario=$_SESSION['usuario_modificar'];
            $valorNombre=$_SESSION['nombre_modificar'];
            $valorApellidos=$_SESSION['apellidos_modificar'];
            $valorEdad=$_SESSION['edad_modificar'];

            // Si el usuario existe, mostramos el formulario de modificacion
            if (isset($_POST['usuario'], $_POST['nombre'], $_POST['apellidos'], $_POST['edad'])) {
                $usuario=htmlspecialchars(trim($_POST['usuario'])) ?? null;
                $nombre = htmlspecialchars(trim($_POST['nombre'])) ?? null;
                $apellidos = htmlspecialchars(($_POST['apellidos'])) ?? null;
                $edad = $_POST['edad'] ?? null;

                if (empty($usuario)) {
                    $usuario = $_SESSION['usuario_modificar'];
                }
                if (empty($nombre)) {
                    $nombre = $_SESSION['nombre_modificar'];
                }
                if (empty($apellidos)) {
                    $apellidos = $_SESSION['apellidos_modificar'];
                }
                if (empty($edad)) {
                    $edad = $_SESSION['edad_modificar'];
                }

                $datos = [
                    'usuario' => $usuario,
                    'nombre' => $nombre,
                    'apellidos' => $apellidos,
                    'edad' => $edad
                ];
                modificarDatos($id_curso, $datos);
            }
        } else {
            return $erroresId="El usuario con el ID proporcionado no existe.";
        }
    }
}

// Funcion para comprobar si el curso existe
function comprobarUsuario($id_usuario)
{
    global $existe,$erroresId;
    $conexion = new mysqli("localhost", "root", "", "venta_cursos");
    if ($conexion->connect_error) {
        die("Conexion fallida: " . $conexion->connect_error);
    }

    $stmt = $conexion->prepare("SELECT * FROM usuarioss WHERE id_usuario = ?");
    $stmt->bind_param("i", $id_usuario);

    if ($stmt->execute()) {
        $stmt->store_result(); // Necesario para usar num_rows

        if ($stmt->num_rows > 0) {
            $existe = true;
        } else {
            $existe = false;
        }
    } else {
        return $erroresId= "Error al comprobar si existe el curso: " . $stmt->error;
    }

    $stmt->close();
    $conexion->close();

    return $existe; // Retorna el valor de existencia del curso
}

// Funcion para modificar los datos del curso
function modificarDatos($id_curso, $datos)
{
    $conexion = new mysqli("localhost", "root", "", "venta_cursos");
    if ($conexion->connect_error) {
        die("Conexion fallida: " . $conexion->connect_error);
    }

    // Preparamos la consulta para modificar el curso
    $stmt = $conexion->prepare("UPDATE usuarioss SET usuario = ?, nombre = ?, apellidos = ?,edad = ? WHERE id_usuario = ?");
    $stmt->bind_param("sssii", $datos['usuario'], $datos['nombre'], $datos['apellidos'],$datos['edad'], $id_curso);

    if ($stmt->execute()) {
        header("Location: ../../fronted/Administrador/Panel_Control.php");
    } else {
      return $erroresModificar="Error al actualizar el usuario: " . $stmt->error;
    }

    $stmt->close();
    $conexion->close();
}

// Llamar a la funcion para procesar el formulario
procesarFormulario();
?>
