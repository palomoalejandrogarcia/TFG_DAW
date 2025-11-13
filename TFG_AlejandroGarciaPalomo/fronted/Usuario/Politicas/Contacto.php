<?php
//Importamos las funciones del backend
require '../../../funcion_contacto.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto</title>
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


<!-- Formulario de atencion al usuario-->
<main class="flex flex-grow justify-center items-center text-center px-6 mt-20">
    <div class=" bg-blue-900 text-white p-8 rounded-2xl w-4/5 max-w-2xl">

        <h1 class="text-3xl font-bold mb-6">Atencion al usuario</h1>


        <form class="space-y-6 text-left" method="POST" action="">
            <!-- Campo usuario -->
            <div>
                <label for="nombre" class="block text-sm font-medium mb-1">Usuario</label>
                <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($_SESSION['usuario']) ?>" readonly
                       class="w-full px-4 py-2 rounded-lg bg-gray-800 border border-white focus:outline-none focus:ring-1 focus:ring-white text-white">
            </div>

            <!-- Campo correo electronico -->
            <div>
                <label for="email" class="block text-sm font-medium mb-1">Correo electronico</label>
                <input type="email" name='email' id="email" value="<?= htmlspecialchars($_SESSION['correo']) ?>" readonly
                       class="w-full px-4 py-2 rounded-lg bg-gray-800 border border-white focus:outline-none focus:ring-1 focus:ring-white text-white">
            </div>

            <!-- Campo asunto -->
            <div>
                <label for="asunto" class="block text-sm font-medium mb-1">Asunto</label>
                <select id="asunto" name="asunto" class="w-full px-4 py-2 rounded-lg bg-gray-800 border border-white focus:outline-none focus:ring-1 focus:ring-white text-white">
                    <option value="" disabled selected>Selecciona un tema</option>
                    <option value="Soporte tecnico">Soporte tecnico</option>
                    <option value="Consulta de cursos">Consulta de cursos</option>
                    <option value="Colaboracion">Colaboracion</option>
                </select>
            </div>

            <!-- Campo mensaje -->
            <div>
                <label for="mensaje" class="block text-sm font-medium mb-1">Mensaje</label>
                <textarea id="mensaje" name="mensaje" rows="4" placeholder="Escribe tu mensaje aquí..." required
                          class="w-full px-4 py-2 rounded-lg bg-gray-800 border border-white focus:outline-none focus:ring-1 focus:ring-white text-white"
                ></textarea>
            </div>

            <!-- Boton de enviar mensaje -->
            <button type="submit"
                    class="w-full bg-blue-700 hover:bg-blue-800 text-white font-bold py-3 px-4 rounded-lg transition duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-gray-900">
                Enviar mensaje
            </button>
            <br>
            <!-- Notifiacion de mensajes -->
            <?php if (!empty($mensajeContacto)): ?>
                <div class="bg-green-100 text-green-800 p-4 rounded mb-4 text-center font-semibold flex items-center justify-center">
                    <img src="../../Imagenes/correcto.png" alt="Icono de error" class="w-6 h-6 mr-2"><?php echo $mensajeContacto; ?>

                </div>
            <?php endif; ?>
            <!-- Notifiacion de errores -->
            <?php if (!empty($errores)): ?>
                <div class="bg-red-100 text-red-800 p-4 rounded mb-4 text-center font-semibold flex items-center justify-center">
                    <img src="../../Imagenes/error.png" alt="Icono de error" class="w-6 h-6 mr-2">
                    <span><?php echo $errores; ?></span>
                    </p>
                </div>
            <?php endif; ?>
        </form>
    </div>
</main>

<br>

<!-- Pie de pagina -->
<?php require '../../partes_pagina/Usuario/pie_pagina.php' ?>


</body>
</html>