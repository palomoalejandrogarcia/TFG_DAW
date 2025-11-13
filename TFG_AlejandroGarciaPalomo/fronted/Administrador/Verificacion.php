<?php
//Importamos las funciones del backend
require '../../funcion_reenviar_codigo.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificacion de usuario</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="../Imagenes/logo.png" type="image/png">
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center px-4">
<!-- Video del fondo  -->
<video autoplay muted loop playsinline class="fixed top-0 left-0 w-full h-full object-cover z-[-1]">
    <source src="../Videos/login.mp4" type="video/mp4">
</video>

<div class="bg-white shadow-md rounded-lg p-6 sm:p-8 w-full max-w-sm sm:max-w-md z-10">
    <form method="POST" class="space-y-4">
        <h2 class="text-xl sm:text-2xl font-bold text-black-700 mb-2 sm:mb-4 text-center">
            Bienvenido <?php echo htmlspecialchars($_SESSION['usuario']); ?>
        </h2>
        <p class="text-gray-600 text-sm sm:text-base text-center leading-relaxed">
            Verifique su Gmail y escriba el codigo que le hemos enviado para confirmar su identidad.
        </p>

        <!-- Contador -->
        <div class="mt-6 text-center font-sans">
            <span id="contador" class="inline-block text-xl sm:text-2xl font-bold px-5 py-2 bg-blue-700 text-white rounded-lg shadow-md">
                --
            </span>
        </div>

        <!-- Campo codigo -->
        <div>
            <label for="codigo" class="block text-gray-600 mb-1 text-sm sm:text-base">Introduzca el codigo:</label>
            <input type="password" id="codigo" name="codigo" maxlength="4" pattern="\d{4}" placeholder="Ej: 1234" required
                   class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm sm:text-base">
        </div>

        <!-- Boton comprobar codigo -->
        <input type="hidden" name="enviar_codigo" value="1">
        <button type="submit"
                class="w-full bg-blue-700 hover:bg-blue-800 text-white py-2 rounded transition duration-200 text-sm sm:text-base">
            Comprobar codigo
        </button>
    </form>

    <!-- Boton reenviar codigo -->
    <form method="POST" class="mt-4 text-center">
        <input type="hidden" name="reenviar_codigo" value="0">
        <button type="submit" class="text-black-600 hover:underline font-medium text-sm sm:text-base">
            ¿No recibiste el correo? Reenviar codigo
        </button>
    </form>

    <!-- Notificacion de errores -->
    <div class="text-sm mt-4 text-center">
        <?php if (!empty($errores)): ?>
            <div class="bg-red-100 text-red-800 p-3 rounded mb-4 text-center font-semibold flex items-center justify-center text-sm sm:text-base">
                <img src="../Imagenes/error.png" alt="Icono de error" class="w-5 h-5 sm:w-6 sm:h-6 mr-2">
                <?php echo $errores; ?>
            </div>
        <?php endif; ?>
        <?php if (!empty($mensaje)): ?>
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4 text-center font-semibold flex items-center justify-center text-sm sm:text-base">
                <img src="../Imagenes/correcto.png" alt="Icono de éxito" class="w-5 h-5 sm:w-6 sm:h-6 mr-2">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
<!-- Script para mostrar una cuenta regresiva del tiempo de expiracion del codigo de verificacion -->
<script>
    // Obtenemos el tiempo de expiracion
    const expira = <?php echo $_SESSION['codigoVeri_expira'] ?? time(); ?>;

    // Iniciamos un temporizador que se actualiza cada segundo
    const intervalo = setInterval(() => {
        const ahora = Math.floor(Date.now() / 1000);
        const restante = expira - ahora;

        // Si ya expiró, mostramos un mensaje y detenemos el temporizador
        if (restante <= 0) {
            document.getElementById("contador").innerText = "Expirado";
            clearInterval(intervalo);
        } else {
            // Calculamos minutos y segundos restantes y los mostramos
            const minutos = Math.floor(restante / 60);
            const segundos = restante % 60;
            document.getElementById("contador").innerText = `${minutos}:${segundos.toString().padStart(2, '0')}`;
        }
    }, 1000);
</script>
