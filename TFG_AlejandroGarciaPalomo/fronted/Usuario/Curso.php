<?php
global $estado, $curso;
//Importamos las funciones del backend
require '../../backend/Usuario/funcion_curso.php'
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis cursos</title>
    <!-- enlace Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="../Imagenes/logo.png" type="image/png">

</head>
<body class="bg-gray-100 h-screen flex flex-col">
<!-- Video del fondo -->
<video autoplay muted loop class="absolute top-0 left-0 w-full h-full object-cover z-[-1]">
    <source src="../Videos/fondo.mp4" type="video/mp4">
</video>

<!-- Navegador -->
<?php require '../partes_pagina/Usuario/Navegador.php' ?>

<!-- Datos del curso seleccionado -->
<main class="flex-grow flex items-center justify-center text-center px-4 relative z-10">
    <div class="w-3/4 max-w-2xl mx-auto p-8 bg-white rounded-lg shadow-lg">

        <!-- Titulo del curso -->
        <h2 class="text-2xl font-bold text-gray-800 text-center mb-4">Curso de <?= htmlspecialchars($curso['titulo']) ?></h2>

        <!-- Nombre del creador del curso -->
        <p class="text-gray-800 text-center mb-4">Creado por <?= htmlspecialchars($curso['nombre']) ?></p>

        <!-- Foto del curso -->
        <img src="<?= htmlspecialchars($curso['foto']) ?>" alt="Curso" class="w-full h-40 object-cover">

        <br>
        <!-- Descripcion del curso -->
        <p class="text-gray-700 text-center mb-4">
            <?= htmlspecialchars($curso['descripcion']) ?>
        </p>
        <!-- Precio del curso -->
        <p class="text-xl font-semibold text-center mb-4">
            Precio: <?= htmlspecialchars($curso['precio']) ?>€
        </p>

        <!-- Boton comprar curso -->
        <div class="flex justify-center">
            <a href="../Pago/Pago.php?estado=<?= $estado ?>"
               class="bg-blue-700 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded w-full">
                Comprar curso
            </a>
        </div>
    </div>
</main>

<!-- Pie de pagina -->
<?php require '../partes_pagina/Usuario/pie_pagina.php' ?>


</body>
</html>