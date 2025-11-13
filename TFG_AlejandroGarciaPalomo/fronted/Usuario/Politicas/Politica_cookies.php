<?php
session_start();

//Verificamos que si se ha logueado el usuario con rol de 'Usuario' si no es asi nos redirije al login de la pagina
if(empty($_SESSION['usuario']) ||  $_SESSION['rol'] !=='Usuario'){
    header("Location: ../../fronted/Inicio_Web/Inicio_de_sesion.php");
exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Politica de cookies</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="../../Imagenes/logo.png" type="image/png">

</head>
<body class="bg-gray-100 h-screen flex flex-col">

<!-- Video del fondo -->
<video autoplay muted loop class="fixed top-0 left-0 w-full h-full object-cover z-[-1]">
    <source src="../../Videos/fondo.mp4" type="video/mp4">
</video>

<!-- Navegador -->
<?php require '../../partes_pagina/Usuario/Navegador.php' ?>


<!-- Mensaje de politica de cookies -->
<main class="flex flex-grow justify-center items-center text-center px-6 mt-20">
    <div class=" bg-blue-900 text-white p-8 rounded-2xl w-4/5 max-w-2xl">
        <h1 class="text-3xl font-bold mb-6">Politica Cookies</h1>

        <p class="mb-4">LeaToMaster utiliza cookies para mejorar la experiencia del usuario. Al continuar navegando, aceptas el uso de cookies segun esta politica.</p>

        <h2 class="text-2xl font-semibold mt-6 mb-2">¿Qué son las cookies?</h2>
        <p class="mb-4">Una cookie es un pequeño archivo que se descarga en tu dispositivo al acceder a determinadas paginas web. Permiten a una pagina reconocer el navegador del usuario, almacenar y recuperar informacion sobre sus habitos de navegacion.</p>

        <h2 class="text-2xl font-semibold mt-6 mb-2">Tipos de cookies que usamos</h2>
        <ul class="list-disc pl-5 mb-4">
            <li><strong>Cookies temporales:</strong> Expiran automaticamente despues de un corto periodo de tiempo y no se usan para rastreo. En este sitio, se utilizan únicamente para mejorar la experiencia del usuario.</li>
        </ul>

        <h2 class="text-2xl font-semibold mt-6 mb-2">Consentimiento</h2>
        <p class="mb-4">Al navegar y continuar en nuestra web, consientes el uso de las cookies en las condiciones contenidas en esta politica.</p>
    </div>
</main>
<br>

<!-- Pie de pagina -->
<?php require '../../partes_pagina/Usuario/pie_pagina.php' ?>


</body>
</html>
