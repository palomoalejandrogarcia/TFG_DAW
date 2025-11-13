<?php
session_start();
//Verificamos que si se ha logueado el usuario con rol de Usuario si no es asi nos redirije al login de la pagina
if (empty($_SESSION['usuario']) || $_SESSION['rol'] !== 'Usuario') {
    header("Location: ../../fronted/Inicio_Web/Inicio_de_sesion.php");
    exit;
}

//Inicializamos las variables
$cursos=[];
$estado=null;
$precioTotalCurso=0;
$tipoFiltro=null;
$errorDescuento=null;

if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

//Esta funcion lo que hara sera que cada vez que se le da al boton de carrito añade en el carrito el curso se guardara en el carrito
function anadirCarritoCursos($idCurso, $titulo, $precio) {
    global $estado;

    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];
    }

    // Verificar si el curso ya está en el carrito
    foreach ($_SESSION['carrito'] as $cursoCarrito) {
        if ($cursoCarrito['id'] == $idCurso) {
            $_SESSION['mensaje'] = "Este curso ya está en el carrito.";
            return;
        }
    }

    // Añadir el curso
    $curso = [
        'id' => $idCurso,
        'titulo' => htmlspecialchars($titulo),
        'precio' => $precio
    ];
    $_SESSION['carrito'][] = $curso;

    // Recalcular totales
    $precioTotalCurso = 0;
    $_SESSION['contador_Curso'] = 0;
    foreach ($_SESSION['carrito'] as $cursoCarrito) {
        $precioTotalCurso += $cursoCarrito['precio'];
        $_SESSION['contador_Curso']++;
    }

    $_SESSION['precioTotalCurso_carrito'] = $precioTotalCurso;
    $_SESSION['estado'] = 'carrito';
    $estado = 'carrito';
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['comprar_curso']) && isset($_POST['id_curso'])) {
        $idCurso = $_POST['id_curso'];
        $idUsuario = $_SESSION['id_usuario'];

        if (usuarioYaTieneCurso($idUsuario, $idCurso)) {
            $_SESSION['mensaje_error'] = "⚠️ Ya tienes este curso comprado.";
            header("Location: Cursos.php");
            exit;
        } else {
            $_SESSION['curso_seleccionado'] = [
                'id' => $_POST['id_curso'],
                'titulo' => $_POST['titulo'],
                'descripcion' => $_POST['descripcion'],
                'precio' => $_POST['precio'],
                'creado_por' => $_POST['creado_por']
            ];

            header("Location: ../../fronted/Usuario/Curso.php");
            exit;
        }
    }
}


//Esta funcion lo que hara es eliminar un curso del carrito
function eliminarCursosCarrito()
{
    global $precioTotalCurso;
    if (isset($_POST['id_curso_eliminar'])) {
        $idEliminar = $_POST['id_curso_eliminar'];
        foreach ($_SESSION['carrito'] as $index => $curso) {
            if ($curso['id'] == $idEliminar) {
                unset($_SESSION['carrito'][$index]);
                // Reindexar el array
                $_SESSION['carrito'] = array_values($_SESSION['carrito']);
                break;
            }
        }
        // Recalcular el total del carrito despues de eliminar el curso del carrito
        $precioTotalCurso = 0;
        foreach ($_SESSION['carrito'] as $curso) {
            $precioTotalCurso += $curso['precio'];  // Sumar el precio de los cursos restantes
        }

        // Guardar el nuevo total en la sesion
        $_SESSION['precioTotalCurso_carrito'] = $precioTotalCurso;

    }
}
//Esta funcion lo que hara es comrpobar si el usuario logueado ya tiene el curso que ha seleccionado
function usuarioYaTieneCurso($idUsuario, $idCurso) {
    $conexion = new mysqli("localhost", "root", "", "venta_cursos");

    // Verificar conexion
    if ($conexion->connect_error) {
        die("Conexion fallida: " . $conexion->connect_error);
    }

    $stmt = $conexion->prepare("SELECT COUNT(*) FROM cursos_comprados WHERE id_usuario = ? AND id_curso = ?");
    $stmt->bind_param("ii", $idUsuario, $idCurso);
    $stmt->execute();
    $stmt->bind_result($contador);
    $stmt->fetch();

    $stmt->close();
    $conexion->close();

    return $contador > 0;
}


//Esta funcion lo que hara sera sacar todos los cursos dependiendo de el filtro que seleccionemos
function obtenerTodosCursos($tipoFiltro = null) {
    // Si no se pasa un filtro, obtener el filtro guardado en la sesion
    if ($tipoFiltro === null && isset($_SESSION['tipo_filtro'])) {
        $tipoFiltro = $_SESSION['tipo_filtro'];
    }

    // Conectar a la base de datos
    $conexion = new mysqli("localhost", "root", "", "venta_cursos");
    // Comprobar si la conexion fue exitosa
    if ($conexion->connect_error) {
        die("Conexion fallida: " . $conexion->connect_error);
    }

    // Sentencia SQL para obtener todos los cursos
    $sql = "SELECT * FROM cursos";
    switch ($tipoFiltro){
        case "titulo_ascendente":
            $sql .= " ORDER BY Titulo ASC";
            break;
        case "titulo_descendente":
            $sql .= " ORDER BY Titulo DESC";
            break;
        case "precio_ascendente":
            $sql .= " ORDER BY Precio ASC";
            break;
        case "precio_descendete":
            $sql .= " ORDER BY Precio DESC";
            break;
        case "curso_no_comprado":
            $idUsuario = $_SESSION['id_usuario'];
            $sql = "
                SELECT * FROM cursos 
                WHERE Id_curso NOT IN (
                    SELECT id_curso 
                    FROM cursos_comprados 
                    WHERE id_usuario = $idUsuario
                )
            ";
            break;
    }


    $resultado = $conexion->query($sql);

    $cursos = [];

    if ($resultado && $resultado->num_rows > 0) {
        while ($row = $resultado->fetch_assoc()) {
            $cursos[] = $row;
        }
    }

    // Cerrar la conexion
    $conexion->close();

    return $cursos;
}



//para mostrar y actualizar los cursos cuando se busca o no
function renderizarCursos($cursos) {
    foreach ($cursos as $curso) {
        echo '<div class="bg-white shadow-lg rounded-lg overflow-hidden relative">';
        echo '    <div class="relative">';
        echo '<img src="' . htmlspecialchars($curso['Foto']) . '" alt="Curso" class="w-full h-40 object-cover">';
        echo '        <form method="POST">';
        echo '            <input type="hidden" name="curso_id_añadir" value="' . htmlspecialchars($curso['Id_curso']) . '">';
        echo '            <input type="hidden" name="Titulo" value="' . htmlspecialchars($curso['Titulo']) . '">';
        echo '            <input type="hidden" name="Precio" value="' . htmlspecialchars($curso['Precio']) . '">';
        echo '            <button type="submit" id="carritoBtn" class="absolute top-2 right-2 bg-blue-700 text-white rounded-full p-2 hover:bg-blue-800 transition duration-300" title="Añadir al carrito">🛒</button>';
        echo '        </form>';
        echo '    </div>';
        echo '    <div class="p-4">';
        echo '        <h3 class="text-xl font-semibold">' . htmlspecialchars($curso['Titulo']) . '</h3>';
        echo '        <p class="text-gray-600">' . htmlspecialchars($curso['Descripcion']) . '</p>';
        echo '       <form method="POST">
                <input type="hidden" name="comprar_curso" value="1">
                <input type="hidden" name="id_curso" value="' . htmlspecialchars($curso['Id_curso']) . '">
                <input type="hidden" name="titulo" value="' . htmlspecialchars($curso['Titulo']) . '">
                <input type="hidden" name="descripcion" value="' . htmlspecialchars($curso['Descripcion']) . '">
                <input type="hidden" name="precio" value="' . htmlspecialchars($curso['Precio']) . '">
                <input type="hidden" name="creado_por" value="' . htmlspecialchars($curso['Creado_por']) . '">
                <input type="hidden" name="foto" value="' . htmlspecialchars($curso['Foto']) . '">
                <button type="submit" class="text-center block w-full bg-blue-700 hover:bg-blue-800 text-white font-semibold py-2 mt-4 rounded shadow transition duration-200">

                    Comprar
                </button>
            </form>';
        echo '    </div>';
        echo '</div>';
    }
}
function tipoFiltro() {
    // Verifica si se ha enviado el formulario para aplicar el filtro
    if (isset($_POST['enviar_filtro']) && isset($_POST['filtro_aplicado'])) {
        if (!empty($_POST['tipo_filtro'])) {
            // Obtenemos el tipo de filtro seleccionado
            $categoriaSeleccionada = $_POST['tipo_filtro'];
            // Guarda el filtro en la sesion para que persista
            $_SESSION['tipo_filtro'] = $categoriaSeleccionada;
            echo "Filtro activado<br>";
            echo "Categoria seleccionada: " . htmlspecialchars($categoriaSeleccionada) . "<br>";
            return $categoriaSeleccionada;
        }
    }
    // Si no se aplica ningun filtro, retornar el valor a null
    return null;
}




//para filtrar las cosas
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['enviar_filtro'])) {
    $tipo = tipoFiltro();
    $cursos = obtenerTodosCursos($tipo);
    // Ya no se imprime aquí, solo se guarda en $cursos
} else {
    $cursos = obtenerTodosCursos();
    // Se muestra todos los cursos sin filtro
}

//comprobar cuadno se añada al carrito
if (isset($_POST['curso_id_añadir'])) {
    $idCurso = $_POST['curso_id_añadir'];
    $titulo = $_POST['Titulo'];
    $precio = $_POST['Precio'];
    $idUsuario = $_SESSION['id_usuario'];

    if (usuarioYaTieneCurso($idUsuario, $idCurso)) {
        $errorDescuento = "Ya tienes este curso comprado.";
    } else {
        anadirCarritoCursos($idCurso, $titulo, $precio);
    }
}
//funcion para eliminar curso del carrito
eliminarCursosCarrito();

//funcion para aplicar el codigo de descuento
if (isset($_POST['enviarcodigo'])) {
    $codigoIntro = trim($_POST['codigo']); // Eliminar espacios adicionales al principio y al final

    if ($codigoIntro < 0 || $codigoIntro > 999) {
        return $errorDescuento = "Solo se permiten numeros de 3 digitos.";
    }
    if (!preg_match('/^\d+$/', $codigoIntro)) {
        return $errorDescuento="Solo se permiten numeros positivos.";
    }

    if ($codigoIntro === "000") {
        // Aplicar descuento
        $_SESSION['precioTotalCurso_carrito'] -= 20;
        $mensajeDescuento = "¡Descuento aplicado!";
        $_SESSION['Aplicado'] = true;
    } else {
        // Mostrar mensaje de error si el codigo es incorrecto
        $errorDescuento = " Codigo invalido.";
        $_SESSION['Aplicado'] = false;
    }
}


?>