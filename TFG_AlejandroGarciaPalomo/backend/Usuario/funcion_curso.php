<?php
session_start();
//Verificamos que si se ha logueado el usuario con rol de Usuario si no es asi nos redirije al login de la pagina
if (empty($_SESSION['usuario']) || $_SESSION['rol'] !== 'Usuario') {
    header("Location: ../../fronted/Inicio_Web/Inicio_de_sesion.php");
    exit;
}
//Inicializamos las variables
$estado='compra';
$curso = $_SESSION['curso_seleccionado'];

//Esta funcion lo que hace es mostrarnos el nombre del autor que creo el curso que hemos seleccionado
function cambiarIdPorNombre($cursoId)
{

    // Conectar a la base de datos
    $conexion = new mysqli("localhost", "root", "", "venta_cursos");
    // Comprobar si la conexion fue exitosa
    if ($conexion->connect_error) {
        die("Conexion fallida: " . $conexion->connect_error);
    }

    $smt = $conexion->prepare("
        SELECT cursos.id_curso, cursos.titulo, cursos.descripcion,cursos.foto, cursos.precio, usuarioss.nombre ,cursos.foto
        FROM cursos
        INNER JOIN usuarioss ON cursos.creado_por = usuarioss.id_usuario
        WHERE cursos.id_curso = ?
    ");

    $smt->bind_param("i", $cursoId);

    $smt->execute();


    $resultado = $smt->get_result();

    if ($resultado->num_rows > 0) {
        $curso = $resultado->fetch_assoc();
    } else {
        $curso = null;
    }

    // Cerramos conexiones
    $smt->close();
    $conexion->close();

    return $curso;
}
$curso = cambiarIdPorNombre(htmlspecialchars($curso['id']));
?>