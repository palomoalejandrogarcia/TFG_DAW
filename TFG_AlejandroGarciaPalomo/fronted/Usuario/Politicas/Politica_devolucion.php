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
    <title>Politica de devolucion</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="../../Imagenes/logo.png" type="image/png">

</head>
<body class="relative bg-gray-100 min-h-screen flex flex-col">
<!-- Video del fondo -->
<video autoplay muted loop class="fixed top-0 left-0 w-full h-full object-cover z-[-1]">
    <source src="../../Videos/fondo.mp4" type="video/mp4">
</video>
<!-- Navegador -->
<?php require '../../partes_pagina/Usuario/Navegador.php' ?>

<br>
<!-- Mensaje politica de devolucion -->
<main class="flex flex-grow justify-center items-center text-center px-6 mt-20">
    <div class=" bg-blue-900 text-white p-8 rounded-2xl w-4/5 max-w-2xl">
        <h1 class="text-3xl font-bold mb-6">Politica de Devolucion</h1>

        <h2 class="text-2xl font-semibold mt-6 mb-2">1. Cursos Online</h2>
        <p class="mb-4">Dado que los cursos en linea son productos digitales, las devoluciones solo se aceptaran bajo ciertas condiciones.</p>

        <h2 class="text-2xl font-semibold mt-6 mb-2">2. Requisitos para la devolucion</h2>
        <p class="mb-4">Si deseas solicitar una devolucion, deberas cumplir con los siguientes requisitos:</p>
        <ul class="list-disc pl-5 mb-4">
            <li>La solicitud de devolucion debe realizarse dentro de los primeros 5 dias despues de la compra.</li>
            <li>La solicitud debe realizarse mediante correo electronico a <strong><a href="https://mail.google.com/mail/?view=cm&fs=1&to=leatomaster@gmail.com&su=Solicitud%20de%20Devolucion%20de%20Curso&body=Buenos%20d%C3%ADas%20LeaToMaster,%0AQuisiera%20hacer%20la%20devolucion%20del%20curso%20(nombre_del_curso).%0AMotivo:%0A(Motivo_de_la_devolucion)">leatomaster@gmail.com</a></strong>, indicando el motivo de la devolucion y los detalles del curso.</li>
        </ul>

        <h2 class="text-2xl font-semibold mt-6 mb-2">3. Proceso de devolucion</h2>
        <p class="mb-4">Una vez recibida tu solicitud de devolucion, nuestro equipo revisará el caso y te notificará sobre el estado de la devolucion dentro de los siguientes 5 dias habiles.</p>

        <h2 class="text-2xl font-semibold mt-6 mb-2">4. Condiciones de Reembolso</h2>
        <p class="mb-4">Si tu solicitud es aprobada, recibiras el reembolso completo del precio del curso en el mismo metodo de pago utilizado para la compra. El reembolso se procesará en un plazo de 10 dias habiles.</p>

        <h2 class="text-2xl font-semibold mt-6 mb-2">5. Excepciones</h2>
        <p class="mb-4">No se aceptaran devoluciones por cursos que hayan sido adquiridos como parte de una promocion especial, descuento o suscripcion, salvo en casos excepcionales.</p>

        <h2 class="text-2xl font-semibold mt-6 mb-2">6. Cambios de Curso</h2>
        <p class="mb-4">En lugar de solicitar una devolucion, si el curso adquirido no cumple con tus expectativas, puedes solicitar un cambio por otro curso disponible, siempre que se cumplan las condiciones mencionadas anteriormente.</p>

    </div>
</main>
<br>
<!-- Pie de pagina -->
<?php require '../../partes_pagina/Usuario/pie_pagina.php' ?>


</body>
</html>
