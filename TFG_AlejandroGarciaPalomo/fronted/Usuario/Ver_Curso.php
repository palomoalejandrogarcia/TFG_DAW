<?php
global $hayCursos, $apartadoCurso;
//Importamos las funciones del backend
require '../../backend/Usuario/funcion_ver_curso.php'
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Curso</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="../Imagenes/logo.png" type="image/png">
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

<!-- Video del fondo -->
<video autoplay muted loop class="fixed top-0 left-0 w-full h-full object-cover z-[-1]">
    <source src="../Videos/fondo.mp4" type="video/mp4">
</video>

<!-- Navegador -->
<?php require '../partes_pagina/Usuario/Navegador.php' ?>
<br>
<main class="flex-grow flex items-center justify-center pt-20 pb-10 px-4 sm:px-6">
    <div class="w-full max-w-6xl mx-auto p-6 sm:p-8 rounded-lg shadow-md bg-white text-black">

        <!-- Titulo del curso -->
        <div class="text-center mb-8">
            <h1 class="text-2xl sm:text-3xl font-semibold">Curso <?= htmlspecialchars($_SESSION['curso_seleccionado']['titulo']) ?></h1>
        </div>

        <!-- Apartados del curso -->
        <div class="space-y-6">
            <?php foreach ($apartadoCurso as $apartadoCur): ?>
                <div class="p-4 sm:p-6 border rounded-lg bg-white text-black">
                    <h3 class="text-lg sm:text-xl font-semibold"><?= htmlspecialchars($apartadoCur['titulo_apartado']) ?></h3>
                    <p class="mt-2 text-sm sm:text-base"><?= nl2br(htmlspecialchars($apartadoCur['descripcion'])) ?></p>

                    <!-- Recursos del apartado -->
                    <div class="mt-4">
                        <h4 class="text-base sm:text-lg font-semibold">Recursos disponibles:</h4>

                        <?php if (!empty($apartadoCur['recursos'])): ?>
                            <ul class="list-disc ml-4 sm:ml-6 space-y-2 mt-2">
                                <?php foreach ($apartadoCur['recursos'] as $recurso): ?>
                                    <li class="text-sm sm:text-base">
                                        <strong><?= htmlspecialchars($recurso['tipo_recurso']) ?>:</strong>
                                        <a href="<?= htmlspecialchars($recurso['url']) ?>"
                                           class="text-blue-400 hover:underline ml-1"
                                            <?= $recurso['tipo_recurso'] === 'Video' ? 'target="_blank"' : 'download' ?>>
                                            <?= htmlspecialchars($recurso['titulo']) ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                            <!-- Notifiacion de errores -->
                        <?php else: ?>
                            <p class="text-sm sm:text-base mt-2">No hay recursos disponibles para este apartado.</p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</main>

<!-- Pie de pagina -->
<?php require '../partes_pagina/Usuario/pie_pagina.php' ?>

</body>
</html>