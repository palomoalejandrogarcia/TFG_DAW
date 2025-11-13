<?php
global $hayCursos;
//Importamos las funciones del backend
require '../../backend/Usuario/funcion_inicio.php'
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="../Imagenes/logo.png" type="image/png">

</head>
<body class="bg-gray-100 min-h-screen flex flex-col">
<!-- Video del fondo  -->
<video autoplay muted loop playsinline class="fixed top-0 left-0 w-full h-full object-cover z-[-1]">
    <source src="../Videos/fondo.mp4" type="video/mp4">
</video>
<!-- Navegador -->
<?php require '../partes_pagina/Usuario/Navegador.php' ?>


<!-- Mensaje de inicio -->
<main class="relative z-10 flex items-center justify-center min-h-screen px-4 sm:px-6 py-8 mt-16 sm:mt-20">
    <div class=" bg-blue-900 text-white p-8 rounded-2xl w-4/5 max-w-2xl">
        <h1 class="text-3xl font-bold mb-4">Bienvenido a LeaToMaster</h1>
        <p class="mb-4 text-lg">En LeaToMaster encontraras una amplia gama de cursos diseñados para potenciar tus habilidades y conocimientos.</p>
        <p class="mb-4 text-lg">Con nuestros cursos completos y estructurados, aprenderas desde lo mas basico hasta tecnicas avanzadas, permitiendote mejorar tu conocimiento y destacar en el ambito laboral.</p>
        <p class="mb-4 text-lg">Ya sea que busques aprender nuevas herramientas, mejorar tu productividad o iniciar tu carrera en la tecnologia, LeaToMaster te ofrece los recursos que necesitas para alcanzar tus metas.</p>
    </div>
</main>

<!-- Pie de pagina -->
<?php require '../partes_pagina/Usuario/pie_pagina.php' ?>

</body>
</html>
