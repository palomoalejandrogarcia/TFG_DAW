<?php
require '../../funcion_registrarse.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear cuenta</title>
    <link rel="icon" href="../Imagenes/logo.png" type="image/png">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-screen bg-fixed bg-cover flex items-center justify-center">
<!-- Video del fondo  -->
<video autoplay muted loop class="fixed top-0 left-0 w-full h-full object-cover z-[-1]">
    <source src="../Videos/login.mp4" type="video/mp4">
</video>
<form method="POST" action="Registrarse.php">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <h2 class="text-2xl font-bold text-gray-800 text-center">Crear cuenta</h2>

        <!-- Campo usuario -->
        <label for="usuario" class="text-gray-600 mt-2 text-center block">Usuario</label>
        <input type="text" id="usuario" name="usuario" placeholder="Introduzca un usuario" required
               class="w-full p-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">

        <!-- Campo nombre -->
        <label for="nombre" class="text-gray-600 mt-2 text-center block">Nombre</label>
        <input type="text" id="nombre" name="nombre" placeholder="Introduzca su nombre" required
               class="w-full p-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">

        <!-- Campo apellido -->
        <label for="apellidos" class="text-gray-600 mt-2 text-center block">Apellidos</label>
        <input type="text" id="apellidos" name="apellidos" placeholder="Introduzca sus apellidos" required
               class="w-full p-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">

        <!-- Campo edad -->
        <label for="edad" class="text-gray-600 mt-2 text-center block">Edad</label>
        <input type="number" id="edad" name="edad" placeholder="Introduzca su edad" required
               class="w-full p-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">

        <!-- Campo correo electronico -->
        <label for="correo" class="text-gray-600 mt-2 text-center block">Correo electronico</label>
        <input type="email" id="correo" name="correo" placeholder="Introduzca su correo electronico" required
               class="w-full p-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">

        <!-- Campo contraseña -->
        <div class="relative">
            <label for="contraseña" class="text-gray-600 mt-2 text-center block">Contraseña</label>
            <div class="relative">
                <input type="password" id="contraseña" name="contraseña" placeholder="Introduzca una contraseña" required
                       class="w-full p-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
            </div>
        </div>


        <!-- Campo repetir contraseña -->
        <div class="relative">
            <label for="repetir_contraseña" class="text-gray-600 mt-2 text-center block">Repite la contraseña</label>
            <div class="relative">
                <input type="password" id="repetir_contraseña" name="repetir_contraseña" placeholder="Introduzca otra vez la contraseña" required
                       class="w-full p-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
            </div>
        </div>

        <!-- Campo rol -->
        <div class="flex justify-center items-center mt-4 space-x-4">
            <div class="flex items-center">
                <label for="administrador" class="ml-2 text-lg">Administrador</label><br>
                <input type="radio" id="administrador" name="opcion" value="Administrador" class="form-radio ml-2">
            </div>

            <div class="flex items-center">
                <label for="usuario" class="ml-2 text-lg">Usuario</label>
                <input type="radio" id="usuario" name="opcion" value="Usuario" class="form-radio ml-2">
            </div>
        </div>

        <!-- Notificacion de errores -->
        <?php if (!empty($errores)): ?>
            <div class="bg-red-100 text-red-800 p-4 rounded mb-4 text-center font-semibold flex items-center justify-center">
                <img src="../Imagenes/error.png" alt="Icono de error" class="w-6 h-6 mr-2">
                <?php echo $errores; ?>
            </div>
        <?php endif; ?>


        <!-- Boton crear cuenta -->
        <div class="flex justify-center mt-4">
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full max-w-xs">
                Crear cuenta
            </button>
        </div>
    </div>
</form>

</body>
</html>
