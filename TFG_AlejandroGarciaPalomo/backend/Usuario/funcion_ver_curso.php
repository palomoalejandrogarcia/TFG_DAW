<?php
session_start();
//Verificamos que si se ha logueado el usuario con rol de Usuario si no es asi nos redirije al login
if (empty($_SESSION['usuario']) || $_SESSION['rol'] !== 'Usuario') {
    header("Location: ../../fronted/Inicio_Web/Inicio_de_sesion.php");
    exit;
}

//Inicializamos las variables
$id=$_SESSION['curso_seleccionado']['id'];
$apartadoCurso=[];


//Esta funcion lo que hara sera mostrar el contenido de el curso seleccionado(apartados,recursos,descripcion,etc...)
function informacionCurso(){
    global $apartadoCurso, $id;

    // Conectar a la base de datos
    $conexion = new mysqli("localhost", "root", "", "venta_cursos");
    // Verificar la conexion
    if ($conexion->connect_error) {
        die("Conexion fallida: " . $conexion->connect_error);
    }

    // Consultar todos los apartados del curso
    $stmt = $conexion->prepare("SELECT id_apartado, titulo_apartado, descripcion FROM apartados_curso WHERE id_curso = ?");
    $stmt->bind_param("i", $id); // El parametro id es un entero
    $stmt->execute();
    $result = $stmt->get_result();


    // Iterar sobre los apartados y obtener los recursos asociados
    while ($row = $result->fetch_assoc()) {
        $apartado = [
            'id_apartado' => $row['id_apartado'],
            'titulo_apartado' => $row['titulo_apartado'],
            'descripcion' => $row['descripcion'],
            'recursos' => [] // Iniciar el array de recursos
        ];

        // Consultar los recursos del apartado
        $stmt_recurso = $conexion->prepare("SELECT tipo_recurso, titulo, url FROM recursos_apartado WHERE id_apartado = ?");
        $stmt_recurso->bind_param("i", $row['id_apartado']);
        $stmt_recurso->execute();
        $result_recurso = $stmt_recurso->get_result();

        // Guardar los recursos en el apartado
        while ($recurso = $result_recurso->fetch_assoc()) {
            $apartado['recursos'][] = [
                'tipo_recurso' => $recurso['tipo_recurso'],
                'titulo' => $recurso['titulo'],
                'url' => $recurso['url']
            ];
        }

        // Añadir el apartado al array de apartados
        $apartadoCurso[] = $apartado;

        // Cerrar la consulta preparada de los recursos
        $stmt_recurso->close();
    }

    // Cerrar la consulta preparada de los apartados y la conexion
    $stmt->close();
    $conexion->close();


}

informacionCurso();