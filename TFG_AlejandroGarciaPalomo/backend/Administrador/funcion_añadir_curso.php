<?php
session_start();

//Verificamos si el usuario ha iniciado sesion si no se redirije al inicio de sesion
//Verificamos que si se ha logueado un usuario con rol de 'Usuario' si no es asi nos redirije al login de la pagina
if(empty($_SESSION['usuario']) ||  $_SESSION['rol'] !=='Administrador'){
    header("Location: ../../fronted/Inicio_Web/Inicio_de_sesion.php");
exit;
}
$mensajeCurso = null;

//verificamos si se ha enviado el formulario mediante POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //establecemos conexion con la base de datos
    $conexion = new mysqli("localhost", "root", "", "venta_cursos");
    if ($conexion->connect_error) {
        die("Conexion fallida: " . $conexion->connect_error);
    }

    ///Se inicializa los valores recibidos del formulario
    $tituloCurso = $_POST['titulo'] ?? '';
    $descripcionCurso = $_POST['descripcion'] ?? '';
    $precioCurso = $_POST['precio'] ?? '';
    $id_usuario = $_SESSION['id_usuario'] ?? null;
    $foto = $_POST['url_foto'] ?? '';

    //Se controla el formulario de los apartado titulo,descripcion y id_usuario
    if (!preg_match('/^[A-Za-zÁÉÍÓÚÜáéíóúüÑñ\s]{1,100}$/u', $tituloCurso)) {
        return  $mensajeCurso = "El titulo solo debe contener letras y espacios con un maximo de 100 caracteres.";
    }
    $descripcion = trim($_POST['descripcion']);
    if (!preg_match('/^[A-Za-zÁÉÍÓÚÜáéíóúüÑñ0-9\s,;.!?&()\-]{1,200}$/u', $descripcion)) {
        return $mensajeCurso = "La descripcion solo puede contener letras, numeros, espacios y algunos signos de puntuacion, con un maximo de 200 caracteres.";
    }
    if (!is_numeric($id_usuario)) {
        return  $mensajeCurso="El precio tiene que ser numerico";
    }

    // Comprobar de que el curso tenga al menos un apartado
    if (!isset($_POST['apartado_titulo']) || !is_array($_POST['apartado_titulo']) || count($_POST['apartado_titulo']) === 0) {
        $mensajeCurso = "Tienes que añadir al menos un apartado antes de crear el curso.";
    } else {
        $apartadosValidos = true;
        foreach ($_POST['apartado_titulo'] as $i => $titulo_apartado) {
            // Se controla el titulo del apartado
            if (!preg_match('/^[A-Za-zÁÉÍÓÚÜáéíóúüÑñ\s]{1,100}$/u', $titulo_apartado)) {
                $mensajeCurso = "El titulo solo debe contener letras y espacios con un maximo de 100 caracteres.";
                $apartadosValidos = false;
                break;
            }


            // Comprobar de que el apartado tenga al menos un recurso
            if (
                !isset($_POST['tipo_recurso'][$i]) || !is_array($_POST['tipo_recurso'][$i]) ||
                count($_POST['tipo_recurso'][$i]) === 0
            ) {
                $mensajeCurso = "Cada apartado debe tener al menos un recurso.";
                $apartadosValidos = false;
                break;
            }
        }
        //Si no hay ningun problema, se inserta el curso creado
        if ($apartadosValidos && $id_usuario !== null) {
            $stmt = $conexion->prepare("INSERT INTO cursos (titulo, descripcion, precio,foto, creado_por, hora_creacion) VALUES (?, ?, ?,?, ?, NOW())");
            $stmt->bind_param("ssdsi", $tituloCurso, $descripcionCurso, $precioCurso, $foto,$id_usuario);
            $stmt->execute();
            $id_curso = $stmt->insert_id;
            $stmt->close();

            // Registramos los apartados de el curso a la base de datos y controlamos el formulario de la parte de los apartados
            foreach ($_POST['apartado_titulo'] as $i => $titulo_apartado) {
                $descripcion_apartado = $_POST['apartado_descripcion'][$i] ?? '';
                //Verificar como es la descripcion
                if (!preg_match('/^[A-Za-zÁÉÍÓÚÜáéíóúüÑñ0-9\s,;.!?&()\-]{1,200}$/u', $descripcion_apartado)) {
                    return $mensajeCurso = "La descripcion solo puede contener letras, numeros, espacios con un maximo de 200 caracteres.";
                }
                // Registramos los apartados añadidos del curso que se ha creado a la base de datos
                $stmt = $conexion->prepare("INSERT INTO apartados_curso (id_curso, titulo_apartado, descripcion) VALUES (?, ?, ?)");
                $stmt->bind_param("iss", $id_curso, $titulo_apartado, $descripcion_apartado);
                $stmt->execute();
                $id_apartado = $stmt->insert_id;
                $stmt->close();

                // Insertar los recursos del apartado y controlamos el formulario de los recursos
                foreach ($_POST['tipo_recurso'][$i] as $j => $tipo) {
                    $tituloRecurso = $_POST['titulo_recurso'][$i][$j] ?? '';
                    $url = $_POST['url_recurso'][$i][$j] ?? '';

                    if (!preg_match('/^[A-Za-zÁÉÍÓÚÜáéíóúüÑñ\s]{1,100}$/u', $tituloRecurso)) {
                        return  $mensajeCurso = "El titulo del recurso solo debe contener letras y espacios con un maximo de 100 caracteres.";
                    }
                    if (!empty($tituloRecurso) && !empty($url)) {
                        $stmt = $conexion->prepare("INSERT INTO recursos_apartado (id_apartado, tipo_recurso, titulo, url) VALUES (?, ?, ?, ?)");
                        $stmt->bind_param("isss", $id_apartado, $tipo, $tituloRecurso, $url);
                        $stmt->execute();
                        $stmt->close();
                    }
                }
            }
            //Si no hay ningun error se redirije al panel de control
            header('Location: ../../fronted/Administrador/Panel_Control.php');
            exit;
        }
    }
}
?>