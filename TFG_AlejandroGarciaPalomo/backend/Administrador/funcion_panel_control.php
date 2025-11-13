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

//Esta funcion lo que hara sera eliminar el usuario que hemos seleccionado de la tabla
function eliminarUsuario($id_usuario) {

    $conexion = new mysqli("localhost", "root", "", "venta_cursos");
    // Comprobar si la conexion fue exitosa
    if ($conexion->connect_error) {
        die("Conexion fallida: " . $conexion->connect_error);
    }



    // Preparar la consulta SQL para insertar los datos
    $smt = $conexion->prepare("DELETE FROM usuarioss WHERE id_usuario = ?");
    $smt->bind_param("i", $id_usuario);
    $smt->execute();


    $smt->close();
    $conexion->close();

}

if (isset($_POST['usuario_id_eliminar'])) {
    $id_usuario = $_POST['usuario_id_eliminar'];

    // Llamar a la funcion eliminarUsuario para eliminar al usuario
    eliminarUsuario($id_usuario);
    recorrerUsuarios();
    // Redirigir despues de eliminar el usuario para evitar el reenvio del formulario
    header("Location: Panel_Control.php");
    exit();
}
//Esta funcion lo que hara sera coger los datos del curso que hemos seleccionado de la tabla para modificar sus datos y nos redirije al archivo 'Modificar_curso'
function modificarCurso($id_curso){

    $conexion = new mysqli("localhost", "root", "", "venta_cursos");

    if ($conexion->connect_error) {
        die("Conexion fallida: " . $conexion->connect_error);
    }

    $smt = $conexion->prepare("SELECT * FROM cursos WHERE id_curso = ?");
    $smt->bind_param("i", $id_curso);
    $smt->execute();
    $result = $smt->get_result();
    if ($result->num_rows > 0) {

        // Obtener los datos del usuario
        $usuario = $result->fetch_assoc();

        $_SESSION['id_curso_modificar'] = $usuario['Id_curso'];
        $_SESSION['titulo_modificar'] = $usuario['Titulo'];
        $_SESSION['descripcion_modificar'] = $usuario['Descripcion'];
        $_SESSION['precio_modificar'] = $usuario['Precio'];

        header('Location: ../../fronted/Administrador/Modificar_Curso.php');
        exit;
    } else {
        echo "Usuario no encontrado.";
    }
    //cerramos las conexiones
    $smt->close();
    $conexion->close();

}
//Cuando le demos al boton de añadir curso nos redirijira al archivo 'Añadir curso'
if (isset($_POST['curso_id_anadir'])) {
    header("Location: ../../fronted/Administrador/Añadir_Curso.php");
    exit();
}
//Esta funcion lo que hara sera eliminar el curso que hemos seleccionado de la tabla
function eliminarCurso($id_curso) {
    $conexion = new mysqli("localhost", "root", "", "venta_cursos");
    // Comprobar si la conexion fue exitosa
    if ($conexion->connect_error) {
        die("Conexion fallida: " . $conexion->connect_error);
    }

    $smt = $conexion->prepare("DELETE FROM cursos WHERE id_curso = ?");
    $smt->bind_param("i", $id_curso);
    $smt->execute();


    //Cerramos las conexiones
    $smt->close();
    $conexion->close();

}

if (isset($_POST['curso_id_eliminar'])) {
    $id_curso = $_POST['curso_id_eliminar'];


    eliminarCurso($id_curso);
    recorrerCursos();
    header("Location: Panel_Control.php");
    exit();
}


if (isset($_POST['curso_id_modificar'])) {
    $id_curso = $_POST['curso_id_modificar'];

    // Llamar a la funcion eliminarUsuario para eliminar al usuario
    modificarCurso($id_curso);
    exit(); // Asegura que no se ejecute mas codigo
}
//Esta funcion lo que hara sera coger los datos del usuario que hemos seleccionado de la tabla para modificar sus datos y nos redirije al archivo 'Modificar usuario'
function modificarUsuario($id_usuario)
{
    $conexion = new mysqli("localhost", "root", "", "venta_cursos");
    // Comprobar si la conexion fue exitosa
    if ($conexion->connect_error) {
        die("Conexion fallida: " . $conexion->connect_error);
    }



    // Preparar la consulta SQL para insertar los datos
    $smt = $conexion->prepare("SELECT * FROM usuarioss WHERE id_usuario = ?");
    $smt->bind_param("i", $id_usuario);
    $smt->execute();
    $result = $smt->get_result();
    if ($result->num_rows > 0) {
        // Obtener los datos del usuario
        $usuario = $result->fetch_assoc();

        // Guardar los datos en variables de sesion para su uso en el formulario
        $_SESSION['id_modificar'] = $usuario['id_usuario'];
        $_SESSION['usuario_modificar'] = $usuario['usuario'];
        $_SESSION['nombre_modificar'] = $usuario['nombre'];
        $_SESSION['apellidos_modificar'] = $usuario['apellidos'];
        $_SESSION['correo_modificar'] = $usuario['correo'];
        $_SESSION['edad_modificar'] = $usuario['edad'];

        // Redirigir al formulario de modificacion con los datos del usuario
        header('Location: ../../fronted/Administrador/Modificar_usuario.php');
        exit;
    } else {
        echo "Usuario no encontrado.";
    }


    //cerramos las conexiones
    $smt->close();
    $conexion->close();

}

if (isset($_POST['usuario_id_modificar'])) {
    $id_usuario = $_POST['usuario_id_modificar'];
    modificarUsuario($id_usuario);
    exit();
}



//Esta funcion lo que hara sera mostrar todos los usuarios registrados
function recorrerUsuarios(){
    // Conectar a la base de datos
    $conexion = new mysqli("localhost", "root", "", "venta_cursos");
    // Comprobar si la conexion fue exitosa
    if ($conexion->connect_error) {
        die("Conexion fallida: " . $conexion->connect_error);
    }



    // Preparar la consulta SQL para insertar los datos
    $smt = $conexion->prepare("SELECT * FROM usuarioss WHERE rol = 'Usuario'");

    $smt->execute();
    $resultado = $smt->get_result();

    $usuarios = $resultado->fetch_all(MYSQLI_ASSOC);

    $smt->close();
    $conexion->close();
    return $usuarios;

}


//Esta funcion lo que hara sera mostrar todos los cursos registrados
function recorrerCursos(){


    // Conectar a la base de datos
    $conexion = new mysqli("localhost", "root", "", "venta_cursos");
    // Comprobar si la conexion fue exitosa
    if ($conexion->connect_error) {
        die("Conexion fallida: " . $conexion->connect_error);
    }



    // Preparar la consulta SQL para insertar los datos
    $smt = $conexion->prepare("SELECT * FROM cursos");

    $smt->execute();
    $resultado = $smt->get_result();

    $cursos = $resultado->fetch_all(MYSQLI_ASSOC);

    $smt->close();
    $conexion->close();
    return $cursos;

}

$usuarios = recorrerUsuarios();


$cursos = recorrerCursos();
?>
