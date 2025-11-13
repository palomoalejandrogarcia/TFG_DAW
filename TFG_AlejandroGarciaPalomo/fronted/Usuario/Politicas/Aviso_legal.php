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
    <title>Aviso legal</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="../../Imagenes/logo.png" type="image/png">

</head>
<body class="bg-gray-100 h-screen flex flex-col">

<!-- Video de fondo -->
<video autoplay muted loop class="fixed top-0 left-0 w-full h-full object-cover z-[-1]">
    <source src="../../Videos/fondo.mp4" type="video/mp4">
</video>

<!-- Navegador -->
<?php require '../../partes_pagina/Usuario/Navegador.php' ?>

<br>
<!-- Mensaje aviso legal -->
<main class="flex flex-grow justify-center items-center text-center px-6 mt-20">
    <div class=" bg-blue-900 text-white p-8 rounded-2xl w-4/5 max-w-2xl">

        <h1 class="text-3xl text-white font-bold mb-6 text-center text-gray-800">Aviso Legal</h1>

        <div class="space-y-6 text-base leading-relaxed">

            <section>
                <h2 class="text-xl text-white font-semibold text-gray-700 mb-2">1. Titular del sitio</h2>
                <p>Nombre del autor: <strong>Alejandro García Palomo</strong><br>
                    Correo de contacto: <strong><a href="mailto:leatomaster@gmail.com" class=" rounded-2xl text-blue-600 text-white hover:underline">leatomaster@gmail.com</a></strong><br>
                    Centro educativo: <strong>IES Virgen de la Paloma</strong></p>
            </section>

            <section>
                <h2 class="text-xl text-white font-semibold text-gray-700 mb-2">2. Objetivo del sitio web</h2>
                <p>La finalidad de esta web es simular una plataforma de venta de cursos en un entorno educativo.</p>
            </section>

            <section>
                <h2 class="text-xl text-white font-semibold text-gray-700 mb-2">3. Condiciones de uso</h2>
                <p>El acceso a este sitio es libre y gratuito. Queda prohibido reproducir o utilizar los contenidos con fines comerciales sin autorizacion.</p>
            </section>


            <section>
                <h2 class="text-xl text-white font-semibold text-gray-700 mb-2">4. Propiedad intelectual</h2>
                <p>Los contenidos del sitio (textos, imagenes, diseño,etc...) son propiedad del autor, salvo que se indique lo contrario.</p>
            </section>


            <section>
                <h2 class="text-xl text-white font-semibold text-gray-700 mb-2">5. Exclusion de responsabilidad</h2>
                <p>Este sitio no garantiza la veracidad o actualidad de los contenidos, dado su caracter academico y simulado.</p>
            </section>


            <section>
                <h2 class="text-xl text-white font-semibold text-gray-700 mb-2">6. Legislacion aplicable</h2>
                <p>Este aviso legal se rige por la legislacion española, en especial la Ley 34/2002 (LSSI-CE) y el Reglamento General de Proteccion de Datos (UE 2016/679).</p>
            </section>
        </div>
    </div>
</main>

<br>
<!-- Pie de pagina -->
<?php require '../../partes_pagina/Usuario/pie_pagina.php' ?>


</body>
</html>
