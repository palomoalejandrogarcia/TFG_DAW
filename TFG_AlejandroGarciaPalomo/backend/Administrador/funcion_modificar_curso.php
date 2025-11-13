<?php
//Verificamos que si no hay una sesion iniciada se inicia una sesion
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
//Verificamos que si se ha logueado el usuario con rol de administrador si no es asi nos redirije al login de la pagina
if(empty($_SESSION['usuario']) ||  $_SESSION['rol'] !=='Administrador'){
    header("Location: ../../fronted/Inicio_Web/Inicio_de_sesion.php");
exit;
}
//Inicializamos las variables
$existe = false;
$datos = [];
$valorTitulo=null;
$valorDescripcion=null;
$valorPrecio=null;
$erroresId=null;
$erroresModificar=null;
//Esta funcion lo que hara es primero si existe el id curso introducido y si existe se mostrara el segundo formulario con los datos del curso seleccionado
function procesarFormulario()
{
    global $existe, $datos,$valorTitulo,$valorDescripcion,$valorPrecio,$erroresId;

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_curso'])) {

        $id_curso = $_POST['id_curso'];

        if (!is_numeric($id_curso)) {
            return  $erroresId="El id tiene que ser numerico";
        }
        $existe = comprobarCurso($id_curso);

        if ($existe) {
            $valorTitulo=$_SESSION['titulo_modificar'];
            $valorDescripcion=$_SESSION['descripcion_modificar'];
            $valorPrecio=$_SESSION['precio_modificar'];

            if (isset($_POST['titulo'], $_POST['descripcion'], $_POST['precio'])) {
                $titulo=htmlspecialchars(trim($_POST['titulo']));
                $descripcion = htmlspecialchars(trim($_POST['descripcion']));
                $precio = htmlspecialchars(($_POST['precio']));


                if (empty($titulo)) {
                    $titulo = $_SESSION['titulo_modificar'];
                }
                if (empty($descripcion)) {
                    $descripcion = $_SESSION['descripcion_modificar'];
                }
                if (empty($precio)) {
                    $precio = $_SESSION['precio_modificar'];
                }

                $datos = [
                    'titulo' => $titulo,
                    'descripcion' => $descripcion,
                    'precio' => $precio,
                ];
                modificarDatos($id_curso, $datos);
            }
        } else {
            return $erroresId="El curso con el id proporcionado no existe.";
        }
    }
}

// Funcion para comprobar si el id curso existe
function comprobarCurso($id_curso)
{
    global $existe,$erroresId;
    $conexion = new mysqli("localhost", "root", "", "venta_cursos");
    if ($conexion->connect_error) {
        die("Conexion fallida: " . $conexion->connect_error);
    }

    $stmt = $conexion->prepare("SELECT * FROM cursos WHERE id_curso = ?");
    $stmt->bind_param("i", $id_curso);

    if ($stmt->execute()) {
        // Almacena los resultados en bufer
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $existe = true;
        } else {
            $existe = false;
        }
    } else {
        return $erroresId="Error al comprobar si existe el curso: " . $stmt->error;
    }

    $stmt->close();
    $conexion->close();

    return $existe;
}

// Funcion para modificar los datos del curso seleccionado
function modificarDatos($id_curso, $datos)
{
    global $erroresModificar;
    $conexion = new mysqli("localhost", "root", "", "venta_cursos");
    if ($conexion->connect_error) {
        die("Conexion fallida: " . $conexion->connect_error);
    }

    $stmt = $conexion->prepare("UPDATE cursos SET titulo = ?, descripcion = ?, precio = ? WHERE id_curso = ?");
    $stmt->bind_param("ssdi", $datos['titulo'], $datos['descripcion'], $datos['precio'], $id_curso);

    if ($stmt->execute()) {
        header("Location: ../../fronted/Administrador/Panel_Control.php");
    } else {
        return $erroresModificar="Error al actualizar el curso: " . $stmt->error;
    }

    $stmt->close();
    $conexion->close();
}


procesarFormulario();
?>
