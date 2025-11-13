<?php
global $hayCursos;
//Importamos las funciones del backend
require '../../backend/Usuario/funcion_Perfil.php'
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi perfil</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="../Imagenes/logo.png" type="image/png">
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">
<!-- Video del fondo -->
<video autoplay muted loop allowfullscreen- class="fixed top-0 left-0 w-full h-full object-cover z-[-1]">
    <source src="../Videos/fondo.mp4" type="video/mp4">
</video>

<!-- Navegador -->
<?php require '../partes_pagina/Usuario/Navegador.php' ?>

<!-- Perfil del usuario(Datos personales+Foto) -->
<main class="relative z-10 flex items-center justify-center min-h-[calc(100vh-8rem)] p-4 sm:p-6">

    <div class="flex flex-col lg:flex-row items-center justify-center bg-white text-black p-6 sm:p-8 rounded-2xl w-full max-w-4xl mx-auto gap-8 lg:gap-10">

        <!-- Datos personales del usuario -->
        <div class="w-full text-center lg:text-left lg:flex-1">
            <h1 class="text-2xl sm:text-3xl font-bold mb-4">Informacion de <?php echo $_SESSION['usuario']; ?></h1>
            <div class="space-y-3 mx-auto lg:mx-0" style="max-width: fit-content;">
                <p class="text-base sm:text-lg"><span class="font-semibold">Nombre:</span> <?php echo $_SESSION['nombre']; ?></p>
                <p class="text-base sm:text-lg"><span class="font-semibold">Apellidos:</span> <?php echo $_SESSION['apellidos']; ?></p>
                <p class="text-base sm:text-lg"><span class="font-semibold">Edad:</span> <?php echo $_SESSION['edad']; ?> años</p>
                <p class="text-base sm:text-lg"><span class="font-semibold">Correo:</span> <?php echo $_SESSION['correo']; ?></p>
            </div>
        </div>

        <div class="w-full flex flex-col items-center justify-center space-y-4">
            <!-- Foto de perfil -->
            <?php if (isset($_SESSION['foto_perfil'])): ?>
                <img src="<?php echo $_SESSION['foto_perfil']; ?>"
                     class="object-cover rounded-full border-4 border-blue-700 shadow-md w-28 h-28 sm:w-36 sm:h-36 md:w-44 md:h-44">
            <?php endif; ?>

            <!-- Formulario con botones para subir la imagen -->
            <form action="Perfil.php" method="post" enctype="multipart/form-data"
                  class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto justify-center">


                <!-- Campo de seleccion -->
                <input type="file" name="foto" id="foto" class="hidden">

                <!-- Boton para elegir imagen -->
                <label for="foto"
                       class="bg-blue-700 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded-full cursor-pointer
                              transition duration-300 text-center text-sm sm:text-base whitespace-nowrap">
                    Elegir Imagen
                </label>

                <!-- Boton para subir la imagen seleccionada -->
                <input type="submit" value="Subir Imagen"
                       class="bg-blue-700 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded-full shadow-md
                              transition duration-300 cursor-pointer text-sm sm:text-base whitespace-nowrap">
            </form>

            <!-- Notificacion de errores -->
            <?php if (!empty($erroresFoto)): ?>
                <div class="bg-red-100 text-red-800 p-3 rounded text-center font-semibold text-sm w-full max-w-xs">
                    <div class="flex items-center justify-center">
                        <img src="../Imagenes/error.png" alt="Icono de error" class="w-5 h-5 mr-2">
                        <?= htmlspecialchars($erroresFoto) ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<!-- Pie de pagina -->
<?php require '../partes_pagina/Usuario/pie_pagina.php' ?>
</body>
</html>