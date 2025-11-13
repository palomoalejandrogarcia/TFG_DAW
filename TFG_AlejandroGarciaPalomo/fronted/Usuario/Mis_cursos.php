<?php
global $cursos;
//Importamos las funciones del backend
require '../../backend/Usuario/funcion_mis_cursos.php';
?>
<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis cursos</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="../Imagenes/logo.png" type="image/png">
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">
<!-- Video del fondo  -->
<video autoplay muted loop class="fixed top-0 left-0 w-full h-full object-cover z-[-1]">
    <source src="../Videos/fondo.mp4" type="video/mp4">
</video>

<!-- Navegador -->
<?php require '../partes_pagina/Usuario/Navegador.php'; ?>


<main class="relative z-10 flex items-center justify-center min-h-screen px-4 sm:px-6 py-8 mt-16 sm:mt-20">
    <div class="w-full max-w-7xl p-4 sm:p-6">
        <div class="bg-blue-900 text-white p-4 sm:p-6 rounded-lg shadow-lg text-center w-full sm:w-[500px] md:w-[600px] mx-auto">
            <h2 class="text-2xl sm:text-3xl font-bold">Cursos comprados</h2>
        </div>
        <br>
        <!-- Verificamos si el usuario tiene cursos comprados -->
        <?php if (count($cursos) > 0): ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-6">
                <?php foreach ($cursos as $curso): ?>
                    <div class="bg-white shadow-lg rounded-lg overflow-hidden relative hover:shadow-xl transition-shadow duration-300">
                        <div class="relative">
                            <!-- Imagen del curso -->
                            <img src="<?= htmlspecialchars($curso['Foto']) ?>" alt="Curso <?= htmlspecialchars($curso['Titulo']) ?>" class="w-full h-32 sm:h-40 object-cover">
                        </div>
                        <div class="p-3 sm:p-4">
                            <!-- Titulo y descripcion del curso -->
                            <h3 class="text-lg sm:text-xl font-semibold"><?= htmlspecialchars($curso['Titulo']) ?></h3>
                            <p class="text-gray-600 text-sm sm:text-base"><?= htmlspecialchars($curso['Descripcion']) ?></p>

                            <!-- Formulario para ver detalles del curso mediante POST -->
                            <form action="../../backend/Usuario/funcion_mis_cursos.php" method="post" class="mt-3 sm:mt-4">
                                <input type="hidden" name="id_curso" value="<?= htmlspecialchars($curso['Id_curso']) ?>">
                                <input type="hidden" name="titulo" value="<?= htmlspecialchars($curso['Titulo']) ?>">
                                <input type="hidden" name="descripcion" value="<?= htmlspecialchars($curso['Descripcion']) ?>">
                                <input type="hidden" name="precio" value="<?= htmlspecialchars($curso['Precio']) ?>">
                                <input type="hidden" name="creado_por" value="<?= htmlspecialchars($curso['Creado_por']) ?>">

                                <!-- Boton para enviar el formulario -->
                                <button type="submit"
                                        class="block w-full bg-blue-700 hover:bg-blue-800 text-white py-2 px-4 rounded text-sm sm:text-base">
                                    Ver curso
                                </button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <!-- Mensaje si no hay cursos -->
            <div class="bg-yellow-200 text-gray-700 p-4 rounded-lg mt-4 text-center flex items-center justify-center gap-2">
                <img src="../Imagenes/advertencia.png" alt="Advertencia" class="w-5 h-5">
                No hay ningun curso comprado
            </div>
        <?php endif; ?>
    </div>
</main>


<!-- Pie de pagina -->
<?php require '../partes_pagina/Usuario/pie_pagina.php'; ?>

</body>
</html>