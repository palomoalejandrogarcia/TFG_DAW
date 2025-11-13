<?php

session_start();
//Verificamos que si se ha logueado el usuario con rol de Usuario si no es asi nos redirije al login
if (empty($_SESSION['usuario']) || $_SESSION['rol'] !== 'Usuario') {
    header("Location: ../../fronted/Inicio_Web/Inicio_de_sesion.php");
    exit;
}

//Inicializamos variables
$rutaFinal=null;
$erroresFoto=null;

//Esta funcion lo que hara es que el usuario pueda subir una foto a la pagina y cuando la cuelgue  lo guardamos en la carpeta Perfiles y la proxima vez
//que entre el usuario podra ver su imagen que ha colgado.
function subirImagen()
{
    global $erroresFoto,$rutaFinal;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {

            $archivo = $_FILES['foto'];
            $nombre = $archivo['name'];
            $tipo = $archivo['type'];
            $temporal = $archivo['tmp_name'];

            // Tipos de archivos permitidos
            $permitidos = ['image/jpeg', 'image/png'];

            if (in_array($tipo, $permitidos)) {
                // Ruta donde se almacena las fotos
                $carpetaDestino = "Perfiles/";

                // Verificamos si la carpeta destino existe, si no se crea
                if (!file_exists($carpetaDestino)) {
                    mkdir($carpetaDestino, 0777, true);
                }

                // Crear un nuevo nombre para la imagen
                $nuevoNombre = time() . '_' . basename($nombre);
                $rutaFinal = $carpetaDestino . $nuevoNombre;

                // Mover la imagen a la carpeta destino
                if (move_uploaded_file($temporal, $rutaFinal)) {

                    if (isset($_SESSION['id_usuario'])) {
                        $idUsuario = $_SESSION['id_usuario'];

                        // Conexion a la base de datos
                        $conn = new mysqli("localhost", "root", "", "venta_cursos");

                        if ($conn->connect_error) {
                            $erroresFoto = "Error de conexion a la base de datos.";
                            return;
                        }

                        // Actualizar la base de datos con la ruta de la nueva foto
                        $stmt = $conn->prepare("UPDATE usuarioss SET foto = ? WHERE id_usuario = ?");
                        $stmt->bind_param("si", $rutaFinal, $idUsuario);
                        $stmt->execute();
                        $stmt->close();
                        $conn->close();

                        // Guardar la ruta de la foto en la sesion para mostrarla inmediatamente
                        $_SESSION['foto_perfil'] = $rutaFinal;
                    } else {
                        $erroresFoto = "No se pudo identificar el usuario en sesion.";
                    }

                } else {
                    $erroresFoto = "Error al mover la imagen al directorio.";
                }
            } else {
                $erroresFoto = "Tipo de archivo no permitido. Solo se permiten imagenes JPEG o PNG.";
            }
        } else {
            $erroresFoto = "No se ha enviado una imagen o hubo un error al subirla.";
        }
    }
}
subirImagen();

?>