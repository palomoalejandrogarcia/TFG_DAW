<?php
//Importamos las funciones del backend
require '../../backend/Inicio_Web/funcion_cambiar_contraseña.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar contraseña</title>
    <link rel="icon" href="../Imagenes/logo.png" type="image/png">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-screen bg-fixed bg-cover flex items-center justify-center">
<!-- Video del fondo  -->
<video autoplay muted loop class="fixed top-0 left-0 w-full h-full object-cover z-[-1]">
    <source src="../Videos/login.mp4" type="video/mp4">
</video>

<form method="POST" action="" class="bg-white p-6 rounded-lg shadow-lg w-96">
    <h2 class="text-2xl font-bold text-gray-800 text-center">Cambio de contraseña</h2>
    <!-- Campo usuario -->
    <label for="usuario" class="text-gray-600 mt-2 block">Usuario</label>
    <input type="text" name="usuario" id="usuario" placeholder="Introduzca su usuario" required
           class="w-full p-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">

    <!-- Campo contraseña actual-->
    <div class="relative">
        <label for="contraseña" class="text-gray-600 mt-2 block">Contraseña actual</label>
        <div class="relative">
            <input type="password" name="contraseña" id="contraseña" placeholder="Introduzca su contraseña actual" required
                   class="w-full p-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
        </div>
    </div>

    <!-- Campo contraseña nueva-->
    <div class="relative">
        <label for="nueva_contraseña" class="text-gray-600 block">Contraseña nueva</label>
        <input type="password" name="nueva_contraseña" id="nueva_contraseña"
               placeholder="Introduzca una contraseña nueva" required
               class="w-full p-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
    </div>

    <!-- Campo repetir contraseña -->
    <div class="relative">
        <label for="repite_contraseña" class="text-gray-600 block">Repetir contraseña</label>
        <div class="relative">
            <input type="password" name="repite_contraseña" id="repite_contraseña"
                   placeholder="Repita la contraseña nueva" required
                   class="w-full p-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">

        </div>
    </div>


    <!-- Boton cambiar contraseña -->
    <div class="flex justify-center mt-4">
        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full max-w-xs">
            Cambiar contraseña
        </button>
    </div>
    <br>
    <!-- Notificacion de errores  -->
    <?php if (!empty($errores)): ?>
        <div class="bg-red-100 text-red-800 p-4 rounded mb-4 text-center font-semibold flex items-center justify-center">
            <img src="../Imagenes/error.png" alt="Icono de error" class="w-6 h-6 mr-2">
            <?php echo $errores; ?>
        </div>
    <?php endif; ?>
</form>

</body>
</html>
