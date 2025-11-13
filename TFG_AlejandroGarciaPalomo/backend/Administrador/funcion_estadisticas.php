
<?php
session_start();

//Inicializamos las variables
$numeroUsuarios = 0;
$numeroCursos = 0;
$cursoMasVendido = "";
$precioTotalCursos=0;
$comprasRealizadasHoy=0;

//Verificamos que si se ha logueado el usuario con rol de administrador si no es asi nos redirije al login de la pagina
if(empty($_SESSION['usuario']) ||  $_SESSION['rol'] !=='Administrador'){
    header("Location: ../../fronted/Inicio_Web/Inicio_de_sesion.php");
exit;
}
//Esta funcion lo que hara es mostrar el numeros de los usuarios registrados con Rol 'Usuario'
function totalUsuarios(){
    global $numeroUsuarios;
    $conexion = new mysqli("localhost", "root", "", "venta_cursos");

    if ($conexion->connect_error) {
        die("Conexion fallida: " . $conexion->connect_error);
    }


    $sql = "SELECT COUNT(*) AS total_usuarios FROM usuarioss WHERE rol='Usuario' ";
    $resultado = $conexion->query($sql);

    if ($resultado && $resultado->num_rows > 0) {
        $fila = $resultado->fetch_assoc();
        $numeroUsuarios = $fila['total_usuarios'];
    } else {
        $numeroUsuarios = 0;
    }
    //cerramos la conexion
    $conexion->close();
}

//Esta funcion lo que hara es mostrar el numeros de los cursos creados
function totalCursos(){
    global $numeroCursos;
    $conexion = new mysqli("localhost", "root", "", "venta_cursos");
// Comprobar si la conexion fue exitosa
    if ($conexion->connect_error) {
        die("Conexion fallida: " . $conexion->connect_error);
    }

    $sql = "SELECT COUNT(*) AS total_cursos FROM cursos ";
    $resultado = $conexion->query($sql);

    if ($resultado && $resultado->num_rows > 0) {
        $fila = $resultado->fetch_assoc();
        $numeroCursos = $fila['total_cursos'];
    } else {
        $numeroCursos = 0;
    }
    //cerramos la conexion
    $conexion->close();
}
//Esta funcion lo que hara es mostrar el curso que mas se ha vendido
function cursoMasVendido(){
    global $cursoMasVendido;
    $conexion = new mysqli("localhost", "root", "", "venta_cursos");

    if ($conexion->connect_error) {
        die("Conexion fallida: " . $conexion->connect_error);
    }

    $sql = "SELECT c.titulo AS curso, COUNT(*) AS total_ventas
            FROM cursos_comprados cc
            JOIN cursos c ON cc.id_curso = c.id_curso
            GROUP BY cc.id_curso
            ORDER BY total_ventas DESC
            LIMIT 1";

    $resultado = $conexion->query($sql);

    if ($resultado && $resultado->num_rows > 0) {
        $fila = $resultado->fetch_assoc();
        $cursoMasVendido = $fila['curso'];
    } else {
        $cursoMasVendido = "";
    }
    $conexion->close();
}
// Esta funcion muestra el total de dinero recaudado
function ingresosPagina(){
    global $precioTotalCursos;
    $conexion = new mysqli("localhost", "root", "", "venta_cursos");    if ($conexion->connect_error) {
        die("Conexion fallida: " . $conexion->connect_error);
    }
    $sql = "SELECT SUM(c.precio) AS total_ventas
FROM cursos_comprados cc
JOIN cursos c ON cc.id_curso = c.id_curso";

    $resultado = $conexion->query($sql);
    $fila = $resultado->fetch_assoc();
    $precioTotalCursos = (float)$fila['total_ventas'] ?? 0;

    $conexion->close();

}
// Esta funcion muestra el numero de compras que se han realizado en el dia de hoy
function comprasRealizadasHoy(){
    global $comprasRealizadasHoy;
    $conexion = new mysqli("localhost", "root", "", "venta_cursos");
    if ($conexion->connect_error) {
        die("Conexion fallida: " . $conexion->connect_error);
    }


    $sql = "SELECT COUNT(id_compra) as total
            FROM cursos_comprados
            WHERE DATE(fecha_compra) = CURDATE()";
    $resultado = $conexion->query($sql);
    $fila = $resultado->fetch_assoc();
    $comprasRealizadasHoy = $fila['total'] ?? 0;
    $conexion->close();

}
// Esta funcion muestra el numero de compras de cada pais
function paisesCompras() {
    $conexion = new mysqli("localhost", "root", "", "venta_cursos");
    if ($conexion->connect_error) {
        die("Conexion fallida: " . $conexion->connect_error);
    }

    $sql = "SELECT pais, COUNT(id_compra) AS numero_de_compras
            FROM cursos_comprados
            GROUP BY pais
            ORDER BY numero_de_compras DESC";

    $resultado = $conexion->query($sql);

    $datos = array();

    if ($resultado->num_rows > 0) {
        while($fila = $resultado->fetch_assoc()) {
            $datos[] = $fila;
        }
    }

    $conexion->close();

    return $datos;
}

// Esta funcion muestra los usuarios registrados en los ultimos 5 dias
function usuariosRegistradosUltimos5Dias() {
    $conexion = new mysqli("localhost", "root", "", "venta_cursos");
    if ($conexion->connect_error) {
        die("Conexion fallida: " . $conexion->connect_error);
    }

    $sql = "SELECT usuario, hora_registro 
            FROM usuarioss 
            WHERE hora_registro >= DATE_SUB(CURDATE(), INTERVAL 4 DAY)
            ORDER BY hora_registro DESC";

    $resultado = $conexion->query($sql);
    $usuarios = [];

    if ($resultado && $resultado->num_rows > 0) {
        while ($fila = $resultado->fetch_assoc()) {
            $usuarios[] = [
                'nombre' => $fila['usuario'],
                'fecha' => $fila['hora_registro']
            ];
        }
    }

    $conexion->close();
    return $usuarios;
}




$usuariosRecientes = usuariosRegistradosUltimos5Dias();
$datos=paisesCompras();
ingresosPagina();
totalUsuarios();
totalCursos();
cursoMasVendido();
comprasRealizadasHoy();
?>
