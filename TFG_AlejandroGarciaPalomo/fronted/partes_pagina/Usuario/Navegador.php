<?php
global $hayCursos;
// Definimos la ruta base para usar rutas absolutas
define('BASE_URL', '/TFG_AlejandroGarciaPalomo/fronted/');
//Importamos las funciones del backend
require(__DIR__ . '/../../../backend/Funciones_comunes/funcion_navegacion.php');
?>

<!-- Navegador -->
<header class="w-full bg-blue-700 text-gray-100 py-4 shadow-md fixed top-0 left-0 z-50 border-b border-blue-900">
    <div class="w-full overflow-x-auto px-4">
        <nav class="flex items-center justify-center space-x-6 text-sm sm:text-base whitespace-nowrap min-w-max">
            <!-- Nombre del usuario logueado -->
            <a href="<?= BASE_URL ?>Usuario/Perfil.php" class="flex items-center hover:underline">
                <img src="<?= BASE_URL ?>Imagenes/perfil.png" alt="Imagen de perfil" width="24" height="24" class="mr-2 rounded-full">
                <span><?php echo $_SESSION['usuario']; ?></span>
            </a>

            <!-- Apartado Inicio -->
            <a href="<?= BASE_URL ?>Usuario/Inicio.php" class="hover:underline">Inicio</a>

            <!-- Apartado Cursos -->
            <a href="<?= BASE_URL ?>Usuario/Cursos.php" class="hover:underline">Cursos</a>

            <!-- Apartado Cursos comprados -->
            <?php if ($hayCursos > 0): ?>
                <a href="<?= BASE_URL ?>Usuario/Mis_cursos.php" class="hover:underline">Mis cursos</a>
            <?php endif; ?>

            <!-- Apartado Perfil -->
            <a href="<?= BASE_URL ?>Usuario/Perfil.php" class="hover:underline">Perfil</a>

            <!-- Apartado cerrar sesión -->
            <a href="/TFG_AlejandroGarciaPalomo/backend/Funciones_comunes/funcion_cerrar_sesion.php" class="flex items-center hover:opacity-75">
                <img src="<?= BASE_URL ?>Imagenes/cerrar-sesion.png" class="w-6 h-6 mr-1 min-w-[1.5rem]" alt="Cerrar sesión">
            </a>
        </nav>
    </div>
</header>
