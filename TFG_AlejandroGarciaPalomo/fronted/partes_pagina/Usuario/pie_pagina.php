<?php
// Si no esta definido la ruta base,se definira automaticamente
if (!defined('BASE_URL')) {
    define('BASE_URL', '/TFG_AlejandroGarciaPalomo/fronted/');
}
?>

<!-- Pie de pagina -->
<footer class="bg-blue-700 text-gray-100 py-6 mt-auto relative z-10 border-t border-blue-900">
    <div class="w-full px-4 text-center">
        <!-- Copyright -->
        <p class="text-sm mb-2">&copy; <?= date('Y') ?> LeaToMaster. Todos los derechos reservados.</p>
        <!-- Apartados de las politicas y avisos legales  -->
        <p class="text-xs sm:text-sm space-x-1 whitespace-nowrap overflow-auto">
            <a href="<?= BASE_URL ?>Usuario/Politicas/Politica_privacidad.php" class="hover:underline ">Politica de privacidad</a> |
            <a href="<?= BASE_URL ?>Usuario/Politicas/Politica_devolucion.php" class="hover:underline ">Politica de devolucion</a> |
            <a href="<?= BASE_URL ?>Usuario/Politicas/Politica_cookies.php" class="hover:underline ">Politica de cookies</a> |
            <a href="<?= BASE_URL ?>Usuario/Politicas/Terminos_uso.php" class="hover:underline ">Terminos de uso</a> |
            <a href="<?= BASE_URL ?>Usuario/Politicas/Aviso_legal.php" class="hover:underline ">Aviso legal</a> |
            <a href="<?= BASE_URL ?>Usuario/Politicas/Contacto.php" class="hover:underline ">Atencion al usuario</a>
        </p>
    </div>
</footer>
