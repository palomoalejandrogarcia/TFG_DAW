<?php
//Verificamos que si no hay una sesion iniciada que se inicie la sesion
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
//Esta funcion lo que hara es comprobar que el usuario logueado ha comprado cursos o no
function comprobarCantidadCursosUsuario(){
    global $hayCursos;
    $id_usuario=$_SESSION['id_usuario'];

    $conexion = new mysqli("localhost", "root", "", "venta_cursos");
    if ($conexion->connect_error) {
        die("Conexion fallida: " . $conexion->connect_error);
    }

    $stmt = $conexion->prepare("SELECT COUNT(*) FROM cursos_comprados WHERE id_usuario = ?");
    $stmt->bind_param("i", $id_usuario);
    $stmt->execute();
    $stmt->bind_result($hayCursos);
    $stmt->fetch();
    $stmt->close();
}

comprobarCantidadCursosUsuario();