<?php
// Definimos la ruta base para usar rutas absolutas
define('BASE_URL', '/TFG_AlejandroGarciaPalomo/fronted/');
?>

<!-- Navegador -->
<header class="w-full bg-blue-700 text-gray-100 py-4 shadow-md fixed top-0 left-0 z-50 border-b border-blue-900">
    <div class="w-full overflow-x-auto px-4">
        <nav class="flex items-center justify-center space-x-6 text-sm sm:text-base whitespace-nowrap min-w-max">
            <!-- Nombre del usuario logueado -->
            <a class="flex items-center hover:underline">
                <img src="<?= BASE_URL ?>Imagenes/perfil.png" alt="Imagen de perfil" width="24" height="24" class="mr-2 rounded-full">
                <span><?php echo $_SESSION['usuario']; ?></span>
            </a>
            <!-- Apartado panel de control -->
            <a href="<?= BASE_URL ?>Administrador/Panel_Control.php" class="hover:underline">Panel de control</a>

            <!-- Apartado estadisticas -->
            <a href="<?= BASE_URL ?>Administrador/Estadisticas.php" class="hover:underline">Estadisticas</a>

            <!-- Apartado cerrar sesion -->
            <a href="/TFG_AlejandroGarciaPalomo/backend/Funciones_comunes/funcion_cerrar_sesion.php" class="flex items-center hover:opacity-75">
                <img src="<?= BASE_URL ?>Imagenes/cerrar-sesion.png" class="w-6 h-6 mr-1 min-w-[1.5rem]" alt="Cerrar sesión">
            </a>
        </nav>
    </div>
</header>
