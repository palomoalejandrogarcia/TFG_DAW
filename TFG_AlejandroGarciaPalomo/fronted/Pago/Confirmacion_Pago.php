<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmacion pago</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="../Imagenes/logo.png" type="image/png">

</head>

<body class="min-h-screen flex items-center justify-center relative overflow-hidden">

<!-- Video del fondo  -->
<video autoplay muted loop playsinline
       class="fixed inset-0 w-full h-screen object-cover z-[-10]">
    <source src="../Videos/fondo.mp4" type="video/mp4">
</video>

<!-- Mensaje de confirmacion  -->
<main class="w-full max-w-md mx-auto">
    <div class="w-full h-full p-6 bg-white bg-white shadow-lg rounded-lg text-center flex flex-col justify-center items-center">
        <img src="../Imagenes/correcto.png" width="50" height="50" class="mx-auto">
        <h2 class="text-2xl font-bold text-green-600 mb-2">¡Pago realizado con exito!</h2>
        <p class="text-gray-700">Gracias por tu compra. Hemos recibido tu pago correctamente.</p>
        <p class="text-gray-500 mt-2 text-sm">Se ha enviado la factura de tu compra a tu correo electronico.</p>
        <a href="../Usuario/Inicio.php" class="mt-6 inline-block bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded">
            Volver al inicio
        </a>
    </div>
</main>

</body>

</html>