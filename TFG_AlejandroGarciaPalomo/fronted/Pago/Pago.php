<?php
global $cursoPrecio;
require '../../funcion_pago.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario Pago</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="../Imagenes/logo.png" type="image/png">
    <script>
        //Esta funcion lo que hara es mostrar el formulario de pago dependiendo del metedo de pago que seleccionemos
        function elegirOpcion() {
            document.getElementById("tarjetaM").style.display = "none";
            document.getElementById("tarjetaB").style.display = "none";
            document.getElementById("tarjetaP").style.display = "none";

            const opcion = document.querySelector('input[name="metodo"]:checked');
            if (!opcion) return;

            if (opcion.value === "tarjeta") {
                document.getElementById("tarjetaM").style.display = "block";
            } else if (opcion.value === "bizum") {
                document.getElementById("tarjetaB").style.display = "block";
            } else if (opcion.value === "paypal") {
                document.getElementById("tarjetaP").style.display = "block";
            }
        }


        //Array de paises
        const paises = [
            "España", "Alemania", "Francia", "Italia", "Rumania", "Belgica", "Andorra"
        ];
        //Esta funcion lo que hara sera crear opciones para el select para mostrar los paises disponibles
        function crearOpciones(){

            const select = document.getElementById("pais");

            // Crear las opciones para cada pais
            paises.forEach(pais => {
                const opcion = document.createElement("option");
                opcion.value = pais;
                opcion.textContent = pais;
                select.appendChild(opcion);
            });
        }
        window.onload = crearOpciones;

    </script>
</head>
<body class="relative min-h-screen w-full overflow-x-hidden bg-transparent">

<!-- Video del fondo  -->
<video autoplay muted loop playsinline
       class="fixed inset-0 w-full h-screen object-cover z-[-10]">
    <source src="../Videos/fondo.mp4" type="video/mp4">
</video>

<!-- Formulario pago  -->
<main class="flex flex-grow justify-center items-center px-6 mt-10">
    <div class="flex flex-col md:flex-row bg-white p-6 md:p-8 rounded-2xl w-full max-w-4xl mx-auto space-y-6 md:space-y-0 md:space-x-6">
        <!-- Formulario Facturacion -->
        <div class="w-full md:w-1/2 md:pr-6">
            <?php if (!empty($errorDetallesFacturacion)): ?>
                <div class="bg-red-100 text-red-800 p-4 rounded mb-4 text-center font-semibold flex items-center justify-center">
                    <img src="../Imagenes/error.png" alt="Icono de error" class="w-6 h-6 mr-2">
                    <?= htmlspecialchars($errorDetallesFacturacion) ?>
                </div>
            <?php endif; ?>

            <h2 class="text-4xl font-bold text-gray-800 text-center mb-6">Detalles de facturacion</h2>

            <form method="post" class="space-y-4">

                <!-- Campo nombre -->
                <label class="block text-black mt-2">Nombre</label>
                <input type="text" name="nombre_user" class="w-full p-2 border rounded mb-2 bg-gray-200 text-gray-500" placeholder="<?= htmlspecialchars($_SESSION['nombre']) ?>" readonly>

                <!-- Campo apellido -->
                <label class="block text-black mt-2">Apellido</label>
                <input type="text" name="apellido_user" class="w-full p-2 border rounded mb-2 bg-gray-200 text-gray-500" placeholder="<?= htmlspecialchars($_SESSION['apellidos']) ?>" readonly>

                <!-- Campo Pais -->
                <label class="block text-black mt-2">Pais</label>
                <select name="pais" id="pais" class="w-full p-2 border rounded mb-4 bg-white">
                    <option value="Selecciona tu pais">Selecciona tu pais</option>
                </select>

                <!-- Campo correo electronico -->
                <label class="block text-black mt-2">Correo electronico</label>
                <input type="text" name="correo_electronico_user" class="w-full p-2 border rounded mb-2 bg-gray-200 text-gray-500" placeholder="<?= htmlspecialchars($_SESSION['correo']) ?>" readonly >

                <!-- Campo telefono -->
                <label class="block text-black mt-2">Telefono</label>
                <input type="text" name="telefono_user" class="w-full p-2 border rounded mb-4 bg-white" placeholder="Ej:123 456 789" required>

                <!-- Campo dni -->
                <label class="block text-black mt-2">DNI</label>
                <input type="text" name="dni_user" class="w-full p-2 border rounded mb-4 bg-white" placeholder="Ej:12345678Y" required>
            </form>

            <!-- Precio total de la compra -->
            <h3 class="text-2xl font-semibold text-gray-800 text-center mt-4">Precio total: <?= htmlspecialchars($cursoPrecio) ?>€</h3>

        </div>


        <div class="w-full md:w-1/2 md:pl-6">
            <!-- Notificacion de errores -->
            <?php if (!empty($errorTarjeta)): ?>
                <div class="bg-red-100 text-red-800 p-4 rounded mb-4 text-center font-semibold flex items-center justify-center">
                    <img src="../Imagenes/error.png" alt="Icono de error" class="w-6 h-6 mr-2">
                    <?= htmlspecialchars($errorTarjeta) ?>
                </div>
            <?php endif; ?>
            <?php if (!empty($errorBizum)): ?>
                <div class="bg-red-100 text-red-800 p-4 rounded mb-4 text-center font-semibold flex items-center justify-center">
                    <img src="../Imagenes/error.png" alt="Icono de error" class="w-6 h-6 mr-2">
                    <?= htmlspecialchars($errorBizum) ?>
                </div>
            <?php endif; ?>
            <?php if (!empty($errorPaypal)): ?>
                <div class="bg-red-100 text-red-800 p-4 rounded mb-4 text-center font-semibold flex items-center justify-center">
                    <img src="../Imagenes/error.png" alt="Icono de error" class="w-6 h-6 mr-2">
                    <?= htmlspecialchars($errorPaypal) ?>
                </div>
            <?php endif; ?>
            <h2 class="text-4xl font-bold text-gray-800 text-center mb-6">Metodo de Pago</h2>

            <div class="text-black flex flex-col space-y-6">
                <label class="flex items-center">
                    <input type="radio" name="metodo" value="tarjeta" class="mr-2" onclick="elegirOpcion()"> Tarjeta
                </label>

                <!-- Metodo de pago(Tarjeta) -->
                <div id="tarjetaM" style="display: none;">
                    <form method="post" id="formTarjeta" class="space-y-4">
                        <input type="hidden" name="pago_tarjeta" value="1">
                        <input type="hidden" name="pais" value="" id="paisHiddenTarjeta">
                        <input type="hidden" name="telefono_user" value="" id="telefonoHiddenTarjeta">
                        <input type="hidden" name="dni_user" value="" id="dniHiddenTarjeta">
                        <input type="hidden" name="precio_user" value="<?= htmlspecialchars($cursoPrecio) ?>">
                        <input type="hidden" name="nombre_user" value="<?= htmlspecialchars($_SESSION['nombre']) ?>">
                        <input type="hidden" name="apellido_user" value="<?= htmlspecialchars($_SESSION['apellidos']) ?>">
                        <input type="hidden" name="correo_electronico_user" value="<?= htmlspecialchars($_SESSION['correo']) ?>">

                        <label class="block text-black mt-2">Nombre del titular</label>
                        <input type="text" name="nombre_titular" class="w-full p-2 border rounded mb-2" placeholder="Ej: Nombre 1Apellido 2Apellido" required>

                        <label class="block text-black">Numero de la tarjeta</label>
                        <input type="text" name="numero_tarjeta" class="w-full p-2 border rounded mb-2" placeholder="Ej:1234 5678 9123 4657" required>

                        <label class="block text-black">Fecha de expiracion</label>
                        <input type="text" name="fecha_expiracion" class="w-full p-2 border rounded mb-2" placeholder="Ej: xx/xx" required>

                        <label class="block text-black">CVC</label>
                        <input type="text" name="cvc" class="w-full p-2 border rounded mb-4" placeholder="Ej: xxx" required>

                        <button type="button" onclick="prepararEnvioTarjeta()"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full">
                            Confirmar pago con Tarjeta
                        </button>
                    </form>
                </div>


                <label class="flex items-center">
                    <input type="radio" name="metodo" value="bizum" class="mr-2" onclick="elegirOpcion()"> Bizum
                </label>

                <!-- Metodo de pago(Bizum) -->
                <div id="tarjetaB" style="display: none;">
                    <form method="post" id="formBizum" class="space-y-4">
                        <input type="hidden" name="precio_user" value="<?= htmlspecialchars($cursoPrecio) ?>">
                        <input type="hidden" name="pago_bizum" value="1">
                        <input type="hidden" name="nombre_user" value="<?= htmlspecialchars($_SESSION['nombre']) ?>">
                        <input type="hidden" name="apellido_user" value="<?= htmlspecialchars($_SESSION['apellidos']) ?>">
                        <input type="hidden" name="pais" value="" id="paisHidden">
                        <input type="hidden" name="correo_electronico_user" value="<?= htmlspecialchars($_SESSION['correo']) ?>">
                        <input type="hidden" name="telefono_user" value="" id="telefonoHidden">
                        <input type="hidden" name="dni_user" value="" id="dniHidden">
                        <label class="block text-black mt-2">Numero de telefono</label>
                        <input type="tel" name="telefonoBizum" class="w-full p-2 border rounded mb-4" placeholder="Ej: 123 456 789" required>
                        <button type="button" onclick="prepararEnvioBizum()"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full">
                            Confirmar pago con Bizum
                        </button>
                    </form>
                </div>

                <label class="flex items-center">
                    <input type="radio" name="metodo" value="paypal" class="mr-2" onclick="elegirOpcion()"> PayPal
                </label>

                <!-- Metodo de pago(Paypal) -->
                <div id="tarjetaP" style="display: none;">
                    <form method="post" id="formPaypal" class="space-y-4">
                        <input type="hidden" name="precio_user" value="<?= htmlspecialchars($cursoPrecio) ?>">
                        <input type="hidden" name="nombre_user" value="<?= htmlspecialchars($_SESSION['nombre']) ?>">
                        <input type="hidden" name="apellido_user" value="<?= htmlspecialchars($_SESSION['apellidos']) ?>">
                        <input type="hidden" name="pais" value="" id="paisHiddenPaypal">
                        <input type="hidden" name="correo_electronico_user" value="<?= htmlspecialchars($_SESSION['correo']) ?>">
                        <input type="hidden" name="dni_user" value="" id="dniHiddenPaypal">
                        <input type="hidden" name="telefono_user" value="" id="telefonoHiddenPaypal">
                        <input type="hidden" name="pago_paypal" value="1">
                        <label class="block text-black mt-2">Numero de telefono</label>
                        <input type="tel" name="telefonoPay" class="w-full p-2 border rounded mb-4" placeholder="Ej: 123 456 789" required>

                        <button type="button" onclick="prepararEnvioPaypal()"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full">
                            Confirmar pago con PayPal
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

</body>
</html>
<script>
    //Esta funcion lo que hara es coger los datos de el formulario de facturacion cuando pagemos con bizum
    function prepararEnvioBizum() {
        document.getElementById('paisHidden').value = document.getElementById('pais').value;
        document.getElementById('telefonoHidden').value = document.querySelector('input[name="telefono_user"]').value;
        document.getElementById('dniHidden').value = document.querySelector('input[name="dni_user"]').value;
        document.getElementById('formBizum').submit();
    }
    //Esta funcion lo que hara es coger los datos de el formulario de facturacion cuando pagemos con paypal
    function prepararEnvioPaypal() {
        document.getElementById('paisHiddenPaypal').value = document.getElementById('pais').value;
        document.getElementById('telefonoHiddenPaypal').value = document.querySelector('input[name="telefono_user"]').value;
        document.getElementById('dniHiddenPaypal').value = document.querySelector('input[name="dni_user"]').value;
        document.getElementById('formPaypal').submit();
    }
    //Esta funcion lo que hara es coger los datos de el formulario de facturacion cuando pagemos con tarjeta
    function prepararEnvioTarjeta() {
        document.getElementById('paisHiddenTarjeta').value = document.getElementById('pais').value;
        document.getElementById('telefonoHiddenTarjeta').value = document.querySelector('input[name="telefono_user"]').value;
        document.getElementById('dniHiddenTarjeta').value = document.querySelector('input[name="dni_user"]').value;
        document.getElementById('formTarjeta').submit();
    }

</script>