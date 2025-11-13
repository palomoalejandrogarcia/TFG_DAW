<?php
global $precioTotalCurso, $cursos;
//Importamos las funciones del backend
require '../../backend/Usuario/funcion_cursos.php'
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cursos disponibles</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="../Imagenes/logo.png" type="image/png">
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">
<!-- Video del fondo  -->
<video autoplay muted loop class="fixed top-0 left-0 w-full h-full object-cover z-[-1]">
    <source src="../Videos/fondo.mp4" type="video/mp4">
</video>

<!-- Navegador  -->
<?php require '../partes_pagina/Usuario/Navegador.php' ?>

<div class="h-16 sm:h-20"></div>

<!-- Boton carrito -->
<button id="abrirCarrito"
        class="fixed bottom-4 right-4 bg-blue-700 text-white px-4 py-2 rounded-full shadow-lg z-50 hover:bg-blue-800 transition text-sm sm:text-base">
    🛒 Carrito
</button>

<!-- Panel carrito-->
<div id="carritoLateral"
     class="fixed top-0 right-0 h-full w-full sm:w-96 bg-white shadow-lg p-4 sm:p-6 transform translate-x-full transition-transform duration-300 ease-in-out z-40 overflow-y-auto">
    <!-- Titulo y boton de cierre del panel -->
    <div class="flex justify-between items-center mb-4">
        <br>
        <br>
        <br>
        <br><br>
        <br><br>
        <br>

        <h2 class="text-xl sm:text-2xl font-bold">Tu carrito</h2>
        <button id="cerrarCarrito" class="text-red-500 text-2xl">&times;</button>
    </div>
    <!-- Notificacion de errores-->
    <?php if (empty($_SESSION['carrito'])): ?>
        <p class="text-center">No tienes cursos en tu carrito.</p>
    <?php else: ?>
        <!-- Cursos seleccionados por el usuario y mostrados en el carrito-->
        <div id="carrito" class="space-y-3">
            <?php foreach ($_SESSION['carrito'] as $cursoCarrito): ?>
                <div class="flex justify-between items-center p-3 sm:p-4 bg-gray-50 rounded-md">
                    <div class="flex-1">
                        <p class="text-sm sm:text-base"><?= htmlspecialchars($cursoCarrito['titulo']) ?> - <?= htmlspecialchars($cursoCarrito['precio']) ?>€</p>
                    </div>
                    <form method="POST" action="">
                        <input type="hidden" name="id_curso_eliminar" value="<?= htmlspecialchars($cursoCarrito['id']) ?>">
                        <button type="submit" class="text-red-500 text-sm sm:text-base">Eliminar</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- Precio total del carrito -->
    <?php if (isset($_SESSION['precioTotalCurso_carrito']) && $_SESSION['precioTotalCurso_carrito'] > 0): ?>
        <p class="text-lg font-bold mt-4">Precio total: <?= $_SESSION['precioTotalCurso_carrito'] ?>€</p>
    <?php endif; ?>
    <!-- Boton ir al pago-->
    <div class="mt-4 sm:mt-6">
        <?php if (isset($_SESSION['precioTotalCurso_carrito']) && $_SESSION['precioTotalCurso_carrito'] > 0): ?>
            <button class="w-full bg-blue-700 text-white py-2 rounded hover:bg-blue-800 text-sm sm:text-base">
                <a href="../Pago/Pago.php?estado=<?= 'carrito' ?>">Ir al pago</a>
            </button>
        <?php endif; ?>
    </div>

    <!-- Formulario codigo de descuento -->
 <?php if (isset($_SESSION['precioTotalCurso_carrito']) && $_SESSION['precioTotalCurso_carrito'] > 0): ?>
    <?php if (empty($_SESSION['Aplicado'])): ?>
        <form method="POST" action="" class="mt-4">
            <!-- Campo codigo de descuento-->
            <label for="inputDescuento" class="block text-black mb-2 text-sm sm:text-base">codigo de descuento</label>
            <input type="text" id="inputDescuento" name="codigo" placeholder="Ej:123"
                   class="w-full p-2 sm:p-3 border border-gray-300 rounded-md shadow-sm mb-3 text-sm sm:text-base">

            <!-- Boton aplicar descuento-->
            <button type="submit" name="enviarcodigo" value="1"
                    class="bg-blue-700 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded w-full text-sm sm:text-base">
                Aplicar descuento
            </button>
        </form>
    <?php endif; ?>
<?php endif; ?>

    <!-- Notificacion de errores-->
    <?php if (!empty($errorDescuento)): ?>
        <div class="bg-red-100 text-red-800 p-3 rounded mb-4 text-center font-semibold flex items-center justify-center text-sm sm:text-base mt-4">
            <img src="../Imagenes/error.png" alt="Icono de error" class="w-5 h-5 mr-2">
            <?= htmlspecialchars($errorDescuento) ?>
        </div>
    <?php endif; ?>
    <!-- Notificacion de mensajes-->
    <?php if (!empty($mensajeDescuento)): ?>
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4 text-center font-semibold flex items-center justify-center text-sm sm:text-base mt-4">
            <img src="../Imagenes/correcto.png" alt="Icono de éxito" class="w-5 h-5 mr-2">
            <?= htmlspecialchars($mensajeDescuento) ?>
        </div>
    <?php endif; ?>
</div>

<!-- Boton filtros -->
<button id="abrirFiltro"
        class="fixed bottom-4 left-4 bg-blue-700 text-white px-4 py-2 rounded-full shadow-lg z-50 hover:bg-blue-800 transition text-sm sm:text-base">
    🛠️ Filtros
</button>

<!-- Panel filtros-->
<div id="filtroLateral"
     class="fixed top-0 left-0 h-full w-full sm:w-96 bg-white shadow-lg p-4 sm:p-6 transform -translate-x-full transition-transform duration-300 ease-in-out z-40 overflow-y-auto">

    <!-- Titulo y boton de cierre del panel -->
    <div class="flex justify-between items-center mb-4 sm:mb-6">
        <br>
        <br>
        <br>
        <br><br>
        <br><br>
        <br>
        <h2 class="text-xl sm:text-2xl font-bold text-gray-800">Filtros</h2>
        <button id="cerrarFiltro" class="text-red-500 text-2xl">&times;</button>
    </div>

    <!-- Formulario Filtros -->
    <div class="pt-2 sm:pt-4 space-y-3">
        <form method="POST" action="">
            <input type="hidden" name="filtro_aplicado" value="1">

            <div class="space-y-3">

                <!-- Opcion 'Mostrar por nombre (A-Z)' -->
                <label class="flex items-center space-x-2 cursor-pointer text-gray-700 text-sm sm:text-base">
                    <input type="radio" name="tipo_filtro" value="titulo_ascendente" checked>
                    <span>Mostrar por nombre (A-Z)</span>
                </label>

                <!-- Opcion 'Mostrar por nombre (Z-A)' -->
                <label class="flex items-center space-x-2 cursor-pointer text-gray-700 text-sm sm:text-base">
                    <input type="radio" name="tipo_filtro" value="titulo_descendete">
                    <span>Mostrar por nombre (Z-A)</span>
                </label>

                <!-- Opcion 'Mostrar por precio (Menor a mayor)' -->
                <label class="flex items-center space-x-2 cursor-pointer text-gray-700 text-sm sm:text-base">
                    <input type="radio" name="tipo_filtro" value="precio_ascendente">
                    <span>Mostrar por precio (Menor a mayor)</span>
                </label>
                <!-- Opcion 'Mostrar por precio (Mayor a menor)' -->
                <label class="flex items-center space-x-2 cursor-pointer text-gray-700 text-sm sm:text-base">
                    <input type="radio" name="tipo_filtro" value="precio_descendete">
                    <span>Mostrar por precio (Mayor a menor)</span>
                </label>
                <!-- Opcion 'Mostrar por cursos no comprados' -->
                <label class="flex items-center space-x-2 cursor-pointer text-gray-700 text-sm sm:text-base">
                    <input type="radio" name="tipo_filtro" value="curso_no_comprado">
                    <span>Mostrar por cursos no comprados</span>
                </label>
            </div>
            <!-- Boton aplicar filtro -->
            <div class="mt-4 sm:mt-6 space-y-3">
                <button type="submit" name="enviar_filtro" value="1"
                        class="w-full bg-blue-700 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded text-sm sm:text-base">
                    Aplicar filtro
                </button>
            </div>
        </form>
        <!-- Boton borrar filtros -->
        <button name="borrar" onclick="resetearFiltros()"
                class="w-full bg-red-500 hover:bg-red-800 text-white font-bold py-2 px-4 rounded transition duration-300 text-sm sm:text-base">
            Borrar filtros
        </button>
    </div>
</div>

<div class="flex-1 p-4 sm:p-6">

    <div class="bg-blue-900 text-white p-4 sm:p-6 rounded-lg shadow-lg text-center w-full sm:w-[500px] md:w-[600px] mx-auto">
        <h2 class="text-2xl sm:text-3xl font-bold">Cursos disponibles</h2>
    </div>

    <div class="mt-4 sm:mt-6"></div>

    <!-- La siguiente funcion mostrara los cursos disponibles  -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
        <?php if (count($cursos) > 0): ?>
            <?php renderizarCursos($cursos); ?>
            <!-- Notificacion de errores  -->
        <?php else: ?>
            <div class="w-full text-center p-3 sm:p-4 bg-yellow-200 rounded-lg flex items-center justify-center col-span-full">
                <img src="../Imagenes/advertencia.png" alt="Imagen de advertencia" class="w-5 h-5 sm:w-6 sm:h-6 mr-2 sm:mr-3">
                <p class="text-gray-700 text-sm sm:text-base">No hay cursos disponibles</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Pie de pagina -->
<?php require '../partes_pagina/Usuario/pie_pagina.php' ?>

</body>
</html>

<script>
    // Esta funcion lo que hara es desmarca cualquier opcion seleccionada en los botones de filtro
    function resetearFiltros(){
        document.querySelectorAll('input[name="tipo_filtro"]').forEach(radio => radio.checked = false);
    }
    //El siguiente codigo mostrara y cerrar tanto el panel de filtro y carrrito
    document.addEventListener("DOMContentLoaded", () => {

        const abrirCarrito = document.getElementById("abrirCarrito");
        const cerrarCarrito = document.getElementById("cerrarCarrito");
        const carritoLateral = document.getElementById("carritoLateral");
        const filtroLateral = document.getElementById("filtroLateral");
        const abrirFiltro = document.getElementById("abrirFiltro");
        const cerrarFiltro = document.getElementById("cerrarFiltro");

        if (abrirFiltro && filtroLateral && cerrarFiltro) {
            abrirFiltro.addEventListener("click", () => {
                filtroLateral.classList.remove("-translate-x-full");
            });

            cerrarFiltro.addEventListener("click", () => {
                filtroLateral.classList.add("-translate-x-full");
            });
        }

        if (abrirCarrito && cerrarCarrito && carritoLateral) {
            abrirCarrito.addEventListener("click", () => {
                carritoLateral.classList.remove("translate-x-full");
            });

            cerrarCarrito.addEventListener("click", () => {
                carritoLateral.classList.add("translate-x-full");
            });
        }
    });
</script>