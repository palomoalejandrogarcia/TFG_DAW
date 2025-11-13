<?php
global $valorCookie;
require '../../funcion_inicio_de_sesion.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de sesion</title>
    <link rel="icon" href="../Imagenes/logo.png" type="image/png">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-screen bg-fixed bg-cover flex items-center justify-center">
<!-- Video del fondo  -->
<video autoplay muted loop playsinline class="fixed top-0 left-0 w-full h-full object-cover z-[-1]">
    <source src="../Videos/login.mp4" type="video/mp4">
</video>

<form method="POST" action="" class="bg-white p-6 rounded-lg shadow-lg w-96">
    <h2 class="text-2xl font-bold text-black-800 text-center">Inicio de sesion</h2>

    <!-- Campo usuario -->
    <label for="usuario" class="text-gray-600 mt-2 text-center block">Usuario</label>
    <input type="text" id="usuario" name="usuario" placeholder="Introduzca su usuario" value="<?php echo ($valorCookie !== null) ? $valorCookie : ''; ?>" required
           class="w-full p-3 border border-black-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">

    <!-- Campo contraseña -->
        <label for="contraseña" class="text-gray-600 mt-2 text-center block">Contraseña</label>
        <input type="password" id="contraseña" name="contraseña" placeholder="Introduzca su contraseña" required
               class="w-full p-3 border border-black-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" />
 <br>
    
    <!-- Notifiacion de errores -->
    <?php if (!empty($errores)): ?>
    <br>
        <div class="bg-red-100 text-red-800 p-4 rounded mb-4 text-center font-semibold flex items-center justify-center">
            <img src="../Imagenes/error.png" alt="Icono de error" class="w-6 h-6 mr-2"><?php echo $errores; ?>
        </div>
    <?php endif; ?>
    <!-- Boton de inicio de sesion -->
    <div class="flex justify-center mt-4">
        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full max-w-xs">
            Iniciar sesion
        </button>
    </div>

    <div class="text-center mt-4">
        <p class="text-black-600">¿No tienes una cuenta? <a href="Registrarse.php" class="text-black-500 hover:text-blue-700">Crear cuenta</a></p>
        <p class="text-black-600 mt-2">¿Has olvidado la contraseña? <a href="Cambiar_contraseña.php" class="text-black-500 hover:text-blue-700">Cambiar contraseña</a></p>
    </div>
</form>
</body>
</html>