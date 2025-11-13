<?php
//Inicializamos las variables
$errores = "";
$conexion = new mysqli("localhost", "root", "", "venta_cursos");
//Esta funcion lo que hara es controlar el formulario de posibles errores
function procesarDatos() {
    global $errores;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $usuario = htmlspecialchars($_POST['usuario']);
        $contraseña = $_POST['contraseña'];
        $nueva_contraseña = $_POST['nueva_contraseña'];
        $repetir_contraseña = $_POST['repite_contraseña'];


        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z0-9*]{5,15}$/', $contraseña)) {
            return $errores = "La contraseña debe tener entre 5 y 15 caracteres, incluir al menos una letra mayuscula, una minuscula y un numero (Se permite introducir *).";
        }


        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z0-9*]{5,15}$/', $nueva_contraseña)) {
            return $errores="La contraseña debe tener entre 5 y 15 caracteres, incluir al menos una letra mayuscula, una minuscula y un numero (Se permite introducir *).";
        }

        if ($nueva_contraseña !== $repetir_contraseña) {
            return $errores="Las contraseñas no coinciden";
        }

        actualizarContraseña($usuario,$contraseña,$nueva_contraseña);

    }
}

//Esta funcion lo que hara es cambiar la contraseña que esta almacenada en la base de datos por una nueva
function actualizarContraseña($usuario,$contraseña,$nueva_contraseña){

    global $errores, $conexion;

    $stmt = $conexion->prepare("SELECT contraseña FROM usuarioss WHERE usuario = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $fila = $resultado->fetch_assoc();
        $contrasena_hash = $fila['contraseña'];

        // Verificar si la contraseña actual coincide con la almacenada
        if (password_verify($contraseña, $contrasena_hash)) {
            // Cifrar la nueva contraseña
            $nueva_contrasena_hash = password_hash($nueva_contraseña, PASSWORD_DEFAULT);

            // Actualizar la contraseña en la base de datos
            $actualizarContraseña = $conexion->prepare("UPDATE usuarioss SET contraseña = ? WHERE usuario = ?");
            $actualizarContraseña->bind_param("ss", $nueva_contrasena_hash, $usuario);
            $actualizarContraseña->execute();

            header("Location: ../../fronted/Inicio_Web/Inicio_de_sesion.php");
            $stmt->close();
            exit();
        } else {
            return $errores = "La contraseña actual es incorrecta";
        }

    } else {
        return $errores = "El usuario no existe";
    }
}

// Llamar a la funcion para procesar el formulario
procesarDatos();
?>
