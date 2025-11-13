<?php

session_start();
//Verificamos que si se ha logueado el usuario con rol de Usuario si no es asi nos redirije al login
if (empty($_SESSION['usuario']) || $_SESSION['rol'] !== 'Usuario') {
    header("Location: ../../fronted/Inicio_Web/Inicio_de_sesion.php");
    exit;
}
//Esta funcion lo que hara sera mostrar los cursos que ha comprado el usuario logueado
function cargarCursosUsuario() {

    $id_usuario = $_SESSION['id_usuario'];

    // Conectar a la base de datos
    $conexion = new mysqli("localhost", "root", "", "venta_cursos");
    // Comprobar si la conexion fue exitosa
    if ($conexion->connect_error) {
        die("Conexion fallida: " . $conexion->connect_error);
    }

    $smt = $conexion->prepare("SELECT c.* FROM cursos c INNER JOIN cursos_comprados cc ON c.id_curso = cc.id_curso WHERE cc.id_usuario = ?");
    $smt->bind_param("i", $id_usuario);
    $smt->execute();
    $resultado = $smt->get_result();

    $cursos = $resultado->fetch_all(MYSQLI_ASSOC);

    $smt->close();
    $conexion->close();

    return $cursos;
}


//Redirigir y ver el curso que hemos seleccionado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
// Asignamos los valores del curso seleccionado a un array sesion
    if (isset($_POST['id_curso'])) {
        $_SESSION['curso_seleccionado'] = [
            'id' => $_POST['id_curso'],
            'titulo' => $_POST['titulo'],
            'descripcion' => $_POST['descripcion'],
            'precio' => $_POST['precio'],
            'creado_por' => $_POST['creado_por']
        ];

        // Redirigir al curso despues de asignar los valores
        header("Location: ../../fronted/Usuario/Ver_Curso.php");

        exit;
    }
}

$cursos=cargarCursosUsuario();
?>