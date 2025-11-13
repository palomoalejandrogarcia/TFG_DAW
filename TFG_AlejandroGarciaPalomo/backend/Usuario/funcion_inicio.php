<?php
session_start();
//Verificamos que si se ha logueado el usuario con rol de Usuario si no es asi nos redirije al login de la pagina
if (empty($_SESSION['usuario']) || $_SESSION['rol'] !== 'Usuario') {
    header("Location: ../../fronted/Inicio_Web/Inicio_de_sesion.php");
    exit;
}
?>
