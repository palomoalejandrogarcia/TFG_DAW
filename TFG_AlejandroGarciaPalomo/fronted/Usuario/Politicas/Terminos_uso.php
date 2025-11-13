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
    <title>Terminos de uso</title>
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

<br>

<!-- Contenedor principal (centrado verticalmente) -->
<main class="flex flex-grow justify-center items-center text-center px-6 mt-20">
    <div class=" bg-blue-900 text-white p-8 rounded-2xl w-4/5 max-w-2xl">

        <h1 class="text-3xl font-bold mb-6">Terminos de Uso</h1>

        <p class="mb-4">El uso de este sitio web implica la aceptacion plena de los presentes terminos de uso.<p>

        <h2 class="text-2xl font-semibold mt-6 mb-2">1. Objetivo</h2>
        <p class="mb-4">Este sitio web simula una plataforma de venta de cursos con fines educativos.</p>

        <h2 class="text-2xl font-semibold mt-6 mb-2">2. Acceso al sitio</h2>
        <p class="mb-4">El acceso es libre y gratuito.</p>

        <h2 class="text-2xl font-semibold mt-6 mb-2">3. Registro de usuarios</h2>
        <p class="mb-4">Al crear una cuenta, el usuario se compromete a proporcionar informacion veraz y mantenerla actualizada. Cualquier uso indebido o fraudulento puede conllevar la eliminacion de la cuenta.</p>

        <h2 class="text-2xl font-semibold mt-6 mb-2">4. Uso aceptable</h2>
        <p class="mb-4">El usuario se compromete a utilizar el sitio de forma licita y respetuosa. Está prohibido introducir virus, intentar acceder a cuentas ajenas o utilizar la web con fines no autorizados.</p>

        <h2 class="text-2xl font-semibold mt-6 mb-2">5. Propiedad intelectual</h2>
        <p class="mb-4">Todos los contenidos del sitio (textos, imagenes, diseño) son propiedad del autor del proyecto, salvo indicacion contraria. No se permite su reproduccion sin consentimiento.</p>

        <h2 class="text-2xl font-semibold mt-6 mb-2">6. Exclusion de garantias</h2>
        <p class="mb-4">Dado su caracter academico y simulado, el sitio no garantiza la exactitud ni disponibilidad permanente de los cursos.</p>

        <h2 class="text-2xl font-semibold mt-6 mb-2">7. Modificaciones</h2>
        <p class="mb-4">El responsable del sitio puede modificar en cualquier momento estas condiciones. Se recomienda revisar periodicamente este apartado.</p>

        <h2 class="text-2xl font-semibold mt-6 mb-2">8. Legislacion aplicable</h2>
        <p class="mb-4">Estos terminos se rigen por la legislacion española. En caso de conflicto, se someteran a los juzgados y tribunales de Madrid, España.</p>

    </div>
</main>
<br>

<!-- Pie de pagina -->
<?php require '../../partes_pagina/Usuario/pie_pagina.php' ?>

</body>
</html>
