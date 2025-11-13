<?php

global $valorUsuario, $valorNombre, $valorApellidos, $valorEdad, $existe;
//importamos las funciones del backend
require '../../backend/Administrador/funcion_modificar_usuario.php';
require '../../backend/Administrador/funcion_panel_control.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Modificar curso</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="../Imagenes/logo.png" type="image/png">

</head>
<body class=" min-h-screen bg-fixed bg-cover flex items-center justify-center px-4">

<!-- Video del fondo  -->
<video autoplay muted loop class="absolute top-0 left-0 w-full h-full object-cover z-[-1]">
    <source src="../Videos/fondo.mp4" type="video/mp4">
</video>

<div class="flex flex-col items-center space-y-6">

    <!-- Primer formulario(comprobacion de id usuario) -->
    <form method="POST" action="Modificar_usuario.php">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
            <h2 class="text-2xl font-bold text-gray-800 text-center">Modificar usuario</h2>

            <!-- Campo id usuario -->
            <label for="id_usuario" class="text-gray-600 mt-2 text-center block">Id usuario</label>
            <input type="text" id="id_usuario"  value="<?= isset($_SESSION['id_modificar']) ? $_SESSION['id_modificar'] : '' ?>" name="id_usuario" placeholder="Introduzca el id del usuario a modificar" required
                   class="w-full p-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">

            <!-- Boton de comprobar id-->
            <div class="flex justify-center mt-4">
                <button class="bg-blue-700 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded w-full max-w-xs">
                    Comprobar id
                </button>
            </div>
            <br>
            <!-- Notificacion de errores  -->
            <?php if (!empty($erroresId)): ?>
                <div class="bg-red-100 text-red-800 p-4 rounded mb-4 text-center font-semibold flex items-center justify-center">
                    <img src="../Imagenes/error.png" alt="Icono de error" class="w-6 h-6 mr-2">
                    <?php echo $erroresId; ?>
                </div>
            <?php endif; ?>
        </div>
    </form>

    <!-- Segundo Formulario (modificar los datos del usuario) -->
    <?php if ($existe): ?>
        <form method="POST">
            <div class="bg-white p-6 rounded-lg shadow-lg w-96" >
                <h2 class="text-2xl font-bold text-gray-800 text-center">Modificar dato del usuario <?php echo $valorUsuario?></h2>

                <!-- Campo usuario -->
                <label for="usuario" class="text-gray-600 mt-2 text-center block">Usuario</label>
                <input type="text" id="usuario" name="usuario" value="<?= $valorUsuario ?>" placeholder="Introduzca un nombre para el usuario"
                       class="w-full p-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">

                <!-- Campo nombre -->
                <label for="nombre" class="text-gray-600 mt-2 text-center block">Nombre</label>
                <input type="text" id="nombre" name="nombre" value="<?= $valorNombre ?>" placeholder="Introduzca su nombre"
                       class="w-full p-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" >

                <!-- Campo apellidos -->
                <label for="apellidos" class="text-gray-600 mt-2 text-center block">Apellidos</label>
                <input type="text" id="apellidos" name="apellidos" value="<?= $valorApellidos ?>" placeholder="Introduzca su apellidos"
                       class="w-full p-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" >


                <!-- Campo edad -->
                <label for="edad" class="text-gray-600 mt-2 text-center block">Edad</label>
                <input type="number" id="edad" name="edad" value="<?= $valorEdad ?>" placeholder="Introduzca su edad"
                       class="w-full p-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" >

                <!-- Boton de modificar usuario -->
                <div class="flex justify-center mt-4">
                    <input type="hidden" name="id_usuario" value="<?= $_SESSION['id_modificar'] ?>">
                    <button class="bg-blue-700 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded w-full max-w-xs" >
                        Modificar usuario
                    </button>
                </div>
                <br>
                <!-- Notificacion de errores  -->
                <?php if (!empty($erroresModificar)): ?>
                    <div class="bg-red-100 text-red-800 p-4 rounded mb-4 text-center font-semibold flex items-center justify-center">
                        <img src="../Imagenes/error.png" alt="Icono de error" class="w-6 h-6 mr-2">
                        <?php echo $erroresModificar; ?>
                    </div>
                <?php endif; ?>
            </div>
        </form>
    <?php endif; ?>

</div>

</body>
</html>
