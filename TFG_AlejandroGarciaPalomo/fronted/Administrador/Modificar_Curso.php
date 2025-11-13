<?php
global $existe;
//importamos las funciones del backend
require '../../backend/Administrador/funcion_modificar_curso.php';
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

    <!-- Primer formulario(comprobacion de id curso) -->
    <form method="POST" action="Modificar_Curso.php">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
            <h2 class="text-2xl font-bold text-gray-800 text-center">Modificar curso</h2>

            <!-- Campo id curso -->
            <label for="id_curso" class="text-gray-600 mt-2 text-center block">Id curso</label>
            <input type="text" id="id_curso" name="id_curso"  value="<?= isset($_SESSION['id_curso_modificar']) ? $_SESSION['id_curso_modificar'] : '' ?>" placeholder="Introduzca el id del curso a modificar" required
                   class="w-full p-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">

            <!-- Boton de comprobar id -->
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

    <!-- Segundo Formulario (modificar los datos del curso) -->
    <?php if ($existe): ?>
        <form method="POST">
            <div class="bg-white p-6 rounded-lg shadow-lg w-96" >
                <h2 class="text-2xl font-bold text-gray-800 text-center">Modificar dato del curso <?php echo $_SESSION['titulo_modificar'] ?></h2>

                <!-- Campo titulo -->
                <label for="titulo" class="text-gray-600 mt-2 text-center block">Titulo</label>
                <input type="text" id="titulo" name="titulo" value="<?= isset($_SESSION['titulo_modificar']) ? $_SESSION['titulo_modificar'] : '' ?>" placeholder="Introduzca un titulo"
                       class="w-full p-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">

                <!-- Campo descripcion -->
                <label for="descripcion" class="text-gray-600 mt-2 text-center block">Descripcion</label>
                <input type="text" id="descripcion" name="descripcion"  value="<?= isset($_SESSION['descripcion_modificar']) ? $_SESSION['descripcion_modificar'] : '' ?>" placeholder="Introduzca una descripcion"
                       class="w-full p-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">

                <!-- Campo precio -->
                <label for="precio" class="text-gray-600 mt-2 text-center block">Precio</label>
                <input type="text" id="precio" name="precio" value="<?= isset($_SESSION['precio_modificar']) ? $_SESSION['precio_modificar'] : '' ?>" placeholder="Introduzca un precio"
                       class="w-full p-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">

                <!-- Boton de modificar curso -->
                <div class="flex justify-center mt-4">
                    <button class="bg-blue-700 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded w-full max-w-xs">
                        <input type="hidden" name="id_curso" value="<?= $_SESSION['id_curso_modificar'] ?>">
                        Modificar curso
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
