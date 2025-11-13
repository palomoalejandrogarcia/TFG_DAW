<?php
session_start();
//Verificamos que si se ha logueado el usuario con rol de administrador o usuario, si no es asi nos redirije al login de la pagina
if (empty($_SESSION['usuario']) || ($_SESSION['rol'] !== 'Administrador' && $_SESSION['rol'] !== 'Usuario')) {
    header("Location: ../../fronted/Inicio_Web/Inicio_de_sesion.php");
    exit;
}
//cogemos el nombre del usuario logueado
$usuario = $_SESSION['usuario'];
// Almacenamos el valor de la variable de sesion 'usuario' en una cookie que expirara en 1 hora
setcookie('cookie_usuario', $usuario, time() + 3600, "/");

session_unset();//destruimos las variables de la sesion
session_destroy();//destruimos la sesion
// Redirigimos al usuario a la pagina de inicio de sesion
header("Location: ../../fronted/Inicio_Web/Inicio_de_sesion.php");
exit;
