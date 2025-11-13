<?php
session_start();
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
    <title>Politica de privacidad</title>
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


<!-- Mensaje politica de privacidad -->
<main class="flex flex-grow justify-center items-center text-center px-6 mt-20">
    <div class=" bg-blue-900 text-white p-8 rounded-2xl w-4/5 max-w-2xl">
        <h1 class="text-2xl font-bold mb-4">Politica de Privacidad</h1>

        <h2 class="text-xl font-semibold mt-6 mb-2">1. Datos que se recopilan</h2>
        <p>LeatoMaster recogera datos personales como nombre, direccion de correo electronico y otra informacion proporcionada voluntariamente por el usuario durante el uso de la pagina web.</p>

        <h2 class="text-xl font-semibold mt-6 mb-2">2. Finalidad del tratamiento</h2>
        <p>Los datos se utilizarian exclusivamente para gestionar el acceso a los cursos, enviar notificaciones y generar estadisticas internas. No se compartiran con terceros.</p>

        <h2 class="text-xl font-semibold mt-6 mb-2">3. Derechos del usuario</h2>
        <p>Los usuarios tendran derecho a acceder, cambiar o eliminar sus datos personales. Pueden contactar a: <strong><a href="https://mail.google.com/mail/?view=cm&fs=1&to=leatomaster@gmail.com&su=Solicitud%20de%20Derechos%20de%20Usuario&body=Buenos%20d%C3%ADas%20LeaToMaster,%0ATengo%20una%20consulta%20sobre%20la%20pol%C3%ADtica%20de%20privacidad.">leatomaster@gmail.com</a></strong>.</p>

        <h2 class="text-xl font-semibold mt-6 mb-2">4. Seguridad</h2>
        <p>Este proyecto implementa medidas basicas de proteccion de datos. No obstante, se recuerda que se trata de una aplicacion con fines exclusivamente educativos, no disponible publicamente en produccion.</p>

    </div>
</main>
<br>
<!-- Pie de pagina -->
<?php require '../../partes_pagina/Usuario/pie_pagina.php' ?>


</body>
</html>

<!-- Nota -->
<!-- %20->Para espacio
     %0A->Para una nueva linea-->